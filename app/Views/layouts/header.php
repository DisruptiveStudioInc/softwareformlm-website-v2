<!DOCTYPE html>
<!-- <html lang="<?= $currentLang ?>" class="scroll-smooth <?= isset($hasSnapScroll) ? 'snap-y snap-proximity' : '' ?>"> -->
<html lang="<?= $currentLang ?>" class="<?= isset($hasSnapScroll) ? 'snap-y snap-proximity' : '' ?>">
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

  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-4047FZ4Z5R"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-4047FZ4Z5R');
  </script>

  <!-- Facebook Pixel -->
  <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1562889971501829');
    fbq('track', 'PageView');
  </script>
  <noscript>
    <img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1562889971501829&ev=PageView&noscript=1"/>
  </noscript>

  <!-- CSS -->
  <link rel="preconnect" href="https://cdn.jsdelivr.net">
  <link rel="preconnect" href="https://www.googletagmanager.com">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" /> -->
  <!-- <link rel="stylesheet" href="/public/assets/css/styles.css"> -->
  <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"
      media="print"
      onload="this.media='all'; this.onload=null;">

  <noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css">
  </noscript>

<link rel="stylesheet" href="/public/assets/css/styles.css">

  <?php if (!empty($hasTextTexture)): ?>
    <link rel="preload" as="image" href="/public/images/background/light-grad.webp" fetchpriority="high">
  <?php endif; ?>

  <?php if (!empty($includeRecaptcha)): ?>
    <!-- reCAPTCHA v3 -->
    <script src="https://www.google.com/recaptcha/api.js?render=<?= $config['recaptcha']['site_key'] ?>"></script>
  <?php endif; ?>

  <!-- GSAP -->
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollTrigger.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/SplitText.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/MotionPathPlugin.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/ScrollSmoother.min.js"></script>

  <!-- Swiper -->


  <!-- Main JS -->
  <script type="module" src="/public/assets/js/main.js"></script>

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="/public/favicon.svg">
</head>

<body class="text-grey-100 antialiased overflow-x-hidden">
<header class="bg-white border-b border-surface-300 w-full fixed top-0 left-0 z-50">
  <nav class="w-full">
    <div class="flex justify-between items-center lg:items-stretch gap-4 lg:gap-1 lg:es:gap-0.5 xl:es:gap-1 xl:gap-2 w-full px-7">
      <div class="flex items-center lg:shrink-0 border-r border-surface-300 gap-2 lg:gap-4 lg:es:gap-1 xl:es:gap-4 pr-4 lg:es:pr-2 xl:es:pr-4">
        <!-- Logo -->
        <a href="<?= route('home', $currentLang, $config['languages']['default']) ?>" class="text-2xl font-bold text-gray-800">
          <svg width="100" height="100" class="h-8 lg:h-10 w-auto"><use href="#disruptive-favicon"/></svg>
        </a>

        <!-- Language switcher -->
        <?php
        // Pass post translations to language switcher if available
        $postTranslations = $postTranslations ?? null;
        include(__DIR__.'/../components/langSwitcherIcon.php');
        ?>

        <a href="https://wa.me/<?= $constants['contact_info']['wame'] ?>" target="_blank" rel="noopener noreferrer" class="flex-center p-1.5 rounded-full bg-green-400 hover:bg-green-700 active:bg-green-700">
          <svg class="size-7 text-white"><use href="#whatsapp"/></svg>
        </a>
      </div>

      <!-- Mobile menu button -->
      <button id="mobile-menu-button" class="lg:hidden p-1.5 rounded-lg bg-brand-100 text-white active:bg-brand-200" aria-label="Open menu">
        <svg class="size-7" fill="none"><use href="#bars-menu"/></svg>
      </button>

      <!-- Desktop Navigation -->
      <?php include(__DIR__.'/../components/navDesktop.php') ?>

      <a href="<?= $constants['zoom'] ?>" target="_blank" rel="noopener noreferrer" class="button self-center shrink-0 rounded-lg font-bold hidden lg:flex lg:es:text-sm xl:es:text-base">
        <?= $trans('common.demo') ?>
      </a>
    </div>

    <!-- Mobile Navigation -->
    <div id="mobile-menu" class="lg:hidden fixed top-0 left-0 w-full h-dvh overflow-y-auto bg-white -translate-y-full transition-transform duration-500">
      <div class="p-7 flex flex-col items-end gap-2">
        <button id="close-mobile-button" class="p-1.5 rounded-lg bg-surface-100 text-brand-100 active:bg-brand-200 active:text-white" aria-label="Close menu">
          <svg class="size-7" fill="none"><use href="#arrow-up"/></svg>
        </button>

        <ul id="mobile-nav" class="w-full accordion-container">
          <?php foreach ($navigationMenu as $index => $item): ?>
            <li class="border-b border-surface-300 last:border-b-0 <?= $item['hasSubmenu'] ? 'relative' : '' ?>">
              <?php if(isset($item['url'])): ?>
                <a href="<?= $item['url'] ?>" class="flex items-center py-3 px-2 text-xl text-grey-100 active:text-brand-100 transition-colors">
                  <?= $item['label'] ?>
                </a>
              <?php else: ?>
                <span data-target="acc-content-<?= $index ?>" class="acc-trigger group flex items-center justify-between px-2 py-3 text-xl [&.open]:text-brand-100 transition-colors">
                  <?= $item['label'] ?>
                  <svg class="size-6 group-[.open]:rotate-180 transition-transform"><use href="#chevron-down"/></svg>
                </span>
                <div id="acc-content-<?= $index ?>" class="grid grid-rows-[0fr] [&.open]:grid-rows-[1fr] transition-grid-rows duration-500">
                  <ul class="bg-surface-100/70 flex flex-col overflow-hidden">
                    <?php foreach($item['submenu'] as $sub): ?>
                      <li class="<?= $item['isMegamenu'] ? 'px-4 pt-4 pb-1.5 border-b border-surface-300/40 last:border-b-0' : 'first:pt-1.5 last:pb-1.5' ?>">
                        <?php if($item['isMegamenu']): ?>
                          <h3 class="text-xl font-bold mb-1 text-secondary-100"><?= $sub['name'] ?></h3>
                          <ul class="flex flex-col">
                            <?php foreach($sub['list'] as $subItem): ?>
                              <a href="<?= $subItem['url'] ?>" class="py-2.5 text-grey-100/70 text-xl active:text-brand-100 transition-colors"><?= $subItem['label'] ?></a>
                            <?php endforeach; ?>
                          </ul>
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

        <a href="<?= route('contact', $currentLang) ?>" class="button w-full rounded-lg font-bold flex text-xl mb-3">
          <?= $trans('nav.contact') ?>
        </a>

        <button type="button" class="video-button cursor-pointer flex-center py-2 px-4 rounded-lg bg-surface-100 hover:bg-surface-300/25 text-brand-100 hover:text-brand-200 transition-colors mx-auto">
          <svg class="size-7"><use href="#play"/></svg>
        </button>
      </div>
    </div>
  </nav>
</header>

<main>
