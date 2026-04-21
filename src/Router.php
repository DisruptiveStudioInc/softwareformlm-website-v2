<?php

namespace App;

use App\Services\WordPressClient;

class Router
{
  private const LANGUAGE_COOKIE_NAME = 'site_language';
  private const LANGUAGE_COOKIE_TTL = 31536000;

  private array $routes = [];
  private string $currentLanguage;
  private array $availableLanguages;
  private string $defaultLanguage;
  private ?array $routeTranslations = null;
  private ?WordPressClient $wordPressClient = null;
  private bool $wordPressClientInitialized = false;

  public function __construct(array $languages)
  {
    $this->availableLanguages = $languages['available'];
    $this->defaultLanguage = $languages['default'];
    $this->currentLanguage = $this->defaultLanguage;
  }

  public function get(string $path, string $controller, string $method): void
  {
    $this->addRoute('GET', $path, $controller, $method);
  }

  public function post(string $path, string $controller, string $method): void
  {
    $this->addRoute('POST', $path, $controller, $method);
  }

  private function addRoute(string $httpMethod, string $path, string $controller, string $method): void
  {
    $this->routes[] = [
      'method' => $httpMethod,
      'path' => $path,
      'controller' => $controller,
      'action' => $method,
    ];
  }

  public function dispatch(Request $request): Response
  {
    $uri = $request->getUri();
    $uriLanguage = $this->detectLanguageFromUri($uri);
    $contentLanguage = $this->detectContentLanguage($uri, $uriLanguage);
    $decision = $this->resolveLanguageDecision($request, $uri, $contentLanguage);

    if ($decision['persist_language'] !== null) {
      $this->persistLanguageCookie($decision['persist_language']);
    }

    $this->currentLanguage = $decision['current_language'];

    if ($decision['redirect_url'] !== null) {
      return $this->redirectResponse($decision['redirect_url']);
    }

    $cleanUri = $this->removeLanguagePrefix($uri, $uriLanguage);
    $httpMethod = $request->getMethod();

    foreach ($this->routes as $route) {
      $params = [];
      if ($route['method'] === $httpMethod && $this->matchPath($route['path'], $cleanUri, $params)) {
        $request->setRouteParams($params);
        return $this->callController($route['controller'], $route['action'], $request);
      }
    }

    return $this->callController('App\\Controllers\\ErrorController', 'notFound', $request);
  }

  private function resolveLanguageDecision(Request $request, string $uri, string $contentLanguage): array
  {
    $queryParams = $request->getQuery();
    $requestedUrl = $this->buildCurrentUrl($uri, $queryParams, false);
    $cleanRequestedUrl = $this->buildCurrentUrl($uri, $queryParams, true);
    $manualLanguage = $this->normalizeLanguage($request->getQuery('set_lang'));
    $cookieLanguage = $this->normalizeLanguage($request->getCookie(self::LANGUAGE_COOKIE_NAME));

    if ($manualLanguage !== null) {
      $targetUrl = $this->buildEquivalentLanguageUrl($uri, $manualLanguage, $queryParams, true) ?? $cleanRequestedUrl;

      return [
        'current_language' => $manualLanguage,
        'persist_language' => $manualLanguage,
        'redirect_url' => $this->shouldRedirect($request) && $targetUrl !== $requestedUrl ? $targetUrl : null,
      ];
    }

    if ($cookieLanguage !== null) {
      $targetUrl = $this->buildEquivalentLanguageUrl($uri, $cookieLanguage, $queryParams, true);

      return [
        'current_language' => $targetUrl === null ? $contentLanguage : $cookieLanguage,
        'persist_language' => null,
        'redirect_url' => $this->shouldRedirect($request) && $targetUrl !== null && $targetUrl !== $cleanRequestedUrl ? $targetUrl : null,
      ];
    }

    $preferredLanguage = $this->detectInitialLanguage($request, $uri);
    $targetUrl = $this->buildEquivalentLanguageUrl($uri, $preferredLanguage, $queryParams, true);

    return [
      'current_language' => $targetUrl === null ? $contentLanguage : $preferredLanguage,
      'persist_language' => $preferredLanguage,
      'redirect_url' => $this->shouldRedirect($request) && $targetUrl !== null && $targetUrl !== $cleanRequestedUrl ? $targetUrl : null,
    ];
  }

