<!-- ============================================== -->
<!-- HERO -->
<!-- ============================================== -->

<section class="hero-pin overlay o-30 <?= (false) ? 'med-h-auto' : ''; ?>">
  <div class="anchor" id="home"></div>
  <img src="/images/hero/hero2.webp" alt="Software for MLM" class="background" />

	<div class="section-arrows">
    <button class="arrow down">
      <svg><use href="#arrow-down"/></svg>
    </button>
	</div>

  <div class="text-hero t-c hero-text tc-0 <?= (true) ? '' : 'd-none med-d-block' ?>">
    <h1 class="h1-special first"><?= $Hero_01; ?></h1>
    <p class="h2 m-center"><?= $Hero_02; ?></p>
  </div>

  <?php if(false): ?>
    <div class="dh of-h rel">
      <div class="video-iframe-wrapper med-d-none">
        <iframe
			    src="https://player.vimeo.com/video/<?= $Video_vimeo; ?>?background=1&autoplay=1&muted=1&loop=1"
			    frameborder="0"
			    allow="autoplay; fullscreen; picture-in-picture"
			    title="Disruptive Studio"
          style="z-index:2">
		    </iframe>
	    </div>

    </div>
  <?php endif; ?>
</section>

<!-- ============================================== -->
<!-- ONE -->
<!-- ============================================== -->

<section>

  <?php include(__DIR__ . '/../includes/arrowsLat.php'); ?>

	<div class="anchor" id="sfmlm"></div>
	<div class="mw-1440 jc-center ai-center min-h-dvh med-h-0 small-pt-40 small-pb-40">
		<div class="t-c">
			<h2 class="h1-special operate"><?= $Journey_title; ?></h2>
      <p class="h3 mb-50 small-mb-30"><?= $Journey_text; ?></p>
			<ul class="journey-container col-2 rows-2-auto g-40 med-g-20 m-center">
        <?php foreach($sfmlm_about as $item): ?>
          <li class="journey-item d-flex fd-col g-0 ai-center c-surf-400 br-16 p-40 med-p-20 pt-0 med-pt-0 t-c">
            <div class="icon-journey c-acc br-50 d-flex ai-center jc-center">
              <svg class="w-70" style="height:auto;aspect-ratio:1"><use href="#<?= $item['icon']; ?>" /></svg>
            </div>
            <div class="d-flex ai-center flex-grow">
              <div>
                <h3 class="h4"><?= $item['title']; ?></h3>
                <p class="t-pretty"><?= $item['text']; ?></p>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
		</div>
	</div>
</section>

<!-- ============================================== -->
<!-- TWO -->
<!-- ============================================== -->

<section>

  <div class="rel">
    <div class="abs slider-tabs-wrap w-100 d-flex">
      <button id="prevTab" type="button" class="btn c-surf br-8 slider-tabs-nav no-animate">
        <?php include __DIR__ . '/../includes/iconArrow.php'; ?>
      </button>
      <div class="of-h flex-grow">
        <ul id="sliderTabs" class="slider-tabs t-c w-100 d-flex jc-center">
          <?php foreach($sfmlm_tabs as $k => $item): ?>
            <li class="tab d-flex jc-center ai-center br-8 p-20 w-100 <?= ($k == 0) ? 'active' : '' ?>">
              <h3 class="h6 m-0"><?= "0".($k+1) ?> <?= $item['title'] ?></h3>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <button id="nextTab" type="button" class="btn c-surf br-8 slider-tabs-nav no-animate">
        <?php include __DIR__ . '/../includes/iconArrow.php'; ?>
      </button>
    </div>
    <div class="tabs-content">
      <ul class="rel tabs-content-wrapper h-dvh t-c">
        <?php foreach($sfmlm_tabs as $k => $item): ?>
          <li class="abs tabs-content-slide <?= ($k == 0) ? 'active' : '' ?>">
            <div class="rel d-flex fd-col ai-center jc-center overlay o-50 h-100">
              <img class="background" src="/images/body/letters/<?= $item['image']; ?>.webp" alt="<?= $item['title']; ?>">
              <h2 class="tab-content-title t-balance z-index-2 tc-acc m-0"><?= $item['big']; ?></h2>
              <p class="tab-content-text h2 fw-700 z-index-2 tc-0 m-0 t-pretty"><?= $item['text']; ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- ============================================== -->
