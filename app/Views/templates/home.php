<?php
$pageTitle = $trans('home.title');
list($clients1, $clients2, $clients3, $clients4) = split_array_in_quarters($constants['clients']);
// $clients = $constants['clients'];
// Match the square hero's 40vh cap and desktop container width.
$heroImage = '/public/images/home/bo-computer.webp';
$heroSizes = '(min-width: 1088px) calc((min(100vw, 1440px) - 72px) * 0.45), min(40vh, calc(100vw - 56px))';
require __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../components/sideDotsNavigation.php';
?>

<!-- Hero -->
<section data-nav-index="0" class="nav-section lg:snap-start relative text-white w-full overflow-x-hidden">
  <span class="absolute top-0 left-0 size-0" id="home"></span>
  <div class="absolute -z-1 w-full h-full top-0 left-0">
    <picture>
      <source media="(max-width: 1087.98px), (prefers-reduced-motion: reduce)" srcset="<?= asset_url('/public/images/background/glowing-bg-still.svg') ?>">
      <img class="background" src="<?= asset_url('/public/images/background/glowing-bg.svg') ?>" alt="" loading="eager" fetchpriority="low" width="1920" height="1080" decoding="async">
    </picture>
    <div class="absolute w-full h-full top-0 left-0" style="background-image:url('/public/images/background/light_toast.png');background-repeat:repeat;mix-blend-mode:overlay;opacity:0.5"></div>
  </div>
  <div class="block-content py-16 lg:py-24 min-h-dvh flex-center gap-4 flex-col lg:flex-row-reverse">
    <div class="lg:w-1/2 text-center lg:text-left">
      <h1 class="font-khand uppercase bg-clip-text bg-text-white leading-none text-5xl xs:text-7xl sm:text-8xl md:text-9xl xl:text-10xl text-balance es:pt-2"><?= $trans('home.hero.title') ?></h1>
      <p class="lg:text-xl text-balance text-white"><?= $trans('home.hero.text') ?></p>
      <div class="relative w-fit mt-4 mx-auto lg:mx-0 lg:mt-8">
        <a href="<?= $currentLang === 'es' ? 'https://app.softwareformlm.com/widget/bookings/agendar_demo' : 'https://disr.vip/booking' ?>" target="_blank" rel="noopener noreferrer" class="button open-popup relative gradient rounded-lg lg:text-2xl px-7 lg:px-10 hover:text-white duration-300 z-1">
          <span class="relative"><?= $trans('home.hero.cta') ?></span>
        </a>
        <div class="button-glow"></div>
      </div>
    </div>
    <div class="relative lg:w-1/2">
      <?= responsive_image($heroImage, '', 'max-h-[40vh] w-auto mx-auto lg:max-h-none lg:w-9/10 lg:ml-0 lg:mr-auto', $heroSizes, ['loading' => 'eager', 'fetchpriority' => 'high']) ?>
    </div>
  </div>
</section>

<!-- Operate -->
<section data-nav-index="1" class="nav-section lg:snap-start relative bg-surface-100" style="content-visibility:auto;contain-intrinsic-size:1000px;">
  <span class="absolute top-0" id="sfmlm"></span>
  <div class="block-content min-h-dvh flex-center flex-col justify-center py-16 lg:py-32 xl:py-40">
    <h2 class="font-title text-center leading-tight uppercase text-2xl md:text-3xl lg:text-5xl xl:text-[4vw] bg-clip-text bg-text-black slide-up-words-black"><?= animated_words($trans('home.operate.title'), 'bg-clip-text bg-text-black pt-2') ?></h2>
    <p class="text-center lg:text-xl text-balance mb-6 lg:mb-16 slide-up"><?= $trans('home.operate.text') ?></p>
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-7 max-w-md md:max-w-none mx-auto mb-6 lg:mb-16">
      <?php foreach($content['operate'] as $item): ?>
        <li class="bg-surface-50 rounded-2xl p-4 md:p-6 lg:p-7 drop-shadow-lg drop-shadow-grey-100/10">
          <h3 class="text-center font-bold mb-4 leading-tight text-lg lg:text-2xl text-brand-200">
            <?= $item['title'] ?>
          </h3>
          <p class="text-center md:font-light ext-balance"><?= $item['text'] ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="stagger-parent flex-center flex-col">
      <div class="relative w-fit slide-up-stagger">
        <a href="<?= $currentLang === 'es' ? 'https://app.softwareformlm.com/widget/bookings/agendar_demo' : 'https://disr.vip/booking' ?>" target="_blank" rel="noopener noreferrer" class="button open-popup relative gradient rounded-lg lg:text-2xl px-7 lg:px-10 hover:text-white duration-300 z-1">
          <span class="relative"><?= $trans('home.hero.cta') ?></span>
        </a>
        <div class="button-glow"></div>
      </div>
    </div>
  </div>