  private function detectInitialLanguage(Request $request, string $uri): string
  {
    $uriLanguage = $this->detectLanguageFromUri($uri);

    if ($uriLanguage !== $this->defaultLanguage) {
      return $uriLanguage;
    }

    return $this->detectBrowserLanguage((string) $request->getHeader('Accept-Language', ''));
  }

  private function detectBrowserLanguage(string $acceptLanguageHeader): string
  {
    if ($acceptLanguageHeader === '') {
      return 'en';
    }

    $languages = [];

    foreach (explode(',', $acceptLanguageHeader) as $index => $languagePart) {
      $languagePart = trim($languagePart);

      if ($languagePart === '') {
        continue;
      }

      $segments = explode(';q=', $languagePart);
      $code = strtolower(trim($segments[0]));
      $quality = isset($segments[1]) ? (float) $segments[1] : 1.0;

      $languages[] = [
        'code' => $code,
        'quality' => $quality,
        'index' => $index,
      ];
    }

    usort($languages, static function (array $left, array $right): int {
      if ($left['quality'] === $right['quality']) {
        return $left['index'] <=> $right['index'];
      }

      return $right['quality'] <=> $left['quality'];
    });

    foreach ($languages as $language) {
      $primaryLanguage = explode('-', $language['code'])[0];

      if ($primaryLanguage === 'es') {
        return 'es';
      }

      if ($primaryLanguage === 'en') {
        return 'en';
      }
    }

    return 'en';
  }

  private function detectLanguageFromUri(string $uri): string
  {
    foreach ($this->availableLanguages as $language) {
      if ($language === $this->defaultLanguage) {
        continue;
      }

      if ($uri === "/{$language}" || str_starts_with($uri, "/{$language}/")) {
        return $language;
      }
    }

    return $this->defaultLanguage;
  }

  private function detectContentLanguage(string $uri, string $uriLanguage): string
  {
    $path = trim($this->removeLanguagePrefix($uri, $uriLanguage), '/');

    if ($path === '' || $path === 'blog' || str_starts_with($path, 'blog/')) {
      return $uriLanguage;
    }

    foreach ($this->getRouteTranslations() as $translations) {
      foreach ($translations as $language => $translatedPath) {
        if ($translatedPath !== '' && $translatedPath === $path) {
          return $language;
        }
      }
    }

    return $uriLanguage;
  }

  private function buildEquivalentLanguageUrl(string $uri, string $targetLanguage, array $queryParams = [], bool $stripSetLang = true): ?string
  {
    $filteredQueryParams = $queryParams;

    if ($stripSetLang) {
      unset($filteredQueryParams['set_lang']);
    }

    $uriLanguage = $this->detectLanguageFromUri($uri);
    $path = trim($this->removeLanguagePrefix($uri, $uriLanguage), '/');

    if ($path === '') {
      return \buildUrlWithQuery($this->prefixPath('', $targetLanguage), $filteredQueryParams);
    }

    $staticRouteName = $this->findStaticRouteNameByPath($path);
    if ($staticRouteName !== null) {
      return \buildUrlWithQuery(\route($staticRouteName, $targetLanguage, $this->defaultLanguage), $filteredQueryParams);
    }

    if ($path === 'blog') {
      return \buildUrlWithQuery($this->prefixPath('blog', $targetLanguage), $filteredQueryParams);
    }

    if (preg_match('#^blog/([^/]+)$#', $path, $matches) === 1) {
      $translatedSlug = $this->translateBlogSlug($matches[1], $targetLanguage);

      if ($translatedSlug === null) {
        return null;
      }

      return \buildUrlWithQuery($this->prefixPath('blog/' . $translatedSlug, $targetLanguage), $filteredQueryParams);
    }

    return \buildUrlWithQuery($this->prefixPath($path, $targetLanguage), $filteredQueryParams);
  }

  private function findStaticRouteNameByPath(string $path): ?string
  {
    foreach ($this->getRouteTranslations() as $routeName => $translations) {
      foreach ($translations as $translatedPath) {
        if ($translatedPath !== '' && $translatedPath === $path) {
          return $routeName;
        }
      }
    }

    return null;
  }

