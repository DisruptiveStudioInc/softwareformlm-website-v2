<?php

/**
 * Escape HTML output
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Alias for htmlspecialchars
 */
function esc(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Split array in halfs
 */
function split_array_in_half(array $array): array {
  $midpoint = ceil(count($array) / 2);
  $first_half = array_slice($array, 0, $midpoint);
  $second_half = array_slice($array, $midpoint);
  return [$first_half, $second_half];
}

/**
 * Split array in 3 parts
 */
function split_array_in_thirds(array $array): array {
  $total = count($array);
  if ($total === 0) {
    return [[], [], []];
  }

  $part_size = ceil($total / 3);

  $first_part = array_slice($array, 0, $part_size);
  $second_part = array_slice($array, $part_size, $part_size);
  $third_part = array_slice($array, $part_size * 2);

  return [$first_part, $second_part, $third_part];
}

/**
 * Split array in four parts
 */
function split_array_in_quarters(array $array): array {
  $count = count($array);
  $quarter_size = ceil($count / 4);

  $first_quarter = array_slice($array, 0, $quarter_size);
  $second_quarter = array_slice($array, $quarter_size, $quarter_size);
  $third_quarter = array_slice($array, $quarter_size * 2, $quarter_size);
  $fourth_quarter = array_slice($array, $quarter_size * 3);

  return [$first_quarter, $second_quarter, $third_quarter, $fourth_quarter];
}

/**
 * Generate URL for a route in the current or specified language
 */
function route(string $routeName, string $lang, string $defaultLang = 'en', array $params = []): string
{
  static $routes = null;

  // Load routes configuration once
  if ($routes === null) {
    $routes = require __DIR__ . '/../config/route-translations.php';
  }

  // Get the route path in the target language
  $path = $routes[$routeName][$lang] ?? $routeName;

  // Replace parameters in path (for future use with dynamic routes)
  foreach ($params as $key => $value) {
    $path = str_replace('{' . $key . '}', $value, $path);
  }

  // Build final URL
  if ($lang === $defaultLang) {
    return '/' . $path;
  }

  return '/' . $lang . ($path ? '/' . $path : '');
}

/**
 * Generate URL for a service in the current or specified language
 */
function serviceRoute(string $serviceSlug, string $lang, string $defaultLang = 'en'): string
{

  if ($lang === $defaultLang) {
    return '/' . $serviceSlug;
  }

  return '/' . $lang . '/' . $serviceSlug;
}

/**
 * Get language-switched URL
 */
function getLanguageSwitchUrl(string $currentUri, string $currentLang, string $targetLang, string $defaultLang): string
{
  // Remove leading slash
  $path = ltrim($currentUri, '/');

  // Remove current language prefix if present
  if ($currentLang !== $defaultLang && str_starts_with($path, $currentLang . '/')) {
    $path = substr($path, strlen($currentLang) + 1);
  } elseif ($currentLang !== $defaultLang && $path === $currentLang) {
    $path = '';
  }

  // Handle root/home
  if (empty($path)) {
    return $targetLang === $defaultLang ? '/' : '/' . $targetLang;
  }

  // Static routes mapping
  $routeTranslations = require __DIR__ . '/../config/route-translations.php';
  $staticRoutes = [];
  foreach ($routeTranslations as $routeName => $langs) {
    if ($routeName === 'home') {
      continue;
    }
    foreach ($langs as $lang => $translatedPath) {
      if ($translatedPath !== '') {
        $staticRoutes[$translatedPath][$lang] = $translatedPath;
      }
    }
  }

  // Check if it's a static route
  foreach ($staticRoutes as $routes) {
    if (in_array($path, $routes)) {
      $translatedPath = $routes[$targetLang] ?? $path;
      return $targetLang === $defaultLang ? '/' . $translatedPath : '/' . $targetLang . '/' . $translatedPath;
    }
  }

  // Try to translate service slug
  $translatedSlug = \App\Models\Service::getTranslatedSlug($path, $currentLang, $targetLang);

  if ($translatedSlug !== null) {
    return $targetLang === $defaultLang ? '/' . $translatedSlug : '/' . $targetLang . '/' . $translatedSlug;
  }

  // Fallback: return path as-is with language prefix
  return $targetLang === $defaultLang ? '/' . $path : '/' . $targetLang . '/' . $path;
}

function getServiceSubcategoryName(string $lang): array{
  $subcategoryLabels = require __DIR__ . '/../config/subcategories.php';
  $subcatServices = \App\Models\Service::getServiceSubcategories();
  $subcategories = [];
  foreach($subcatServices as $key => $item){
    $subcategories[] = [
      'key' => $item,
      'name' => $subcategoryLabels[$item][$lang] ?? $item,
      'description' => $subcategoryLabels[$item]['description'] ?? ''
    ];
  }
  return $subcategories;
}

function getNavigationMenu(string $lang, callable $trans): array {
  $subcategoryLabels = require __DIR__ . '/../config/subcategories.php';
  $servicesGrouped = \App\Models\Service::getServicesGroupedBySubcategory($lang);
  $subSolutions = [];
  foreach($servicesGrouped as $subcategory => $items){
    $subcatName = $subcategoryLabels[$subcategory][$lang] ?? $subcategory;
    $subcat = [
      'name' => $subcatName,
      'list' => []
    ];
    foreach($items as $item){
      $subcat['list'][] = [
        'label' => $item['meta']['meta_title'],
        'url' => serviceRoute($item['meta']['slug'], $lang)
      ];
    }
    array_push($subSolutions, $subcat);
  }
  // $partReferral = \App\Models\Service::getBySubcategory('referral-marketing', $lang);
  // $partHr = \App\Models\Service::getBySubcategory('hr', $lang);
  // $partCreative = \App\Models\Service::getBySubcategory('creative-services', $lang);
  // $subSolutions = array_values(array_merge(
  //   is_array($partReferral) ? $partReferral : [],
  //   is_array($partCreative) ? $partCreative : [],
  //   is_array($partHr) ? $partHr : [],
  // ));
  $subEcosystem = \App\Models\Service::getByCategory('ecosystem', $lang);
  $subIps = \App\Models\Service::getNavIps($lang);
  return [
    [
      'label' => $trans('nav.home'),
      'url' => route('home', $lang).'#home',
      'hasSubmenu' => false,
      'isMegamenu' => false
    ],
    [
      'label' => $trans('nav.sfmlm'),
      'url' => route('home', $lang).'#sfmlm',
      'hasSubmenu' => false,
      'isMegamenu' => false
    ],
    [
      'label' => $trans('nav.plans'),
      'url' => route('home', $lang).'#plans',
      'hasSubmenu' => false,
      'isMegamenu' => false
    ],
    [
      'label' => $trans('nav.blog'),
      'url' => route('blog', $lang),
      'hasSubmenu' => false,
      'isMegamenu' => false
    ]
  ];
}

function generateBackground(string $fileName, int $amount, bool $reverse = false): void{
  $timing = 5;
  $duration = $amount * $timing;
  $images = range(1, $amount);
  $images = $reverse ? array_reverse($images) : $images;

  echo "<div class='absolute -z-1 w-full h-full top-0 left-0'>";
  foreach($images as $index => $item) {
    $delay = $index * $timing;
    echo $index===0 ?
      "<img class='background' src='/public/images/background/{$fileName}-0{$item}.webp' alt='' loading='lazy'>":
      "<img class='background opacity-0 animate-cycle' src='/public/images/background/{$fileName}-0{$item}.webp' alt='' loading='lazy' style='animation-duration:{$duration}s;animation-delay:{$delay}s'>";
  }
  echo "</div>";
}

/**
 * Load all PHP files inside lang/services and return an assoc array:
 *   [ 'aplicaciones-hibridas' => <returned value from file> , ... ]
 *
 * Note: for predictable results each service file should `return` its array (preferred).
 * If a file doesn't return a value `require` yields 1.
 */
function loadLangDynamic(string $servicesDir = ''): array
{
  $dir = $servicesDir === '' ? __DIR__ . '/../lang/services' : $servicesDir;
  if (!is_dir($dir)) {
    return [];
  }

  $files = glob(rtrim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '*.php');
  sort($files, SORT_STRING);

  $services = [];
  foreach ($files as $file) {
    $key = pathinfo($file, PATHINFO_FILENAME);
    // include in function scope so any "return" in the file is captured
    $value = require $file;
    $services[$key] = $value;
  }

  return $services;
}
