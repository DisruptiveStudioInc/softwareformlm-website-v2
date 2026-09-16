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
 * Generate a cache-busted local asset URL using the file modification time.
 */
function asset_url(string $path): string
{
  $normalizedPath = '/' . ltrim($path, '/');
  $fullPath = __DIR__ . '/..' . $normalizedPath;

  if (!file_exists($fullPath)) {
    return $normalizedPath;
  }

  $version = filemtime($fullPath);

  return $version === false
    ? $normalizedPath
    : sprintf('%s?v=%s', $normalizedPath, $version);
}

/**
 * Render animation-ready words without measuring or rewriting text in the browser.
 * Whitespace is kept outside the spans so assistive technology reads natural text.
 */
function animated_words(string $text, string $wordClasses = ''): string
{
  $parts = preg_split('/(\s+)/u', trim($text), -1, PREG_SPLIT_DELIM_CAPTURE);
  if ($parts === false) {
    return e($text);
  }

  $wordIndex = 0;
  $html = '';
  foreach ($parts as $part) {
    if (preg_match('/^\s+$/u', $part) === 1) {
      $html .= $part;
      continue;
    }

    $wordIndex++;
    $classes = trim('animated-word word' . $wordIndex . ' ' . $wordClasses);
    $html .= sprintf('<span class="%s">%s</span>', e($classes), e($part));
  }

  return $html;
}

/**
 * Return intrinsic dimensions for a local public image, cached per request.
 */
function image_dimensions(string $path): string
{
  static $dimensions = [];
  $normalizedPath = '/' . ltrim($path, '/');

  if (array_key_exists($normalizedPath, $dimensions)) {
    return $dimensions[$normalizedPath];
  }

  $fullPath = __DIR__ . '/..' . $normalizedPath;
  $size = is_file($fullPath) ? @getimagesize($fullPath) : false;
  $dimensions[$normalizedPath] = $size === false
    ? ''
    : sprintf('width="%d" height="%d"', $size[0], $size[1]);

  return $dimensions[$normalizedPath];
}

/**
 * Shared candidates for picture markup and its responsive preload.
 * @return array{remote: bool, path: string, width: int|null, height: int|null, sources: array<string, list<string>>}
 */