</section>

<!-- Steps -->
<section data-nav-index="2" class="nav-section lg:snap-start relative bg-surface-200" style="content-visibility:auto;contain-intrinsic-size:1000px;">
  <span class="absolute top-0 left-0 size-0"></span>
  <div class="block-content min-h-dvh py-16 lg:py-20 flex flex-col justify-center">
    <div class="flex justify-center flex-wrap gap-6 lg:gap-12 max-w-md md:max-w-3xl lg:max-w-none mx-auto stagger-parent">
      <?php foreach($content['steps'] as $k => $step): ?>
        <article class="group w-full md:w-[calc(50%_-_--spacing(6))] lg:w-[calc(50%_-_--spacing(12))] p-4 md:p-5 flex-center flex-col bg-white hover:bg-brand-100 text-grey-100 drop-shadow-md drop-shadow-grey-100/20 rounded-xl md:rounded-2xl slide-up-stagger transition-colors">
          <h2 class="font-title uppercase text-center text-brand-200 group-hover:text-white mb-2 sm:mb-6 transition-colors"><?= 0 . ($k+1) . "." ?> <?= $step['number'] ?></h2>
          <div class="w-full flex-center flex-col text-center flex-grow">
            <h3 class="font-khand leading-tight text-balance bg-clip-text bg-text-black text-2xl md:text-4xl lg:text-6xl mb-2 transition-colors"><?= $step['title'] ?></h3>
            <p><?= $step['text'] ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="stagger-parent flex-center flex-col mt-6 lg:mt-12">
      <div class="relative w-fit slide-up-stagger">
        <a href="<?= $currentLang === 'es' ? 'https://app.softwareformlm.com/widget/bookings/agendar_demo' : 'https://disr.vip/booking' ?>" target="_blank" rel="noopener noreferrer" class="button open-popup relative gradient rounded-lg lg:text-2xl px-7 lg:px-10 hover:text-white duration-300 z-1">
          <span class="relative"><?= $trans('home.hero.cta') ?></span>
        </a>
        <div class="button-glow"></div>
      </div>
    </div>
  </div>
</section>

<!-- Network -->
<section data-nav-index="3" class="nav-section lg:snap-start relative tech-section snap-align-none lg:h-screen w-full lg:overflow-hidden bg-surface-300" style="content-visibility:auto;contain-intrinsic-size:1000px;">
  <div class="block-content h-auto lg:h-screen py-12 lg:py-40 flex-center flex-col lg:overflow-hidden">
    <div class="tech-title">
      <h2 class="font-title leading-none uppercase text-2xl sm:text-5xl md:text-8xl lg:text-9xl text-center bg-clip-text bg-text-black slide-up-words-black"><?= animated_words($trans('home.network.title'), 'bg-clip-text bg-text-black pt-2') ?></h2>
      <div class="relative w-fit mt-4 mx-auto lg:mt-8 slide-up-delay" data-delay="2">
        <a href="<?= $currentLang === 'es' ? 'https://app.softwareformlm.com/widget/bookings/agendar_demo' : 'https://disr.vip/booking' ?>" target="_blank" rel="noopener noreferrer" class="button open-popup relative gradient rounded-lg lg:text-2xl px-7 lg:px-10 hover:text-white duration-300 z-1">
          <span class="relative"><?= $trans('home.hero.cta') ?></span>
        </a>
        <div class="button-glow"></div>
      </div>
    </div>
    <div class="w-full lg:mx-auto lg:pointer-events-none mt-8 lg:mt-0">
      <?php foreach($content['network'] as $k => $slide): ?>
        <div class="mb-4 last:mb-0 lg:mb-0 lg:absolute lg:top-1/2 lg:left-1/2 lg:-translate-1/2 lg:w-3/5 lg:max-w-9/20 z-2">
          <article class="tech-card flex-center flex-col text-center bg-brand-100 text-secondary-100 px-4 py-6 lg:p-10 rounded-2xl
          <?= $k===1 ? 'lg:-translate-x-1/4' : '' ?>
          <?= $k===2 ? 'lg:translate-x-1/2' : '' ?>
          ">
            <h2 class="font-title leading-tight uppercase text-balance text-lg sm:text-2xl md:text-3xl lg:text-5xl mb-2 lg:mb-0"><?= $slide['title'] ?></h2>
            <p class="lg:font-light md:text-xl lg:text-xl text-pretty"><?= $slide['text'] ?></p>
            <p class="lg:font-light md:text-xl lg:text-xl text-pretty"><?= $slide['text2'] ?></p>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Scale Banner -->
