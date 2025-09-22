<?php
  include("idiomas/idiomas.php");
  $idioma = $_SESSION["language"];
  include("info.php");
?>


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $Lang; ?>" xml:lang="<?php echo $Lang; ?>">

<head>

  <!-- X -->
  <meta name="twitter:card"        content="summary">
  <meta name="twitter:site"        content="<?php echo $Host_Site; ?>">
  <meta name="twitter:title"       content="<?php echo $Company_Name; ?>">
  <meta name="twitter:description" content="<?php echo $Description_Site; ?>">
  <meta name="twitter:creator"     content="<?php echo $Company_Name; ?>">
  <meta name="twitter:image"       content="<?php echo $Host_Site; ?>/images/facebook/facebook.jpg">

  <!-- FACEBOOK -->
  <meta property="og:site_name"    content="<?php echo $Company_Name; ?>" />
  <meta property="og:url"          content="<?php echo $Host_Site; ?>" />
  <meta property="og:title"        content="<?php echo $Company_Name; ?>" />
  <meta property="og:type"         content="website" />
  <meta property="og:description"  content="<?php echo $Description_Site; ?>" />
  <meta property="og:image"        content="<?php echo $Host_Site; ?>/images/facebook/facebook.jpg" />
  <meta property="og:image:width"  content="1024" />
  <meta property="og:image:height" content="538" />

  <!-- METAS-->
  <meta name="viewport"            content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="Content-Type"  content="text/html; charset=UTF-8" />
  <meta name="description"         content="<?php echo $Description_Site; ?>" />
  <meta name="keywords"            content="<?php echo $Keywords_Site; ?>" />
  <meta name="autor"               content="<?php echo $Company_Name; ?>" />

  <title><?php echo $Company_Name; ?></title>

  <!-- STYLES-->
  <link rel="stylesheet" type="text/css" href="./css/min/reset.min.css" />
  <link rel="stylesheet" type="text/css" href="./css/min/main.min.css" />
  <link rel="stylesheet" type="text/css" href="./css/min/root.min.css" />

  <link rel="stylesheet" type="text/css" href="./css/body/style.min.css" />
  <link rel="stylesheet" type="text/css" href="./css/body/navigation.min.css" />
  <link rel="stylesheet" type="text/css" href="./css/body/slick.min.css" />

  <!-- FAVICON -->
  <link rel="apple-touch-icon" sizes="57x57" href="./images/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="./images/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="./images/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="./images/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="./images/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="./images/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="./images/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="./images/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="./images/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="./images/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="./images/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon/favicon-16x16.png">
  <link rel="manifest" href="./images/favicon/manifest.json">
  <meta name="msapplication-config" content="./images/favicon/browserconfig.xml" />
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="./images/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <Link rel="shortcut icon" href="./images/favicon/favicon.ico" />

  <!-- FONTS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&display=swap" rel="stylesheet">

  <!-- jQuery y Slick -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body id="page-content">

  <div class="wrap-get">
    <a href="<?= $Wame; ?>" target="_blank" class="btn-get"><?= $Btn_started; ?></a>
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
            <a href="./"><img src="./images/logo/logo.svg" alt="logo evo global"></a>
          </div>
          <div class="rel">
            <div class="btn-lan <?= htmlspecialchars($idioma); ?>"><?= $Condicion_lan; ?></div>
            <div class="lan">
              <?php
                $idiomas = ['esp', 'eng'];
                foreach ($idiomas as $idioma_opcion) {
                    $activeClass = ($_SESSION["language"] === $idioma_opcion) ? 'selected' : '';
                    echo "<a class='$idioma_opcion $activeClass' href='?language=$idioma_opcion$Actual_Page_Lan$Client_Page_Id'>" . ucfirst($idioma_opcion) . "</a>";
                }
              ?>
            </div>
          </div>
        </div>

        <div class="menu">
          <ul>
            <?php
              foreach ($Menu as $item) {
                echo "<li><a href='{$item[0]}' class='{$item[1]}'>{$item[2]}</a></li>";
              }
            ?>

            <div class="d-none med-d-block mt-20">
              <div class="mb-10">
                <a href="<?php echo $Demo; ?>" target="_blank" class="btn c-surf br-8 w-100 d-none"><?php echo $Menu_demo; ?></a>
              </div>
              <div>
                <a href="<?php echo $Wame ?>" target="_blank" class="btn c-acc br-8 w-100" style="gap:8px;">
                  <?php echo $Menu_contact; ?>
                  <?php include 'iconWhatsapp.php'; ?>
                </a>
              </div>
            </div>
          </ul>
        </div>

        <div class="jc-center ai-center">
          <div class="btns m-0 g-10 med-d-none">
            <a href='<?php echo $Demo; ?>' target="_blank" class="btn c-surf br-8 d-none"><?php echo $Menu_demo; ?></a>
            <a href='<?php echo $Wame; ?>' target="_blank" class="btn c-acc br-8" style="gap:8px;">
              <?php echo $Menu_contact; ?>
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
