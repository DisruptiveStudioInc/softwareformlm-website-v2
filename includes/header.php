<?php
  include("info.php");
  $page_title = isset($page_title) ? "$company_name | $page_title" : $company_name;
  $page_description = $page_description ?? $Description_Site;
  $page_keywords = $page_keywords ?? $Keywords_Site;
  $page_type = $page_type ?? 'website';
  $availableLangs = getConfig('available_langs');
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?= $Lang; ?>" xml:lang="<?= $Lang; ?>">

<head>

  <meta name="twitter:card"        content="summary">
  <meta name="twitter:site"        content="<?= $Host_Site; ?>">
  <meta name="twitter:title"       content="<?= $page_title; ?>">
  <meta name="twitter:description" content="<?= $page_description; ?>">
  <meta name="twitter:creator"     content="<?= $company_name; ?>">
  <meta name="twitter:image"       content="<?= $Host_Site; ?>/images/facebook/facebook.jpg">

  <meta property="og:site_name"    content="<?= $company_name; ?>" />
  <meta property="og:url"          content="<?= $Host_Site; ?>" />
  <meta property="og:title"        content="<?= $page_title; ?>" />
  <meta property="og:type"         content="<?= $page_type; ?>" />
  <meta property="og:description"  content="<?= $page_description; ?>" />
  <meta property="og:image"        content="<?= $Host_Site; ?>/images/facebook/facebook.jpg" />
  <meta property="og:image:width"  content="1200" />
  <meta property="og:image:height" content="675" />

  <meta name="viewport"            content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8" />
  <meta name="description"         content="<?= $page_description; ?>" />
  <meta name="keywords"            content="<?= $page_keywords; ?>" />
  <meta name="autor"               content="<?= $company_name; ?>" />
  <link rel="canonical" href="<?= $Host_Site . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); ?>" />

  <title><?= $page_title; ?></title>

  <!-- STYLES-->
  <link rel="stylesheet" type="text/css" href="/css/min/reset.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/min/main.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/min/root.min.css" />

  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css"
  />
  <link rel="stylesheet" type="text/css" href="/css/body/style.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/body/navigation.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/body/slick.min.css" />
  <link rel="stylesheet" type="text/css" href="/css/body/swiperlocal.css" />

  <!-- FAVICON -->
  <link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="/images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="/images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="/images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
  <link rel="manifest" href="/images/favicon/manifest.json">
  <meta name="msapplication-config" content="/images/favicon/browserconfig.xml" />
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/images/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <Link rel="shortcut icon" href="/images/favicon/favicon.ico" />

  <!-- FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&display=swap" rel="stylesheet">

  <!-- jQuery y Slick -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script> -->

  <!-- GSAP -->
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/gsap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/gsap@3.14.1/dist/ScrollTrigger.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js"></script>

</head>
<body id="page-content">

  <div class="wrap-get d-flex fd-col ai-center w-100 t-c pointer-e-none">
    <a href="<?= $constants['wame']; ?>" target="_blank" class="btn-get pointer-e-auto rel">
      <?= $Btn_started; ?>
      <p class="float-note t-c tc-0"><?= $Btn_float_note; ?></p>
    </a>
  </div>

  <!-- ============================================== -->
  <!-- PRELOADER -->
  <!-- ============================================== -->

  <div id="preloader">
    <div id="progress">
      <span id="data">0%</span>
    </div>
  </div>

  <!-- ============================================== -->
  <!-- NAVIGATION -->
  <!-- ============================================== -->

  <header>
    <nav class="nav">
      <div class="navigation">

        <div class="jc-center ai-center g-20">
          <div class="logo">
            <a href="/"><img src="/images/logo/logo.svg" alt="<?= $company_fullname ?>"></a>
          </div>
          <div class="rel">
            <div class="btn-lan <?= strtolower($availableLangs[$Current_lang]); ?>"><?= $availableLangs[$Current_lang]; ?></div>
            <div class="lan">
              <?php
                foreach ($availableLangs as $langCode => $label) {
                  $activeClass = (\Includes\Localization::getLang() === $langCode) ? 'selected' : '';
                  $flag = strtolower($label);
                  $url = \Includes\Localization::getCurrentUrl($langCode);
                  echo "<a class='$flag $activeClass' href='$url'>$label</a>";
                }
              ?>
            </div>
          </div>
        </div>

        <div class="menu">
          <ul>
            <?php
              $id = $_GET['id'] ?? '';
              foreach($Menu as $item):
                if(!$item['show']){ continue; }
            ?>
              <li class="<?= $item['hasSubmenu'] ? 'rel' : '' ?>">
                <a href="<?= $item['link'] ?>" class="<?= $item['hasSubmenu'] ? 'btn-sub no-chevron' : $item['status'] ?>"><?= $item['title'] ?></a>
                <?php if($item['hasSubmenu']): ?>
                  <ul class="sub">
                    <?php foreach($item['submenu'] as $subitem): ?>
                      <li>
                        <a href="<?= $subitem['link'] ?>"><?= $subitem['title'] ?><span><?= $subitem['slogan'] ?></span></a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                <?php endif; ?>
              </li>
            <?php endforeach; ?>

            <div class="d-none med-d-block mt-20">
              <div class="mb-10">
                <a href="<?= $constants['demo']; ?>" target="_blank" class="btn c-surf br-8 w-100 d-none"><?= $Menu_demo; ?></a>
              </div>
              <div>
                <a href="<?= $constants['wame'] ?>" target="_blank" class="btn c-acc br-8 w-100" style="gap:8px;">
                  <?= $Menu_contact; ?>
                  <?php include 'iconWhatsapp.php'; ?>
                </a>
              </div>
            </div>
          </ul>
        </div>

        <div class="jc-center ai-center">
          <div class="btns m-0 g-10 med-d-none">
            <a href='<?= $constants['demo']; ?>' target="_blank" class="btn c-surf br-8 d-none"><?= $Menu_demo; ?></a>
            <a href='<?= $constants['wame']; ?>' target="_blank" class="btn c-acc br-8" style="gap:8px;">
              <?= $Menu_contact; ?>
              <?php include 'iconWhatsapp.php'; ?>
            </a>
          </div>
          <div class="hamburguer">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </div>

      </div>
    </nav>
  </header>

  <!-- ============================================== -->
  <!-- PAGE CONTENT -->
  <!-- ============================================== -->

  <main>