  private function translateBlogSlug(string $slug, string $targetLanguage): ?string
  {
    $wordPressClient = $this->getWordPressClient();

    if ($wordPressClient === null) {
      return null;
    }

    try {
      return $wordPressClient->getTranslatedPostSlug($slug, $targetLanguage);
    } catch (\Throwable $throwable) {
      error_log('Blog slug translation failed: ' . $throwable->getMessage());
      return null;
    }
  }

  private function getWordPressClient(): ?WordPressClient
  {
    if ($this->wordPressClientInitialized) {
      return $this->wordPressClient;
    }

    $this->wordPressClientInitialized = true;

    try {
      $this->wordPressClient = new WordPressClient();
    } catch (\Throwable $throwable) {
      error_log('WordPress client unavailable for language routing: ' . $throwable->getMessage());
      $this->wordPressClient = null;
    }

    return $this->wordPressClient;
  }

  private function buildCurrentUrl(string $uri, array $queryParams, bool $stripSetLang): string
  {
    if ($stripSetLang) {
      unset($queryParams['set_lang']);
    }

    return \buildUrlWithQuery($uri, $queryParams);
  }

  private function prefixPath(string $path, string $language): string
  {
    $normalizedPath = trim($path, '/');

    if ($language === $this->defaultLanguage) {
      return $normalizedPath === '' ? '/' : '/' . $normalizedPath;
    }

    return $normalizedPath === '' ? '/' . $language : '/' . $language . '/' . $normalizedPath;
  }

  private function normalizeLanguage(mixed $language): ?string
  {
    if (!is_string($language)) {
      return null;
    }

    $normalizedLanguage = strtolower(trim($language));

    return in_array($normalizedLanguage, $this->availableLanguages, true) ? $normalizedLanguage : null;
  }

  private function persistLanguageCookie(string $language): void
  {
    setcookie(self::LANGUAGE_COOKIE_NAME, $language, [
      'expires' => time() + self::LANGUAGE_COOKIE_TTL,
      'path' => '/',
      'samesite' => 'Lax',
    ]);

    $_COOKIE[self::LANGUAGE_COOKIE_NAME] = $language;
  }

  private function shouldRedirect(Request $request): bool
  {
    return in_array($request->getMethod(), ['GET', 'HEAD'], true);
  }

  private function removeLanguagePrefix(string $uri, string $uriLanguage): string
  {
    if ($uriLanguage === $this->defaultLanguage) {
      return $uri;
    }

    $prefix = "/{$uriLanguage}";

    if (!str_starts_with($uri, $prefix)) {
      return $uri;
    }

    $trimmedUri = substr($uri, strlen($prefix));

    return $trimmedUri === '' ? '/' : $trimmedUri;
  }

  private function getRouteTranslations(): array
  {
    if ($this->routeTranslations === null) {
      $this->routeTranslations = require __DIR__ . '/../config/route-translations.php';
    }

    return $this->routeTranslations;
  }

  private function matchPath(string $routePath, string $uri, array &$params = []): bool
  {
    if ($routePath === $uri) {
      return true;
    }

    preg_match_all('/\{([^}]+)\}/', $routePath, $paramNames);

    $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $routePath);
    $pattern = "#^$pattern$#";

    if (preg_match($pattern, $uri, $matches)) {
      array_shift($matches);

      foreach ($paramNames[1] as $index => $name) {
        if (isset($matches[$index])) {
          $params[$name] = $matches[$index];
        }
      }

      return true;
    }

    return false;
  }

  private function callController(string $controller, string $method, Request $request): Response
  {
    if (!class_exists($controller)) {
      return $this->errorResponse("Controller $controller not found");
    }

    $instance = new $controller();

    if (!method_exists($instance, $method)) {
      return $this->errorResponse("Method $method not found in $controller");
    }

    if (method_exists($instance, 'setLanguage')) {
      $instance->setLanguage($this->currentLanguage);
    }

    return $instance->$method($request);
  }

  private function redirectResponse(string $url, int $statusCode = 302): Response
  {
    $response = new Response();

    return $response
      ->setStatusCode($statusCode)
      ->setHeader('Location', $url);
  }

  private function errorResponse(string $message): Response
  {
    $response = new Response();
    return $response->setStatusCode(500)->setContent($message);
  }

  public function getCurrentLanguage(): string
  {
    return $this->currentLanguage;
  }
}
