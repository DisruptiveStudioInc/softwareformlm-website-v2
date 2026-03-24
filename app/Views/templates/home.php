<?php
$pageTitle = $trans('home.title');
$clients = array_merge($constants['clients'], $constants['clients'], $constants['clients'], $constants['clients'], $constants['clients']);
// $clients = $constants['clients'];
require __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../components/sideDotsNavigation.php';
?>

<!-- Hero -->
<section data-nav-index="0" class="nav-section relative text-white w-full overflow-x-hidden">
  <div class="absolute -z-1 w-full h-full top-0 left-0">
    <img class="background" src="/public/images/background/black-01.webp" alt="" loading="eager" fetchpriority="high">
    <img class="background opacity-0 animate-cycle" src="/public/images/background/black-02.webp" alt="" loading="lazy" style="animation-duration:36s;animation-delay:12s">
    <img class="background opacity-0 animate-cycle" src="/public/images/background/black-03.webp" alt="" loading="lazy" style="animation-duration:36s;animation-delay:24s">
  </div>
  <div class="block-content py-16 lg:py-24 min-h-dvh flex-center gap-4 flex-col lg:flex-row-reverse">
    <div class="lg:w-1/2 text-center lg:text-left">
      <h2 class="font-khand uppercase bg-clip-text bg-text-white leading-none text-5xl xs:text-7xl sm:text-8xl md:text-11xl xl:text-12xl text-balance es:pt-2"><?= $trans('home.hero.title') ?></h2>
      <p class="lg:text-xl text-balance text-white"><?= $trans('home.hero.text') ?></p>
      <a href="<?= $constants['zoom'] ?>" target="_blank" rel="noopener noreferrer" class="button inline-flex rounded-full mt-4 mx-auto lg:mx-0 lg:mt-8 px-7 lg:px-10 bg-white border border-brand-100 text-secondary-200 hover:bg-brand-100 active:bg-brand-100 hover:text-white active:text-white"><?= $trans('common.demo') ?></a>
    </div>
    <div class="relative lg:w-1/2">
      <img src="/public/images/home/bo-computer.webp" alt="" class="max-h-[40vh] w-auto mx-auto lg:max-h-none lg:w-9/10 lg:ml-0 lg:mr-auto" loading="eager">
    </div>
  </div>
</section>

<!-- Operate -->
<section data-nav-index="1" class="nav-section relative bg-surface-100">
  <span class="absolute top-0" id="sfmlm"></span>
  <div class="block-content min-h-dvh flex-center flex-col justify-center py-16 lg:py-32 xl:py-40">
    <h2 class="font-title text-center leading-tight uppercase text-2xl md:text-3xl lg:text-5xl xl:text-[4vw] slide-up-words-black"><?= $trans('home.operate.title') ?></h2>
    <p class="text-center lg:text-xl text-balance mb-6 lg:mb-16 slide-up"><?= $trans('home.operate.text') ?></p>
    <ul class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-7 max-w-md md:max-w-none mx-auto mb-6 lg:mb-16">
      <?php foreach($content['operate'] as $item): ?>
        <li class="bg-surface-50 rounded-2xl p-4 md:p-6 lg:p-7 drop-shadow-lg drop-shadow-grey-100/10">
          <h3 class="text-center font-bold mb-4 leading-tight text-lg lg:text-2xl text-secondary-200">
            <?= $item['title'] ?>
          </h3>
          <p class="text-center md:font-light ext-balance"><?= $item['text'] ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="stagger-parent flex-center flex-col">
      <a href="<?= $constants['zoom'] ?>" target="_blank" rel="noopener noreferrer" class="button rounded-lg slide-up-stagger">
        <?= $trans('common.demo') ?>
      </a>
      <p class="slide-up-stagger text-center mt-4"><?= $trans('home.operate.footnote') ?></p>
    </div>
  </div>
</section>