<section data-nav-index="4" class="nav-section lg:snap-start relative text-white" style="content-visibility:auto;contain-intrinsic-size:1000px;">
  <span class="absolute top-0 left-0 size-0"></span>
  <?php generateBackground('creators',3); ?>
  <div class="block-content min-h-dvh py-16 lg:py-40 flex flex-col items-center justify-center" data-title-cta-sequence>
    <h2 class="banner-text font-title leading-none uppercase text-[9vw] md:text-10xl lg:text-12xl es:pt-3 bg-clip-text bg-text-white slide-up-words-white"><?= animated_words($trans('home.scale.title'), 'bg-clip-text bg-text-white pt-2') ?></h2>
    <div class="relative w-fit mt-4 lg:mt-8 self-start" data-title-cta-action>
      <a href="<?= $currentLang === 'es' ? 'https://app.softwareformlm.com/widget/bookings/agendar_demo' : 'https://disr.vip/booking' ?>" target="_blank" rel="noopener noreferrer" class="button open-popup relative gradient rounded-lg lg:text-2xl px-7 lg:px-10 hover:text-white duration-300 z-1">
          <span class="relative"><?= $trans('home.hero.cta') ?></span>
        </a>
        <div class="button-glow"></div>
    </div>
  </div>
</section>

<!-- Scale Info -->
<section data-nav-index="5" class="nav-section lg:snap-start relative section-about bg-surface-100 text-secondary-200 w-full overflow-hidden" style="content-visibility:auto;contain-intrinsic-size:1000px;">
  <span class="absolute top-0 left-0 size-0"></span>
  <div class="block-content about-content min-h-dvh flex-center flex-col text-center py-16">
    <ul class="w-full max-w-screen-md lg:max-w-none flex flex-col md:flex-row justify-center gap-6 mb-6 lg:mb-10">
      <?php foreach($content['stats'] as $stat): ?>
        <li class="flex flex-col items-center p-4 lg:p-6 bg-white rop-shadow-md drop-shadow-grey-100/20 rounded-xl md:rounded-2xl w-full md:w-1/3 lg:w-1/4">
          <span class="font-bold text-brand-200 text-6xl lg:text-8xl leading-none"><?= $stat['number'] ?></span>
          <span class="text-brand-200 text-lg lg:text-xl"><?= $stat['name'] ?></span>
          <span class="text-sm lg:text-base"><?= $stat['text'] ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
    <p class="max-w-[64ch] mx-auto my-6 lg:text-2xl text-balance slide-up"><?= $trans('home.scale.text') ?></p>
    <p class="font-title uppercase bg-clip-text bg-text-black text-2xl md:text-4xl lg:text-6xl max-w-[28ch] leading-tight mx-auto slide-up"><?= $trans('home.scale.accent') ?></p>
    <div class="relative w-fit slide-up mt-6 lg:mt-12">
      <a href="<?= $currentLang === 'es' ? 'https://app.softwareformlm.com/widget/bookings/agendar_demo' : 'https://disr.vip/booking' ?>" target="_blank" rel="noopener noreferrer" class="button open-popup relative gradient rounded-lg lg:text-2xl px-7 lg:px-10 hover:text-white duration-300 z-1">
          <span class="relative"><?= $trans('home.hero.cta') ?></span>
        </a>
        <div class="button-glow"></div>
    </div>
  </div>
