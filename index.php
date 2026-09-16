<?php
function shouldStartSession(): bool
{
  if ($_SERVER['REQUEST_METHOD'] !== 'GET' && $_SERVER['REQUEST_METHOD'] !== 'HEAD') {
    return true;
  }

  if (!empty($_GET['ref'])) {
    return true;
  }

  return !empty($_COOKIE[session_name()]);
}

session_cache_limiter('');

$hasSession = shouldStartSession();
if ($hasSession) {
  session_start();
}

// Load Composer autoloader
require __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Error handling based on environment
$config = require __DIR__ . '/config/config.php';

/* handles sponsor url */
$ref = $_GET['ref'] ?? NULL;
$user_replica = 'parentless';

if (!empty($ref)){
    $ref = rtrim($ref, '/');
    $url_parts = explode('/', $ref);
    $user_replica = $url_parts[0];
    $_SESSION['ref'] = $user_replica;
}else if($hasSession && !empty($_SESSION['ref']) ){
    $user_replica = $_SESSION['ref'];
}

// Make $user_replica available globally throughout the application
$GLOBALS['user_replica'] = $user_replica;

// Add debugging for development
if ($config['app']['debug']) {
  ini_set('display_startup_errors', 1);
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
}

// Load helper functions
require __DIR__ . '/src/helpers.php';

if ($config['app']['debug']) {
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
} else {
  error_reporting(0);
  ini_set('display_errors', 0);
}

// Create request and router instances
$request = new App\Request();
$router = new App\Router($config['languages']);

// Load routes
$routeLoader = require __DIR__ . '/config/routes.php';
$routeLoader($router);

// Dispatch request and send response
try {
  $response = $router->dispatch($request);
  $method = $request->getMethod();
  $hasRef = !empty($_GET['ref']);
  $hasSessionCookie = !empty($_COOKIE[session_name()]);
  $contentType = $response->getHeader('Content-Type') ?? '';
  $isHtmlResponse = !str_contains($contentType, 'application/json');
  $isSuccessfulGet = in_array($method, ['GET', 'HEAD'], true) && $response->getStatusCode() === 200;
  $isCacheableDocument = $isSuccessfulGet && $isHtmlResponse && !$hasRef && !$hasSession && !$hasSessionCookie;

  if ($isHtmlResponse) {
    header('Vary: Accept-Language, Cookie');
  }

  if ($isCacheableDocument) {
    header('Cache-Control: public, max-age=0, s-maxage=300, stale-while-revalidate=86400');
  } else {
    header('Cache-Control: private, no-store, no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
  }

  // ---------------------------------------------------------
  $response->send();
} catch (Throwable $e) {
  // Log error
  error_log($e->getMessage());

  // Show error page
  if ($config['app']['debug']) {
    echo "<h1>Error</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
  } else {
    http_response_code(500);
    echo "<h1>500 Internal Server Error</h1>";
    echo "<p>Something went wrong. Please try again later.</p>";
  }
}