function responsive_image_data(string $path): array
{
  $isRemote = preg_match('#^https?://#i', $path) === 1;
  $normalizedPath = $isRemote ? $path : '/' . ltrim($path, '/');
  $fullPath = $isRemote ? null : __DIR__ . '/..' . $normalizedPath;
  $extension = strtolower(pathinfo(parse_url($normalizedPath, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));
  $basePath = $extension === '' ? $normalizedPath : substr($normalizedPath, 0, -(strlen($extension) + 1));
  $metadata = $fullPath !== null && is_file($fullPath) ? @getimagesize($fullPath) : false;
  $width = $metadata[0] ?? null;
  $height = $metadata[1] ?? null;
  $candidateWidths = [384, 480, 640, 768, 850, 960];
  $sources = ['avif' => [], 'webp' => []];

  if (!$isRemote) {
    foreach ($candidateWidths as $candidateWidth) {
      foreach (array_keys($sources) as $format) {
        $candidatePath = sprintf('%s-w%d.%s', $basePath, $candidateWidth, $format);
        if (is_file(__DIR__ . '/..' . $candidatePath)) {
          $sources[$format][] = asset_url($candidatePath) . ' ' . $candidateWidth . 'w';
        }
      }
    }

    $hasOriginalWidth = $width !== null && array_filter(
      $sources['webp'],
      static fn (string $source): bool => str_ends_with($source, ' ' . $width . 'w'),
    ) !== [];
    if ($extension === 'webp' && $width !== null && !$hasOriginalWidth) {
      $sources['webp'][] = asset_url($normalizedPath) . ' ' . $width . 'w';
    }
  }

  return ['remote' => $isRemote, 'path' => $normalizedPath, 'width' => $width,
    'height' => $height, 'sources' => $sources];
}

function responsive_image_preload(string $path, string $sizes): string
{
  $image = responsive_image_data($path);
  foreach ($image['sources'] as $format => $candidates) {
    if ($candidates !== []) {
      // No href fallback: browsers without responsive preload support use the picture.
      return sprintf('<link rel="preload" as="image" type="image/%s" imagesrcset="%s" imagesizes="%s" fetchpriority="high">',
        e($format), e(implode(', ', $candidates)), e($sizes));
    }
  }
  return '';
}

/** Version every local module, including relative static and dynamic imports. */
function javascript_import_map(): string
{
  $imports = [];
  foreach (glob(__DIR__ . '/../public/assets/js/*.js') ?: [] as $file) {
    $path = '/public/assets/js/' . basename($file);
    $imports[$path] = asset_url($path);
  }
  return json_encode(['imports' => $imports], JSON_HEX_TAG | JSON_HEX_AMP | JSON_THROW_ON_ERROR);
}

/**
 * Build a responsive picture using generated AVIF/WebP variants when present.
 *
 * @param array<string, string> $attributes
 */
function responsive_image(
  string $path,
  string $alt,
  string $classes,
  string $sizes,
  array $attributes = []
): string {
  $image = responsive_image_data($path);
  ['remote' => $isRemote, 'path' => $normalizedPath, 'width' => $width,
    'height' => $height, 'sources' => $sources] = $image;

  $imgAttributes = array_merge([
    'src' => $isRemote ? $normalizedPath : asset_url($normalizedPath),
    'alt' => $alt,
    'class' => $classes,
    'sizes' => $sizes,
    'decoding' => 'async',
  ], $attributes);
  if ($width !== null && $height !== null) {
    $imgAttributes['width'] = (string) $width;
    $imgAttributes['height'] = (string) $height;
  }

  $serializeAttributes = static function (array $values): string {
    $result = [];
    foreach ($values as $name => $value) {
      $result[] = sprintf('%s="%s"', e((string) $name), e((string) $value));
    }
    return implode(' ', $result);
  };

  $html = '<picture style="display:contents">';
  if ($sources['avif'] !== []) {
    $html .= sprintf('<source type="image/avif" srcset="%s" sizes="%s">', e(implode(', ', $sources['avif'])), e($sizes));
  }
  if (count($sources['webp']) > 1) {
    $html .= sprintf('<source type="image/webp" srcset="%s" sizes="%s">', e(implode(', ', $sources['webp'])), e($sizes));
  }
  $html .= '<img ' . $serializeAttributes($imgAttributes) . '>';
  $html .= '</picture>';

  return $html;
}

/**
 * Format numeric values with comma thousands separators.
 */
function format_number_with_commas(mixed $value): string
{
  if (!is_numeric($value)) {
    return (string) $value;
  }

  return number_format((float) $value, 0, '.', ',');
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
function route(string $routeName, string $lang, string $defaultLang = 'es', array $params = []): string
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
function serviceRoute(string $serviceSlug, string $lang, string $defaultLang = 'es'): string
{

  if ($lang === $defaultLang) {
    return '/' . $serviceSlug;
  }

  return '/' . $lang . '/' . $serviceSlug;
}

function buildUrlWithQuery(string $path, array $queryParams = []): string
{
  if (empty($queryParams)) {
    return $path;
  }

  $queryString = http_build_query($queryParams);

  return $queryString === '' ? $path : $path . '?' . $queryString;
}

function appendLanguageSelectionToUrl(string $url, string $targetLang): string
{
  $parts = parse_url($url);
  $path = $parts['path'] ?? $url;
  $queryParams = [];

  if (!empty($parts['query'])) {
    parse_str($parts['query'], $queryParams);
  }

  unset($queryParams['set_lang']);
  $queryParams['set_lang'] = $targetLang;

  return buildUrlWithQuery($path, $queryParams);
}

/**
 * Get language-switched URL
 */
function getLanguageSwitchUrl(string $currentUri, string $currentLang, string $targetLang, string $defaultLang): string
{
  $parts = parse_url($currentUri);
  $path = ltrim($parts['path'] ?? '/', '/');
  $queryParams = [];

  if (!empty($parts['query'])) {
    parse_str($parts['query'], $queryParams);
  }

  unset($queryParams['set_lang']);

  // Remove leading slash
  // Remove current language prefix if present
  if ($currentLang !== $defaultLang && str_starts_with($path, $currentLang . '/')) {
    $path = substr($path, strlen($currentLang) + 1);
  } elseif ($currentLang !== $defaultLang && $path === $currentLang) {
    $path = '';
  }

  // Handle root/home
  if (empty($path)) {
    $targetPath = $targetLang === $defaultLang ? '/' : '/' . $targetLang;
    return appendLanguageSelectionToUrl(buildUrlWithQuery($targetPath, $queryParams), $targetLang);
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
      $targetPath = $targetLang === $defaultLang ? '/' . $translatedPath : '/' . $targetLang . '/' . $translatedPath;
      return appendLanguageSelectionToUrl(buildUrlWithQuery($targetPath, $queryParams), $targetLang);
    }
  }

  // Try to translate service slug
  $translatedSlug = \App\Models\Service::getTranslatedSlug($path, $currentLang, $targetLang);

  if ($translatedSlug !== null) {
    $targetPath = $targetLang === $defaultLang ? '/' . $translatedSlug : '/' . $targetLang . '/' . $translatedSlug;
    return appendLanguageSelectionToUrl(buildUrlWithQuery($targetPath, $queryParams), $targetLang);
  }

  // Fallback: return path as-is with language prefix
  $targetPath = $targetLang === $defaultLang ? '/' . $path : '/' . $targetLang . '/' . $path;

  return appendLanguageSelectionToUrl(buildUrlWithQuery($targetPath, $queryParams), $targetLang);
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
  $constants = require __DIR__ . '/../config/constants.php';
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
  return [
    [
      'label' => $trans('nav.home'),
      'url' => route('home', $lang).'#home',
      'hasSubmenu' => false,
      'isMegamenu' => false
    ],
    // [
    //   'label' => $trans('nav.sfmlm'),
    //   'url' => route('home', $lang).'#sfmlm',
    //   'hasSubmenu' => false,
    //   'isMegamenu' => false
    // ],
    [
      'label' => $trans('nav.plans'),
      'url' => route('home', $lang).'#plans',
      'hasSubmenu' => false,
      'isMegamenu' => false
    ],
    [
      'label' => $trans('nav.services'),
      // 'url' => route('home', $lang).'#solutions',
      'hasSubmenu' => true,
      'isMegamenu' => true,
      'submenu' => $subSolutions,
    ],
    [
      'label' => $trans('nav.blog'),
      'url' => route('blog', $lang),
      'hasSubmenu' => false,
      'isMegamenu' => false
    ],
    // [
    //   'label' => $trans('nav.buy'),
    //   'url' => $constants['shop_link'],
    //   'hasSubmenu' => false,
    //   'isMegamenu' => false
    // ],
    [
      'label' => $trans('common.login'),
      'url' => $constants['login_link'],
      'hasSubmenu' => false,
      'isMegamenu' => false
    ],
    [
      'label' => $trans('common.register'),
      'url' => $constants['bo_link'].'register/'.$GLOBALS['user_replica'].'?ref=store&store=1',
      'hasSubmenu' => false,
      'isMegamenu' => false
    ],
  ];
}

function getFooterMenu(string $lang, callable $trans): array {
  return [
    [
      'label' => $trans('footer.legal'),
      'items' => [
        [
          'label' => $trans('footer.privacy'),
          'url' => route('privacy', $lang)
        ],
        [
          'label' => $trans('footer.terms'),
          'url' => route('terms', $lang)
        ],
        [
          'label' => $trans('footer.cookies'),
          'url' => route('cookies', $lang)
        ],
        [
          'label' => $trans('footer.refunds'),
          'url' => route('refunds', $lang)
        ]
      ]
    ],
    [
      'label' => $trans('footer.compliance'),
      'items' => [
        [
          'label' => $trans('footer.use'),
          'url' => route('compliance-use', $lang)
        ],
        [
          'label' => $trans('footer.compliance_policy'),
          'url' => route('compliance-policy', $lang)
        ],
        [
          'label' => $trans('footer.risk_disclosure'),
          'url' => route('compliance-risk', $lang)
        ],
        [
          'label' => $trans('footer.security'),
          'url' => route('compliance-security', $lang)
        ]
      ]
    ],
    [
      'label' => $trans('footer.platform'),
      'items' => [
        [
          'label' => $trans('footer.sla'),
          'url' => route('platform-sla', $lang)
        ],
        [
          'label' => $trans('footer.ip'),
          'url' => route('platform-ip', $lang)
        ],
        // [
        //   'label' => $trans('footer.copyright'),
        //   'url' => route('platform-copyright', $lang)
        // ]
      ]
    ],
    [
      'label' => $trans('footer.technology'),
      'items' => [
        [
          'label' => $trans('footer.architecture'),
          'url' => route('technology-architecture', $lang)
        ]
      ]
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

function loadMarkdownPageTranslations(string $markdownDir, string $englishFilename, string $spanishFilename, string $defaultPageTitle = 'Document'): array
{
  $normalizeText = static function (string $text): string {
    $text = str_replace(['\\.', '**', '\\[', '\\]'], ['.', '', '[', ']'], trim($text));
    return preg_replace('/\s+/', ' ', $text) ?? $text;
  };

  $isStandaloneSubheading = static function (string $line): bool {
    if (preg_match('/[.?!;:]$/', $line)) {
      return false;
    }

    if (preg_match('/^\d+\.\d+/', $line)) {
      return false;
    }

    $words = preg_split('/\s+/', trim($line));
    $wordCount = is_array($words) ? count($words) : 0;

    if ($wordCount === 0 || $wordCount > 8) {
      return false;
    }

    return preg_match('/^[\p{Lu}0-9][\p{L}0-9\/().,&\'" -]+$/u', $line) === 1;
  };

  $parseMarkdown = static function (string $markdown) use ($defaultPageTitle, $normalizeText, $isStandaloneSubheading): array {
    $page = [
      'page' => $defaultPageTitle,
      'updated_at' => '',
      'intro' => [],
      'sections' => [],
    ];

    if (trim($markdown) === '') {
      return $page;
    }

    $lines = preg_split("/\r\n|\n|\r/", trim($markdown)) ?: [];
    $currentSection = null;
    $paragraphBuffer = [];
    $listBuffer = [];
    $expectList = false;

    $pushBlock = static function (array $block) use (&$currentSection, &$page): void {
      if ($currentSection !== null) {
        $currentSection['blocks'][] = $block;
        return;
      }

      if (($block['type'] ?? null) === 'paragraph') {
        $page['intro'][] = $block['text'];
      }
    };

    $flushParagraph = static function () use (&$paragraphBuffer, &$expectList, $normalizeText, $pushBlock): void {
      if ($paragraphBuffer === []) {
        return;
      }

      $text = $normalizeText(implode(' ', $paragraphBuffer));
      $pushBlock([
        'type' => 'paragraph',
        'text' => $text,
      ]);

      $paragraphBuffer = [];
      $expectList = str_ends_with($text, ':');
    };

    $flushList = static function () use (&$listBuffer, &$expectList, $pushBlock): void {
      if ($listBuffer === []) {
        return;
      }

      $pushBlock([
        'type' => 'list',
        'items' => $listBuffer,
      ]);

      $listBuffer = [];
      $expectList = false;
    };

    $flushBlocks = static function () use ($flushParagraph, $flushList): void {
      $flushParagraph();
      $flushList();
    };

    foreach ($lines as $line) {
      $line = trim($line);

      if ($line === '') {
        $flushBlocks();
        continue;
      }

      if (preg_match('/^#\s+\*\*(.+)\*\*$/', $line, $matches) === 1) {
        $page['page'] = $normalizeText($matches[1]);
        continue;
      }

      if (preg_match('/^\*\*(Last Updated|Última actualización):\s*(.+?)\*\*$/u', $line, $matches) === 1) {
        $page['updated_at'] = $normalizeText($matches[1] . ': ' . $matches[2]);
        continue;
      }

      if (preg_match('/^###\s+\*\*(.+)\*\*$/', $line, $matches) === 1) {
        $flushBlocks();

        if ($currentSection !== null) {
          $page['sections'][] = $currentSection;
        }

        $currentSection = [
          'title' => $normalizeText($matches[1]),
          'blocks' => [],
        ];
        continue;
      }

      if (preg_match('/^\*\*(.+)\*\*$/', $line, $matches) === 1) {
        $flushBlocks();
        $pushBlock([
          'type' => 'subheading',
          'text' => $normalizeText($matches[1]),
        ]);
        continue;
      }

      if ($isStandaloneSubheading($line)) {
        $flushBlocks();
        $pushBlock([
          'type' => 'subheading',
          'text' => $normalizeText($line),
        ]);
        continue;
      }

      if (preg_match('/^[-*]\s+(.+)$/', $line, $matches) === 1 || preg_match('/^[a-z]\.\s+(.+)$/i', $line, $matches) === 1) {
        $flushParagraph();
        $listBuffer[] = $normalizeText($matches[1]);
        $expectList = true;
        continue;
      }

      if ($expectList) {
        $listBuffer[] = $normalizeText($line);
        continue;
      }

      $flushList();
      $paragraphBuffer[] = $line;
    }

    $flushBlocks();

    if ($currentSection !== null) {
      $page['sections'][] = $currentSection;
    }

    return $page;
  };

  $loadPage = static function (string $filename) use ($markdownDir, $parseMarkdown): array {
    $path = rtrim($markdownDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;
    $markdown = file_exists($path) ? file_get_contents($path) : '';

    return $parseMarkdown($markdown === false ? '' : $markdown);
  };

  return [
    'es' => $loadPage($spanishFilename),
    'en' => $loadPage($englishFilename),
  ];
}

function isArizonaBusinessHours(): bool
{
  $timezone = new DateTimeZone('America/Mexico_City');
  $now = new DateTime('now', $timezone);
  $dayOfWeek = (int) $now->format('N');
  $currentTime = $now->format('H:i:s');

  if ($dayOfWeek > 5) {
    return false;
  }

  return $currentTime >= '08:00:00' && $currentTime < '20:00:00';
}