</section>

<!-- Customize -->
<section data-nav-index="6" class="nav-section lg:snap-start relative bg-surface-200" style="content-visibility:auto;contain-intrinsic-size:1000px;">
  <div class="block-content py-16 lg:py-24 min-h-dvh flex-center gap-7 lg:gap-4 flex-col lg:flex-row-reverse">
    <div class="lg:w-1/2 text-center lg:text-left">
      <h2 class="font-khand uppercase bg-clip-text bg-text-black leading-none text-5xl xs:text-7xl sm:text-8xl md:text-11xl xl:text-10xl text-balance es:pt-2"><?= $trans('home.customize.title') ?></h2>
      <p class="text-secondary-200 lg:text-xl text-balance"><?= $trans('home.customize.text') ?></p>
      <p class="text-secondary-200 lg:text-xl text-balance"><?= $trans('home.customize.text2') ?></p>
      <div class="stagger-parent flex flex-col items-center lg:items-start mt-6 lg:mt-12" data-reveal-trigger="section">
        <div class="relative w-fit slide-up-stagger">
          <a href="<?= $currentLang === 'es' ? 'https://app.softwareformlm.com/widget/bookings/agendar_demo' : 'https://disr.vip/booking' ?>" target="_blank" rel="noopener noreferrer" class="button open-popup relative gradient rounded-lg lg:text-2xl px-7 lg:px-10 hover:text-white duration-300 z-1">
            <span class="relative"><?= $trans('home.hero.cta') ?></span>
          </a>
          <div class="button-glow"></div>
        </div>
      </div>
    </div>
    <div class="relative lg:w-1/2 lg:pr-12">
      <?= responsive_image('/public/images/home/bo-mobile.webp', '', 'rounded-xl md:rounded-2xl mx-auto max-h-[45vh] h-full lg:max-h-none lg:h-auto', '(min-width: 1088px) 45vw, 90vw', ['loading' => 'lazy']) ?>
    </div>
  </div>
</section>