<!-- Steps -->
<section data-nav-index="2" class="nav-section relative bg-surface-200">
  <span class="absolute top-0 left-0 size-0"></span>
  <div class="block-content min-h-dvh py-16 lg:py-20 flex flex-col justify-center">
    <div class="flex justify-center flex-wrap gap-6 lg:gap-12 max-w-md md:max-w-3xl lg:max-w-none mx-auto stagger-parent">
      <?php foreach($content['steps'] as $k => $step): ?>
        <article class="group w-full md:w-[calc(50%_-_--spacing(6))] lg:w-[calc(50%_-_--spacing(12))] p-4 md:p-5 flex-center flex-col bg-white hover:bg-brand-100 text-grey-100 hover:text-white drop-shadow-md drop-shadow-grey-100/20 rounded-xl md:rounded-2xl slide-up-stagger transition-colors">
          <h2 class="font-title uppercase text-center text-brand-100 group-hover:text-white mb-2 sm:mb-6 transition-colors"><?= 0 . ($k+1) . "." ?> <?= $step['number'] ?></h2>
          <div class="w-full flex-center flex-col text-center flex-grow">
            <h3 class="font-title leading-tight text-balance text-secondary-200 group-hover:text-white text-lg md:text-xl lg:text-2xl mb-2 transition-colors"><?= $step['title'] ?></h3>
            <p class="transition-colors"><?= $step['text'] ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="stagger-parent flex-center flex-col mt-6 lg:mt-12">
      <a href="<?= $constants['zoom'] ?>" target="_blank" rel="noopener noreferrer" class="button rounded-lg slide-up-stagger">
        <?= $trans('common.demo') ?>
      </a>
      <p class="slide-up-stagger text-center mt-4"><?= $trans('home.operate.footnote') ?></p>
    </div>
  </div>
</section>

<!-- Network -->
<section data-nav-index="3" class="nav-section relative tech-section snap-align-none h-screen w-full overflow-hidden bg-surface-300" style="height:100vh;">
  <div class="block-content h-screen py-12 lg:py-40 flex-center flex-col overflow-hidden" style="height:100vh;">
    <h2 class="tech-title font-title leading-none uppercase text-2xl sm:text-5xl md:text-8xl lg:text-9xl text-center slide-up-words-black"><?= $trans('home.network.title') ?></h2>
    <div class="w-full mx-auto">
      <?php foreach($content['network'] as $k => $slide): ?>
        <div class="absolute top-1/2 left-1/2 -translate-1/2 w-3/5 lg:max-w-9/20">
          <article class="tech-card flex-center flex-col text-center bg-brand-100 text-secondary-100 px-4 py-6 lg:p-10 rounded-2xl
          <?= $k===1 ? '-translate-x-1/4' : '' ?>
          <?= $k===2 ? 'translate-x-3/10 lg:translate-x-1/2' : '' ?>
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
<section data-nav-index="4" class="nav-section relative text-white">
  <span class="absolute top-0 left-0 size-0"></span>
  <?php generateBackground('creators',3); ?>
  <div class="block-content min-h-dvh py-16 lg:py-40 flex items-center">
    <h2 class="banner-text font-title leading-none uppercase text-[9vw] md:text-10xl lg:text-12xl slide-up-words-white"><?= $trans('home.scale.title') ?></h2>
  </div>
</section>

<!-- Scale Info -->
<section data-nav-index="5" class="nav-section relative section-about bg-surface-100 text-secondary-200 w-full overflow-hidden">
  <span class="absolute top-0 left-0 size-0"></span>
  <div class="block-content about-content min-h-dvh flex-center flex-col text-center">
    <p class="max-w-[64ch] mx-auto my-6 lg:text-2xl text-balance slide-up"><?= $trans('home.scale.text') ?></p>
    <p class="font-title uppercase text-lg md:text-xl lg:text-8xl max-w-[20ch] leading-tight mx-auto slide-up"><?= $trans('home.scale.accent') ?></p>
    <a href="<?= $constants['zoom'] ?>" target="_blank" rel="noopener noreferrer" class="button rounded-lg slide-up lg:text-xl mt-6 lg:mt-12">
      <?= $trans('common.demo') ?>
    </a>
  </div>
</section>

<!-- Customize -->
<section data-nav-index="6" class="nav-section relative bg-surface-200">
  <div class="block-content py-16 lg:py-24 min-h-dvh flex-center gap-7 lg:gap-4 flex-col lg:flex-row-reverse">
    <div class="lg:w-1/2 text-center lg:text-left">
      <h2 class="font-khand uppercase bg-clip-text bg-text-black leading-none text-5xl xs:text-7xl sm:text-8xl md:text-11xl xl:text-10xl text-balance es:pt-2"><?= $trans('home.customize.title') ?></h2>
      <p class="text-secondary-200 lg:text-xl text-balance"><?= $trans('home.customize.text') ?></p>
      <p class="text-secondary-200 lg:text-xl text-balance"><?= $trans('home.customize.text2') ?></p>
      <div class="stagger-parent flex flex-col items-center lg:items-start mt-6 lg:mt-12">
        <a href="<?= $constants['zoom'] ?>" target="_blank" rel="noopener noreferrer" class="button rounded-lg slide-up-stagger">
          <?= $trans('common.demo') ?>
        </a>
        <p class="slide-up-stagger text-center mt-4"><?= $trans('home.customize.footnote') ?></p>
      </div>
    </div>
    <div class="relative lg:w-1/2 lg:pr-12">
      <img src="/public/images/home/bo-mobile.webp" alt="" class="rounded-xl md:rounded-2xl mx-auto max-h-[45vh] h-full lg:max-h-none lg:h-auto" loading="lazy">
    </div>
  </div>
