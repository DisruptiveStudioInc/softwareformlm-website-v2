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