<!-- Clients -->
<section data-nav-index="7" class="nav-section lg:snap-start relative min-h-dvh py-16 flex-center flex-col overflow-x-hidden bg-surface-300">
  <span class="absolute top-0 left-0 size-0"></span>
  <div class="text-center px-7 pb-20">
    <h2 class="font-title leading-tight uppercase text-2xl sm:text-4xl lg:text-6xl xl:text-7xl bg-clip-text bg-text-black slide-up-words-black"><?= animated_words($trans('home.clients'), 'bg-clip-text bg-text-black pt-2') ?></h2>
  </div>
  <div class="client-marquee mask-x-from-85% mask-x-to-95%" aria-label="<?= htmlspecialchars($trans('home.clients')) ?>">
    <ul class="client-marquee-track">
      <?php foreach($clients1 as $slide): ?>
        <li>
          <img data-client-src="/public/images/clients/<?= $slide['logo'] ?>" alt="<?= $slide['name'] ?>" width="300" height="180" loading="lazy" decoding="async">
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="client-marquee client-marquee-reverse mask-x-from-85% mask-x-to-95%" aria-hidden="true">
    <ul class="client-marquee-track">
      <?php foreach($clients2 as $slide): ?>
        <li><img data-client-src="/public/images/clients/<?= $slide['logo'] ?>" alt="" width="300" height="180" loading="lazy" decoding="async">
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="client-marquee mask-x-from-85% mask-x-to-95%" aria-hidden="true">
    <ul class="client-marquee-track">
      <?php foreach($clients3 as $slide): ?>
        <li><img data-client-src="/public/images/clients/<?= $slide['logo'] ?>" alt="" width="300" height="180" loading="lazy" decoding="async">
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="client-marquee client-marquee-reverse mask-x-from-85% mask-x-to-95%" aria-hidden="true">
    <ul class="client-marquee-track">
      <?php foreach($clients4 as $slide): ?>
        <li><img data-client-src="/public/images/clients/<?= $slide['logo'] ?>" alt="" width="300" height="180" loading="lazy" decoding="async">
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- Pricing -->
<section data-nav-index="8" class="nav-section lg:snap-start relative bg-surface-100" style="content-visibility:auto;contain-intrinsic-size:1000px;">
  <span class="absolute top-0 left-0 size-0" id="plans"></span>
  <div class="block-content min-h-dvh flex-center flex-col py-16 lg:py-32">
    <h2 class="font-title text-center leading-tight uppercase text-2xl sm:text-6xl lg:text-3xl xl:text-5xl mb-4 lg:mb-12 bg-clip-text bg-text-black slide-up-words-black"><?= animated_words($trans('home.plans.title'), 'bg-clip-text bg-text-black pt-2') ?></h2>

    <div class="w-full max-w-screen-sm sm:max-w-screen-lg lg:max-w-none grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 xl:gap-6">
      <?php
        foreach($content['plans'] as $k => $item):
          $recommended = (isset($item['recommended']) && $item['recommended']);
      ?>
        <article class="<?= $recommended ? 'recommended bg-secondary-200 text-white' : 'bg-white text-secondary-200' ?> relative rounded-lg px-4 pb-4 pt-6 lg:p-6 flex flex-col lg:max-h-[70vh]">
            <button type="button" aria-label="More information about <?= htmlspecialchars($item['title']) ?>" class="open-popup absolute top-2 right-2 <?= $recommended ? 'text-surface-300' : 'text-secondary-50/70' ?> hover:text-brand-100 rounded-full cursor-pointer p-1 transition-colors" data-target="product-popup-<?= strtolower($item['title']) ?>">
              <svg class="size-6 transition-colors"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#info-flat"/></svg>
            </button>
          <?php if($recommended): ?>
            <div class="absolute w-full top-0 left-0 -translate-y-1/2 text-center pointer-events-none">
              <span class="bg-brand-50 text-secondary-100 py-1 px-2 rounded-full text-xs lg:text-base"><?= $trans('common.recommended') ?></span>
            </div>
          <?php endif; ?>
          <h3 class="font-title uppercase text-center text-xl lg:text-3xl mt-1 mb-2"><?= $item['title'] ?></h3>
          <p class="font-title text-brand-200 text-center text-xl sm:text-3xl lg:text-[1.8vw] xl:text-[1.5vw] flex gap-1 items-end justify-center">
            <span><?= '$'."{$item['price']} USD" ?></span>
            <span class="text-xs lg:text-[40%] -translate-y-2.5">/<?= $trans('home.plans.per_month') ?></span>
          </p>
          <div class="relative">
            <a href="<?= $constants['shop_link'] . $item['slug'] . '?ref=' . $GLOBALS['user_replica'] ?>" target="_blank" rel="noopener noreferrer" class="button w-full relative gradient rounded-lg lg:text-lg xl:text-xl px-7 lg:px-10 lg:es:px-4 xl:es:px-10 hover:text-white duration-300 z-1">
              <span class="relative"><?= $trans('common.subscribe') ?></span>
            </a>
            <?php if($recommended): ?>
              <div class="button-glow"></div>
            <?php endif; ?>
          </div>
          <div class="flex-grow mt-6 relative custom-scrollbar top-bottom-scroll-grad overflow-hidden">
            <ul class="text-sm lg:text-base <?= $recommended ? 'text-white' : 'text-secondary-200' ?> flex flex-col gap-0 h-full overflow-y-auto">
              <?php foreach($item['items'] as $feature => $value): ?>
                <li class="flex items-center justify-between gap-2 py-2 first:border-t border-b <?= $recommended ? 'border-white/20' : 'border-secondary-100/20' ?>">
                  <span class="text-balance text-left <?= ($feature === 'includes') ? 'text-brand-200' : '' ?>">
                    <?php
                      if($feature === 'includes'){
                        echo $trans('home.plans.everything_in') . ' ' . $value;
                      } elseif ($feature === 'user_limit'){
                        echo $trans('home.plans.user_limit'). ': ' . format_number_with_commas($item['users']);
                      } elseif ($feature === 'setup_fee'){
                        echo $trans('home.plans.setup_fee') . ': ' . '$' . $value . ' USD';
                      } elseif ($feature === 'elearning_setup'){
                        echo $trans('home.plans.elearning_setup') . ': ' . '$' . $value . ' USD';
                      } else {
                        echo $trans('home.plans.items.' . $feature);
                      }
                    ?>
                  </span>
                  <svg class="shrink-0 size-6 text-green-400"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#check-circle"/></svg>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
          <small class="text-center mt-4 text-balance"><?= $trans('home.plans.non_binding_subscription') ?></small>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Control -->
