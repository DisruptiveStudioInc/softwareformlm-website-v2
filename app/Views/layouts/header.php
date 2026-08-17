<!DOCTYPE html>
<html lang="<?= $currentLang ?>" class="scroll-smooth <?= isset($hasSnapScroll) ? 'lg:snap-y lg:snap-proximity' : '' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $pageTitle ?? $trans('home.title') ?></title>

  <?php if (isset($metaDescription)): ?>
    <meta name="description" content="<?= htmlspecialchars($metaDescription) ?>">
  <?php endif; ?>

  <!-- Opengraph -->
  <meta property="og:url" content="<?= $config['app']['url'] ?>" />
  <meta property="og:type" content="<?= $ogType ?? 'website' ?>" />
  <meta property="og:title" content="<?= $pageTitle ?? $trans('home.title') ?>" />
  <meta property="og:description" content="<?= $metaDescription ?? 'Disruptive Studio' ?>" />
  <meta property="og:image" content="<?= (isset($ogImage) && !empty($ogImage)) ? $ogImage : $config['app']['url'].'/public/images/opengraph.jpg' ?>" />
  <meta property="og:image:alt" content="<?= $pageTitle ?? $trans('home.title') ?>" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="675" />
  <meta property="og:locale" content="<?= $currentLang ?>" />
  <meta property="og:site_name" content="<?= $pageTitle ?? $trans('home.title') ?>" />

  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= $pageTitle ?? $trans('home.title') ?>" />
  <meta name="twitter:description" content="<?= $metaDescription ?? 'Disruptive Studio' ?>" />
  <meta name="twitter:image" content="<?= (isset($ogImage) && !empty($ogImage)) ? $ogImage : $config['app']['url'].'/public/images/opengraph.jpg' ?>" />
  <link rel="canonical" href="<?= $config['app']['url'] . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>" />

  <!-- Structured data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Disruptive Studio",
    "url": "<?= $config['app']['url'] ?>",
    "logo": "<?= $config['app']['url'] ?>/public/logo.svg",
    "contactPoint": [
      {
        "@type": "ContactPoint",
        "telephone": "+1 408 858 4504",
        "contactType": "sales",
        "availableLanguage": ["Spanish", "English"]
      }
    ],
    "sameAs": [
      "https://wa.me/+14088584504"
    ]
  }
  </script>

  <!-- CSS -->
  <?php if (!empty($includeAnimations)): ?>
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
  <?php endif; ?>
  <?php if (!empty($includeTracking)): ?>
    <link rel="preconnect" href="https://www.googletagmanager.com">
  <?php endif; ?>

  <link rel="stylesheet" href="<?= asset_url('/public/assets/css/styles.css') ?>">

  <script type="module" src="<?= asset_url('/public/assets/js/base.js') ?>"></script>
  <?php if (!empty($includeAnimations)): ?>
    <script type="module" src="<?= asset_url('/public/assets/js/home-animations.js') ?>"></script>
  <?php endif; ?>
  <?php if (!empty($includeContactForm)): ?>
    <script type="module" src="<?= asset_url('/public/assets/js/contact-form.js') ?>"></script>
  <?php endif; ?>

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="/public/favicon.svg">
  <?php if (!empty($includeTracking)): ?>
    <?php include __DIR__ . '/../components/header-traking.php'; ?>
  <?php endif; ?>
</head>