</section>

<!-- Clients -->
<section data-nav-index="7" class="nav-section relative min-h-dvh py-16 flex-center flex-col overflow-x-hidden bg-surface-300">
  <span class="absolute top-0 left-0 size-0"></span>
  <div class="text-center px-7 pb-20">
    <h2 class="font-title leading-tight uppercase text-2xl sm:text-6xl lg:text-7xl xl:text-9xl slide-up-words-black"><?= $trans('home.clients') ?></h2>
  </div>
  <ul class="clients-swiper swiper !overflow-visible w-full linear-swiper mask-x-from-70% mask-x-to-90% pointer-events-none">
    <div class="swiper-wrapper items-center">
      <?php foreach($clients as $item): ?>
        <li class="swiper-slide !flex flex-center h-40">
          <img src="/public/images/clients/<?= $item['logo'] ?>" alt="<?= $item['name'] ?>" loading="lazy" class="">
        </li>
      <?php endforeach; ?>
    </div>
  </ul>
</section>

<!-- Plans -->
<section data-nav-index="8" class="nav-section relative bg-surface-100">
  <span class="absolute top-0 left-0 size-0" id="plans"></span>
  <div class="block-content min-h-dvh flex-center flex-col py-16 lg:py-32">
    <h2 class="font-title text-center leading-tight uppercase text-2xl sm:text-6xl lg:text-3xl xl:text-5xl mb-4 lg:mb-12 slide-up-words-black"><?= $trans('home.plans.title') ?></h2>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 xl:gap-6">
      <?php foreach($content['plans'] as $k => $item): ?>
        <article class="bg-white rounded-lg p-4 lg:p-6 flex flex-col">
          <h3 class="font-title uppercase text-center text-lg lg:text-2xl text-secondary-200 mb-4"><?= $item['title'] ?></h3>
          <p class="text-pretty mb-2">
            <span class="font-bold"><?= $trans('home.plans.user_limit').':' ?></span>
            <?= $item['users'] ?>
          </p>
          <p class="text-pretty mb-6 lg:min-h-12 xl:en:min-h-0">
            <span class="font-bold"><?= $trans('home.plans.support').':' ?></span>
            <?= $item['support'] ?>
          </p>
          <p class="font-title text-brand-200 text-center text-xl lg:text-6xl"><?= '$'."{$item['price']}.00" ?></p>
          <a href="<?= $constants['zoom'] ?>" target="_blank" rel="noopener noreferrer" class="button rounded-lg">
            <?= $trans('common.demo') ?>
          </a>
          <ul class="mt-6 text-sm lg:text-base text-secondary-200 flex flex-col gap-0">
            <?php foreach($item['items'] as $feature => $available): ?>
              <li class="flex items-center justify-between gap-2 py-2 first:border-t border-b border-secondary-100/20">
                <span class="text-balance text-left <?= $available ? 'text-secondary-200' : 'text-secondary-100/70' ?>"><?= $trans('home.plans.items.' . $feature) ?></span>
                <svg class="shrink-0 size-6 <?= $available ? 'text-green-400' : 'text-red-400' ?>"><use href="#<?= $available ? 'check-circle' : 'x-circle' ?>"/></svg>
              </li>
            <?php endforeach; ?>
          </ul>
          <a href="<?= $constants['zoom'] ?>" target="_blank" rel="noopener noreferrer" class="button rounded-lg lg:text-xl mt-6">
            <?= $trans('common.demo') ?>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- Control -->