<section data-nav-index="9" class="nav-section lg:snap-start relative w-full overflow-x-hidden bg-surface-200" style="content-visibility:auto;contain-intrinsic-size:1000px;">
  <span class="absolute top-0 left-0 size-0"></span>
  <div class="block-content min-h-dvh py-16 lg:py-40 flex-center flex-col lg:flex-row lg:justify-end gap-4 lg:gap-0">
    <div class="lg:pr-12 w-full lg:w-3/5 text-center lg:text-left max-lg:px-0" data-reveal-sequence>
      <h2 class="solutions-title font-title uppercase leading-none text-2xl sm:text-6xl lg:text-7xl bg-clip-text bg-text-black slide-up-words-black">
        <?= animated_words($trans('home.control.title'), 'bg-clip-text bg-text-black pt-2') ?>
      </h2>
      <p class="lg:text-xl text-balance mb-6 slide-up" data-reveal-description><?= $trans('home.control.subtitle') ?></p>
      <div class="stagger-parent flex flex-col items-center lg:items-start mt-4 lg:mt-6">
        <div class="relative w-fit slide-up-stagger" data-reveal-action>
          <a href="<?= $currentLang === 'es' ? 'https://app.softwareformlm.com/widget/bookings/agendar_demo' : 'https://disr.vip/booking' ?>" target="_blank" rel="noopener noreferrer" class="button open-popup relative gradient rounded-lg lg:text-2xl px-7 lg:px-10 hover:text-white duration-300 z-1">
            <span class="relative"><?= $trans('home.hero.cta') ?></span>
          </a>
          <div class="button-glow"></div>
        </div>
        <nav class="flex gap-2 justify-center slide-up-stagger lg:max-w-[48ch] mt-2" data-reveal-action>
          <button type="button" aria-label="<?= htmlspecialchars($trans('common.previous')) ?>" class="subcategories-button-prev rounded-lg cursor-pointer text-gray-100 hover:bg-brand-100 hover:text-secondary-100 disabled:pointer-events-none disabled:opacity-30 p-2 transition-op-colors">
            <svg class="size-10 transition-colors"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#arrow-left"/></svg>
          </button>
          <button type="button" aria-label="<?= htmlspecialchars($trans('common.next')) ?>" class="subcategories-button-next rounded-lg cursor-pointer text-gray-100 hover:bg-brand-100 hover:text-secondary-100 disabled:pointer-events-none disabled:opacity-30 p-2 transition-op-colors">
            <svg class="size-10 transition-colors"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#arrow-right"/></svg>
          </button>
        </nav>
      </div>
    </div>
    <div class="w-full lg:w-2/5 px-2 lg:pl-0 h-full max-w-lg lg:max-w-none flex items-end">
      <div id="subcategories-swiper" class="native-card-scroller flex w-full items-center" aria-label="<?= htmlspecialchars($trans('home.control.title')) ?>">
        <div class="native-card-track items-center">
          <?php foreach($content['control_list'] as $slide): ?>
            <article data-native-slide class="swiper-slide group h-fit !grid grid-rows-[repeat(2,auto)] grid-cols-1 gap-0">
              <img class="rounded-2xl h-64 xl:h-80 w-full object-cover z-1 translate-y-32 xl:translate-y-40 opacity-0 group-[&.swiper-slide-active]:translate-y-0 group-[&.swiper-slide-active]:opacity-100 transition-op-trans" src="/public/images/home/<?= $slide['image'] ?>" <?= image_dimensions('/public/images/home/' . $slide['image']) ?> alt="<?= $slide['title'] ?>" loading="lazy">
              <div class="relative flex flex-col rounded-2xl h-full p-6 xl:p-10 bg-secondary-200 group-[&.swiper-slide-active]:bg-brand-100 text-surface-100 group-[&.swiper-slide-active]:text-secondary-100 group-[&.swiper-slide-active]:rounded-t-none before:absolute before:-top-8 before:left-0 before:w-full before:h-12 before:bg-brand-100 before:-z-1 before:opacity-0 group-[&.swiper-slide-active]:before:opacity-100 before:transition-opacity -translate-y-32 xl:-translate-y-40 group-[&.swiper-slide-active]:translate-y-0 transition-trans-colors duration-300">
                <h3 class="font-title leading-tight uppercase text-xl sm:text-3xl lg:text-4xl lg:es:text-3xl xl:es:text-5xl mb-4 text-balance"><?= $slide['title'] ?></h3>
                <p class="mb-2"><?= $slide['text'] ?></p>
                <p class=""><?= $slide['text2'] ?></p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Ready -->