<!-- THREE -->
<!-- ============================================== -->

<section>

	<?php include(__DIR__ . '/../includes/arrowsLat.php'); ?>

	<div class="mw-1440 t-c h-100 med-h-0 d-flex fd-col jc-center g-40 small-g-20 small-pt-40 small-pb-40">
		<h2 class="h1-special"><?= $Vision_text; ?></h2>
		<ul class="br-16 c-surf-400 d-flex of-h med-fd-col">
      <?php foreach($sfmlm_vision as $item): ?>
        <li class="vision-item rel d-flex fd-col jc-center g-0 w-100 p-40 pt-100 pb-100 med-p-20 med-pt-40 med-pb-40">
          <h3 class="h4 m-0"><?= $item['title']; ?></h3>
          <div class="vision-text-wrap d-grid col-1">
            <div class="of-h">
              <p class="m-0 pt-10"><?= $item['text']; ?></p>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
	</div>
</section>

<!-- ============================================== -->
<!-- FOUR -->
<!-- ============================================== -->

<section class="c-grad-2-4">
	<?php include(__DIR__ . '/../includes/arrowsLat.php'); ?>

	<div class="mw-1280 t-c h-100 med-h-0 jc-center fd-col small-pt-40 small-pb-40">
		<h2 class="h1"><?= $Slogan_title; ?></h2>
		<p class="slogan-text h4 m-center"><?= $Slogan_text; ?></p>
		<a href="<?= $constants['demo']; ?>" target="_blank" class="btn big c-acc br-8 mt-60 small-mt-30" style="gap:8px">
      <?= $Btn_live; ?>
       <?php include __DIR__ . '/../includes/iconArrow.php'; ?>
    </a>
	</div>
</section>

<!-- ============================================== -->
<!-- FIVE -->
<!-- ============================================== -->

<section class="products">

	<div class="of-h">

    <div class="product-timeline-wrap min-h-dvh med-fd-col content-scroll jc-center ai-center rel">

      <?php include(__DIR__ . '/../includes/arrowsLat.php'); ?>

      <img class="background" src="/images/body/products/bg-bo-product.webp" alt="background">

      <div class="max-w-1080 rel gap-0 m-center d-flex ai-center med-fd-col med-p-50 med-pt-60 med-pb-60">
        <div class="product-bo rel w-50 med-w-100">
          <a class="product-bo-screen" href="<?= $constants['demo']; ?>" target="_blank" rel="noopener noreferrer">
            <img src="/images/body/products/bo-screenshot.webp" class="" alt="basic" />
          </a>
          <span class="btn-plus-bo abs d-block c-acc br-50 p-10" style="height:50px;pointer-events:none;">
            <svg width="30" height="30" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M41.8002 23.0002H27.0002V8.2002C27.0002 7.1002 26.1002 6.2002 25.0002 6.2002C23.9002 6.2002 23.0002 7.1002 23.0002 8.2002V23.0002H8.2002C7.1002 23.0002 6.2002 23.9002 6.2002 25.0002C6.2002 26.1002 7.1002 27.0002 8.2002 27.0002H23.0002V41.8002C23.0002 42.9002 23.9002 43.8002 25.0002 43.8002C26.1002 43.8002 27.0002 42.9002 27.0002 41.8002V27.0002H41.8002C42.9002 27.0002 43.8002 26.1002 43.8002 25.0002C43.8002 23.9002 42.9002 23.0002 41.8002 23.0002Z" fill="white"/>
            </svg>
          </span>
        </div>
        <div class="product-content-wrap w-50 med-w-100 med-pt-30 tc-0">
          <h2 class="product-bo-title h2 t-pretty tc-acc"><?= $Product_title; ?></h2>
          <p class="product-bo-text h5"><?= $Product_text; ?></p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ============================================== -->
<!-- SIX -->
<!-- ============================================== -->