<section data-nav-index="9" class="nav-section relative w-full overflow-x-hidden bg-surface-200">
  <span class="absolute top-0 left-0 size-0"></span>
  <div class="block-content min-h-dvh lg:max-w-none lg:px-0 py-16 lg:py-40 flex-center flex-col lg:flex-row lg:justify-end gap-4 lg:gap-0">
    <div class="half max-lg:max-w-none lg:pr-12 w-full lg:w-1/2 text-center lg:text-left max-lg:px-0">
      <h2 class="solutions-title font-title uppercase leading-none text-2xl sm:text-6xl lg:text-7xl slide-up-words-black">
        <?= $trans('home.control.title') ?>
      </h2>
      <p class="lg:text-xl mb-6 slide-up"><?= $trans('home.control.subtitle') ?></p>
      <nav class="flex gap-2 justify-center slide-up lg:max-w-[48ch]">
        <button class="subcategories-button-prev rounded-lg cursor-pointer text-gray-100 hover:bg-brand-100 hover:text-secondary-100 [&.swiper-button-disabled]:pointer-events-none [&.swiper-button-disabled]:opacity-30 p-2 transition-op-colors">
          <svg class="size-10 transition-colors"><use href="#arrow-left"/></svg>
        </button>
        <button class="subcategories-button-next rounded-lg cursor-pointer text-gray-100 hover:bg-brand-100 hover:text-secondary-100 [&.swiper-button-disabled]:pointer-events-none [&.swiper-button-disabled]:opacity-30 p-2 transition-op-colors">
          <svg class="size-10 transition-colors"><use href="#arrow-right"/></svg>
        </button>
      </nav>
    </div>
    <div class="w-full lg:w-1/2 px-2 lg:pl-0 lg:pr-[18%] lg:overflow-x-hidden h-full max-w-lg sm:max-w-sm lg:max-w-none flex items-end">
      <div id="subcategories-swiper" data-swiper-autoplay="2000" class="swiper flex w-full !overflow-visible items-center">
        <div class="swiper-wrapper !overflow-visible items-center">
          <?php foreach($content['control_list'] as $slide): ?>
            <article class="swiper-slide group h-fit !grid grid-rows-[repeat(2,auto)] grid-cols-1 gap-0">
              <img class="rounded-2xl h-64 xl:h-80 w-full object-cover z-1 translate-y-32 xl:translate-y-40 opacity-0 group-[&.swiper-slide-active]:translate-y-0 group-[&.swiper-slide-active]:opacity-100 transition-op-trans" src="/public/images/home/<?= $slide['image'] ?>" alt="<?= $slide['title'] ?>" loading="lazy">
              <div class="relative flex flex-col rounded-2xl h-full p-6 xl:p-10 bg-secondary-200 group-[&.swiper-slide-active]:bg-brand-100 text-surface-100 group-[&.swiper-slide-active]:text-secondary-100 group-[&.swiper-slide-active]:rounded-t-none before:absolute before:-top-8 before:left-0 before:w-full before:h-12 before:bg-brand-100 before:-z-1 before:opacity-0 group-[&.swiper-slide-active]:before:opacity-100 before:transition-opacity -translate-y-32 xl:-translate-y-40 group-[&.swiper-slide-active]:translate-y-0 transition-trans-colors duration-300">
                <h3 class="font-title leading-tight uppercase text-xl sm:text-3xl lg:text-4xl lg:es:text-3xl xl:es:text-5xl mb-4 text-pretty"><?= $slide['title'] ?></h3>
                <p class=""><?= $slide['text'] ?></p>
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
<section data-nav-index="10" class="nav-section relative w-full bg-gradient-to-b from-surface-200 to-surface-50">
  <div class="block-content min-h-dvh flex-center flex-col text-secondary-200">
    <div class="stagger-parent flex-center flex-col text-center">
      <p class="uppercase md:text-lg lg:text-5xl mb-6 lg:mb-2 slide-up-stagger"><?= $trans('home.ready.title1') ?></p>
      <h2 class="font-title bg-clip-text bg-text-black pt-2 text-3xl sm:text-7xl md:text-3xl lg:text-[6vw] lg:es:text-[5vw] leading-none uppercase slide-up-stagger"><?= $trans('home.ready.title2') ?></h2>
      <p class="bg-clip-text bg-text-black text-lg sm:text-2xl md:text-3xl lg:text-3xl leading-tight mb-4 uppercase slide-up-stagger"><?= $trans('home.ready.text1') ?></p>
      <p class="font-title bg-clip-text bg-text-black text-lg sm:text-2xl md:text-3xl lg:text-5xl lg:es:pt-1 leading-tight uppercase slide-up-stagger"><?= $trans('home.ready.text2') ?></p>
      <a href="<?= $constants['zoom'] ?>" target="_blank" rel="noopener noreferrer" class="button w-fit bg-brand-100 text-lg lg:text-xl rounded-full font-semibold px-7 py-3 hover:bg-brand-200 mt-6 mt-12 transition-colors slide-up-stagger">
        <?= $trans('common.demo') ?>
      </a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