<section data-nav-index="10" class="nav-section lg:snap-start relative w-full bg-gradient-to-b from-surface-200 to-surface-50" style="content-visibility:auto;contain-intrinsic-size:1000px;">
  <div class="block-content min-h-dvh flex-center flex-col text-secondary-200">
    <div class="stagger-parent flex-center flex-col text-center" data-reveal-trigger="section">
      <p class="uppercase md:text-lg lg:text-5xl mb-6 lg:mb-2 slide-up-stagger"><?= $trans('home.ready.title1') ?></p>
      <h2 class="font-title bg-clip-text bg-text-black pt-2 text-3xl sm:text-7xl md:text-3xl lg:text-[6vw] lg:es:text-[5vw] leading-none uppercase slide-up-stagger"><?= $trans('home.ready.title2') ?></h2>
      <p class="bg-clip-text bg-text-black text-lg sm:text-2xl md:text-3xl lg:text-3xl leading-tight mb-4 uppercase slide-up-stagger"><?= $trans('home.ready.text1') ?></p>
      <p class="font-title bg-clip-text bg-text-black text-lg sm:text-2xl md:text-3xl lg:text-5xl lg:es:pt-1 leading-tight uppercase slide-up-stagger"><?= $trans('home.ready.text2') ?></p>
      <div class="relative w-fit mt-4 mx-auto lg:mt-8 slide-up-stagger">
        <a href="<?= $currentLang === 'es' ? 'https://app.softwareformlm.com/widget/bookings/agendar_demo' : 'https://disr.vip/booking' ?>" target="_blank" rel="noopener noreferrer" class="button open-popup relative gradient rounded-lg lg:text-2xl px-7 lg:px-10 hover:text-white duration-300 z-1">
          <span class="relative"><?= $trans('home.hero.cta') ?></span>
        </a>
        <div class="button-glow"></div>
      </div>
    </div>
  </div>
</section>

<?php
$demoFormConfig = null;
if (!empty($includeDemoEmbed)) {
  $isBusinessHours = isArizonaBusinessHours();
  $formId = $isBusinessHours
    ? ($currentLang === 'es' ? 'X2ITzrwHHELujZVjnyQK' : 'ZYcPrzRgQkMc4ZocMJEj')
    : ($currentLang === 'es' ? 'SPxBEy47oduUYUIhcgA0' : '46NJyYtTIThYmprhbA4R');
  $formName = $isBusinessHours
    ? 'META ADS - LEADS FORM UTM' . ($currentLang === 'en' ? '  ZOOM - INGLES' : '')
    : 'META ADS - LEADS FORM UTM CALENDARIO - ' . ($currentLang === 'es' ? 'ESPANOL' : 'INGLES');
  $scriptSrc = 'https://link.msgsndr.com/js/form_embed.js';
  $src = 'https://api.leadconnectorhq.com/widget/form/' . $formId;

  $demoFormConfig = [
    'src' => $src,
    'scriptSrc' => $scriptSrc,
    'id' => 'inline-' . $formId,
    'title' => $formName,
    'height' => $isBusinessHours ? ($currentLang === 'es' ? '945' : '1153') : '1153',
    'formId' => $formId,
  ];
}
?>