<section>
	<div class="wrap-people h-100 med-h-auto d-flex fd-col jc-center ai-center">
		<div class="mw-1440 p-30 mb-40">
			<h3 class="h3 t-c"><?= $Envolvers_title; ?></h3>
		</div>

    <ul class="people w-100">
      <?php foreach ($Logos as $k => $item): ?>
      <li class="item item<?= $k +1; ?>">
        <span class="wrap-logo d-block">
          <img class="m-0" src="/images/body/evolvers/<?= $item['image']; ?>" alt="<?= $item['name']; ?>">
        </span>
      </li>
      <?php endforeach; ?>
    </ul>
	</div>
</section>

<!-- ============================================== -->
<!-- SEVEN -->
<!-- ============================================== -->

<section class="">

  <div class="anchor" id="plans"></div>
	<?php include(__DIR__ . '/../includes/arrowsLat.php'); ?>

  <h2 class="h1 tc-acc t-c mb-40"><?= $Truth_title ?></h2>

  <ul>
    <?php foreach($Big_texts as $item): ?>
      <li class="truth-item rel t-c of-h">
        <img class="truth-image" src="/images/body/truth/<?= $item['image']; ?>.webp" alt="<?= $item['title']; ?>">
        <div class="truth-content small-p-20 small-pt-40 small-pb-40">
          <h3 class="truth-title m-0"><?= $item['title']; ?></h3>
          <div class="truth-text">
            <p class="h3 m-0 t-pretty fw-700"><?= $item['module']; ?></p>
            <p class="h5 mb-0 t-pretty"><?= $item['text']; ?></p>
          </div>
        </div>
      </li>
    <?php endforeach; ?>
  </ul>
</section>

<!-- ============================================== -->
<!-- EIGHT -->
<!-- ============================================== -->

<section>

	<?php include(__DIR__ . '/../includes/arrowsLat.php'); ?>

	<div class="spirit-wrap d-flex med-fd-col min-h-dvh">
		<div class="spirit-banner rel w-50 med-w-100">
			<img src="/images/body/the_spirit/1.webp" alt="" class="background img-spirit active">
			<img src="/images/body/the_spirit/2.webp" alt="" class="background img-spirit">
			<img src="/images/body/the_spirit/3.webp" alt="" class="background img-spirit">
		</div>

		<!-- Textos -->
		<div class="w-50 med-w-100 d-flex fd-col jc-center p-80 med-p-50 small-p-20 small-pt-50 small-pb-50">
			<h2 class="h2 small-t-c mt-0 mb-50"><?= $Spirit_title; ?></h2>
      <ul class="d-flex fd-col g-40">
        <?php foreach($Sfmlm_spirit as $item): ?>
          <li class="spirit-container br-16 c-surf-400 rel">
            <div class="spirit-icon abs c-acc tc-0 p-10 br-50 d-flex ai-center jc-center">
              <svg class="w-90" style="height:auto;aspect-ratio:1"><use href="#<?= $item['icon']; ?>" /></svg>
            </div>
            <h3 class="h4 mt-0"><?= $item['title']; ?></h3>
            <p class="mb-0 t-pretty"><?= $item['text']; ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
		</div>
	</div>
</section>

<!-- ============================================== -->
<!-- NINE -->
<!-- ============================================== -->

<section class="c-grad-1-4">

	<div class="section-arrows">
    <button class="arrow up">
      <svg><use href="#arrow-up"/></svg>
    </button>
	</div>

	<div class="mw-1280 t-c big">
		<h2 class="h1 big-last"><?= $Traits_title; ?></h2>
		<a href="<?= $constants['wame'] ?>" target="_blank" class="btn big c-acc br-8 mt-40 small-mt-20" style="gap:8px">
      <?= $Btn_part; ?>
      <?php include __DIR__ . '/../includes/iconArrow.php'; ?>
    </a>
	</div>
</section>

<script src="/js/slider.js"></script>
<script type="module" src="/js/swiper.js"></script>
<script src="/js/home.js"></script>
<script src="/js/slider-tabs.js"></script>