<body class="text-grey-100 antialiased overflow-x-hidden">
<header id="main-header" class="bg-white border-b border-surface-300 w-full fixed top-0 left-0 z-50">
  <nav class="w-full">
    <div class="flex justify-between items-center lg:items-stretch gap-4 lg:gap-1 xl:gap-2 w-full px-7">
      <div class="flex items-center lg:shrink-0 border-r border-surface-300 gap-2 lg:gap-4 pr-4">
        <!-- Logo -->
        <a href="<?= route('home', $currentLang, $config['languages']['default']) ?>" class="text-2xl font-bold text-gray-800" aria-label="<?= htmlspecialchars($trans('nav.home')) ?>">
          <svg width="100" height="100" class="h-8 lg:h-10 w-auto"><use href="/public/assets/icons.svg.php#disruptive-favicon"/></svg>
        </a>

        <!-- Language switcher -->
        <?php
        // Pass post translations to language switcher if available
        $postTranslations = $postTranslations ?? null;
        include(__DIR__.'/../components/langSwitcherIcon.php');
        ?>

        <a href="https://wa.me/<?= $constants['contact_info']['wame'] ?>?text=<?= $trans('common.wame_message') ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp" class="flex-center p-1.5 rounded-full bg-green-400 hover:bg-green-700 active:bg-green-700 transition-colors">
          <svg class="size-7 text-white"><use href="/public/assets/icons.svg.php#whatsapp"/></svg>
        </a>
      </div>

      <!-- Mobile menu button -->
      <button id="mobile-menu-button" class="lg:hidden p-1.5 rounded-lg bg-brand-100 text-white active:bg-brand-200" aria-label="Open menu">
        <svg class="size-7" fill="none"><use href="/public/assets/icons.svg.php#bars-menu"/></svg>
      </button>

      <!-- Desktop Navigation -->
      <?php include(__DIR__.'/../components/navDesktop.php') ?>

      <a href="<?= $constants['shop_link_category'] ?>?ref=<?= $GLOBALS['user_replica'] ?>" target="_blank" rel="noopener noreferrer" class="button self-center shrink-0 rounded-lg font-bold hidden lg:flex lg:es:text-sm xl:es:text-base">
        <?= $trans('common.subscribe') ?>
      </a>
      <?php if(false): ?>
        <a href="<?= $constants['login_link'] ?>" target="_blank" rel="noopener noreferrer" class="button self-center shrink-0 rounded-lg font-bold hidden bg-secondary-100 hover:bg-secondary-200 text-white lg:flex lg:es:text-sm xl:es:text-base">
          <?= $trans('common.login') ?>
        </a>
        <a href="<?= $constants['bo_link'] ?>register/<?= $GLOBALS['user_replica'] ?>" target="_blank" rel="noopener noreferrer" class="button self-center shrink-0 rounded-lg font-bold hidden lg:flex lg:es:text-sm xl:es:text-base">
          <?= $trans('common.register') ?>
        </a>
      <?php endif; ?>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobile-menu" class="lg:hidden fixed top-0 left-0 w-full h-dvh bg-white -translate-y-full transition-transform duration-500">
      <div class="p-7 flex flex-col items-end gap-2 h-full">
        <button id="close-mobile-button" class="p-1.5 rounded-lg bg-surface-100 text-brand-100 active:bg-brand-200 active:text-white" aria-label="Close menu">
          <svg class="size-7" fill="none"><use href="/public/assets/icons.svg.php#arrow-up"/></svg>
        </button>

        <div class="overflow-y-auto">

          <ul id="mobile-nav" class="w-full accordion-container">
            <?php foreach ($navigationMenu as $index => $item): ?>
              <li class="border-b border-surface-300 last:border-b-0 <?= $item['hasSubmenu'] ? 'relative' : '' ?>">
                <?php if(isset($item['url'])): ?>
                  <a href="<?= $item['url'] ?>" class="flex items-center py-3 px-2 text-xl text-grey-100 active:text-brand-100 transition-colors">
                    <?= $item['label'] ?>
                  </a>
                <?php else: ?>
                  <button type="button" data-target="acc-content-<?= $index ?>" aria-controls="acc-content-<?= $index ?>" aria-expanded="false" class="acc-trigger group/item flex w-full items-center justify-between px-2 py-3 text-left text-xl [&.open]:text-brand-200 transition-colors">
                    <?= $item['label'] ?>
                    <svg class="size-6 group-[.open]/item:rotate-180 transition-transform"><use href="/public/assets/icons.svg.php#chevron-down"/></svg>
                  </button>
                  <div id="acc-content-<?= $index ?>" class="grid grid-rows-[0fr] [&.open]:grid-rows-[1fr] transition-grid-rows duration-500">
                    <ul class="bg-surface-100/70 flex flex-col overflow-hidden">
                      <?php foreach($item['submenu'] as $inner => $sub): ?>
                        <li class="<?= $item['isMegamenu'] ? 'px-4 pt-4 pb-1.5 border-b border-surface-300/40 last:border-b-0' : 'first:pt-1.5 last:pb-1.5' ?>">
                          <?php if($item['isMegamenu']): ?>
                            <button type="button" data-target="acc-subcontent-<?= $inner ?>" aria-controls="acc-subcontent-<?= $inner ?>" aria-expanded="false" class="acc-trigger group/subitem w-full text-xl font-bold mb-1 text-secondary-100 flex items-center justify-between [&.open]:text-brand-200 transition-colors">
                              <?= $sub['name'] ?>
                              <svg class="size-6 inline-block ml-1 group-[.open]/subitem:rotate-180 transition-transform"><use href="/public/assets/icons.svg.php#chevron-down"/></svg>
                            </button>
                            <div id="acc-subcontent-<?= $inner ?>" class="grid grid-rows-[0fr] [&.open]:grid-rows-[1fr] transition-grid-rows duration-500">
                              <ul class="flex flex-col overflow-hidden">
                                <?php foreach($sub['list'] as $subItem): ?>
                                  <li><a href="<?= $subItem['url'] ?>" class="block py-2.5 text-grey-100/70 text-xl active:text-brand-100 transition-colors"><?= $subItem['label'] ?></a></li>
                                <?php endforeach; ?>
                              </ul>
                            </div>
                          <?php else: ?>
                            <a href="<?= serviceRoute($sub['meta']['slug'], $currentLang) ?>" class="block py-2.5 px-4 text-grey-100/70 text-xl rounded hover:bg-surface-100/80 hover:text-brand-100 transition-colors">
                              <?= $sub['meta']['meta_title'] ?>
                            </a>
                          <?php endif; ?>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>

          </ul>

          <a href="<?= $constants['shop_link_category'] ?>?ref=<?= $GLOBALS['user_replica'] ?>" target="_blank" rel="noopener noreferrer" class="button w-full rounded-lg font-bold">
            <?= $trans('common.subscribe') ?>
          </a>
          <?php if(false): ?>
            <a href="<?= $constants['login_link'] ?>" target="_blank" rel="noopener noreferrer" class="button w-full rounded-lg font-bold bg-secondary-100 hover:bg-secondary-200 text-white">
              <?= $trans('common.login') ?>
            </a>
            <a href="<?= $constants['bo_link'] ?>register/<?= $GLOBALS['user_replica'] ?>" target="_blank" rel="noopener noreferrer" class="button w-full rounded-lg font-bold">
              <?= $trans('common.register') ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>
</header>

<main>