<!-- Popup -->
<dialog id="demo-popup" class="popup bg-transparent m-auto w-full max-w-2xl px-7">
  <div class="relative w-full rounded-xl lg:rounded-2xl max-h-[90vh] overflow-x-hidden overflow-y-auto" style="background-color:#12173800">
    <button type="button" data-target="demo-popup" aria-label="Close dialog" class="close-popup absolute top-2 right-2 text-gray-100 bg-surface-200 hover:bg-brand-100 hover:text-secondary-100 rounded-lg cursor-pointer p-1 transition-colors">
      <svg class="size-6 transition-colors"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#xmark"/></svg>
    </button>
    <div
      class="min-h-[70vh] rounded-xl lg:rounded-2xl bg-white overflow-hidden"
      data-lazy-embed-root
      data-lazy-embed-state="idle"
    >
      <div class="flex min-h-[70vh] items-center justify-center p-6 text-center text-secondary-200">
        <p><?= $currentLang === 'es' ? 'Cargando demo...' : 'Loading demo...' ?></p>
      </div>
    </div>
    <?php if ($demoFormConfig !== null): ?>
      <script type="application/json" data-lazy-embed-config><?= json_encode($demoFormConfig, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?></script>
    <?php endif; ?>
  </div>
</dialog>

<!-- Product popups -->
<?php foreach($content['plans'] as $k => $product): ?>
  <dialog id="product-popup-<?= strtolower($product['title']) ?>" class="popup bg-transparent m-auto w-full max-w-2xl px-7">
    <div class="relative w-full bg-white rounded-xl lg:rounded-2xl max-h-[90vh] overflow-x-hidden overflow-y-auto">
      <button type="button" data-target="product-popup-<?= strtolower($product['title']) ?>" aria-label="Close dialog" class="close-popup absolute top-2 right-2 text-gray-100 bg-surface-200 hover:bg-brand-100 hover:text-secondary-100 rounded-lg cursor-pointer p-1 transition-colors">
        <svg class="size-6 transition-colors"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#xmark"/></svg>
      </button>
      <div class="p-6 lg:p-10 text-secondary-200">
        <h3 class="font-title text-center text-2xl lg:text-4xl mb-4"><?= $product['title'] ?></h3>

        <?php foreach(($product['modal']['intro'] ?? []) as $paragraph): ?>
          <p class="mb-2"><?= $paragraph ?></p>
        <?php endforeach; ?>

        <h4 class="font-bold text-lg mt-4 mb-2"><?= $product['modal']['features_title'] ?? '' ?></h4>
        <ul class="space-y-2 mb-6">
          <?php foreach(($product['modal']['features'] ?? []) as $feature): ?>
            <li class="flex gap-1.5 items-start">
              <svg class="size-6 shrink-0 text-brand-200"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#check-circle"/></svg>
              <span><?= $feature ?></span>
            </li>
          <?php endforeach; ?>
        </ul>

        <h4 class="font-bold text-lg mb-2"><?= $product['modal']['ideal_for_title'] ?? '' ?></h4>
        <ul class="space-y-2 mb-6">
          <?php foreach(($product['modal']['ideal_for'] ?? []) as $idealItem): ?>
            <li class="flex gap-1.5 items-start">
              <svg class="size-6 shrink-0 text-brand-200"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#check-circle"/></svg>
              <span><?= $idealItem ?></span>
            </li>
          <?php endforeach; ?>
        </ul>

        <p class="font-title text-center text-xl lg:text-2xl leading-tight mb-6"><?= $product['modal']['closing'] ?? '' ?></p>

        <div class="relative w-fit mx-auto">
          <a href="<?= $constants['shop_link'] . $product['slug'] . '?ref=' . $GLOBALS['user_replica'] ?>" target="_blank" rel="noopener noreferrer" class="button relative gradient rounded-lg lg:text-lg xl:text-xl px-7 lg:px-10 lg:es:px-4 xl:es:px-10 hover:text-white duration-300 z-1">
            <span class="relative"><?= $trans('nav.buy') ?></span>
          </a>
          <div class="button-glow"></div>
        </div>
      </div>
    </div>
  </dialog>
<?php endforeach; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
