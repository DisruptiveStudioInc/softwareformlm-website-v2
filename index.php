<?php

// Load Composer autoloader
require __DIR__ . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Error handling based on environment
$config = require __DIR__ . '/config/config.php';

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
  // ---------------------------------------------------------
  // ### FIX LCP: HTTP Header Preload (Turbo Boost)
  // Esto le grita al navegador que descargue la imagen YA,
  // incluso antes de procesar el HTML.
  // ---------------------------------------------------------
  $lcpImage = '/public/images/background/black-01.webp'; // La ruta que vimos en el reporte
  header("Link: <$lcpImage>; rel=preload; as=image; fetchpriority=high");
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
