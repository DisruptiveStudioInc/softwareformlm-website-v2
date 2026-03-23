<?php
$pageTitle = $meta['meta_title'] ?? $content['hero']['title'];
$metaDescription = $meta['meta_description'] ?? '';
require __DIR__ . '/../layouts/header.php';
?>

<div class="fixed -z-2 w-full h-full top-0 left-0">
  <img class="background" src="/public/images/background/black-01.webp" alt="" loading="lazy">
  <img class="background opacity-0 animate-cycle" src="/public/images/background/black-02.webp" alt="" loading="lazy" style="animation-duration:36s;animation-delay:12s">
  <img class="background opacity-0 animate-cycle" src="/public/images/background/black-03.webp" alt="" loading="lazy" style="animation-duration:36s;animation-delay:24s">
</div>

<!-- Hero -->
<section class="relative">
  <div class="absolute -z-1 w-full h-screen top-0 left-0">
    <img class="background" src="/public/images/background/white-g2-01.webp" alt="" loading="eager" fetchpriority="high">
    <img class="background opacity-0 animate-cycle" src="/public/images/background/white-g2-02.webp" alt="" loading="eager" style="animation-duration:36s;animation-delay:12s">
    <img class="background opacity-0 animate-cycle" src="/public/images/background/white-g2-03.webp" alt="" loading="lazy" style="animation-duration:36s;animation-delay:24s">
  </div>

  <div class="block-content py-16 lg:py-40 min-h-dvh flex-center flex-col-reverse lg:flex-row lg:gap-12 xl:gap-32">
    <div class="lg:w-1/2">
      <div class="flex items-center gap-4 mb-6 lg:mb-12 w-fit mx-auto lg:mx-0">
        <ul class="flex gap-0 -space-x-2 sm:-space-x-4 shrink-0">
          <?php foreach($content['hero_tag']['images'] as $k => $img): ?>
            <li class="opacity-0 animate-fadein" style="animation-delay:calc(100ms + (50ms * <?= $k ?>))">
              <img src="/public/images/services/ips/<?= $img ?>" alt="client" class="size-7 sm:size-12 rounded-full shadow-md shadow-secondary-50/40 bg-surface-100 object-cover">
            </li>
          <?php endforeach; ?>
        </ul>
        <p class="text-xs md:text-sm lg:text-base max-w-[36ch] lg:max-w-none opacity-0 animate-fadein" style="animation-delay:300ms"><?= $content['hero_tag']['text'] ?></p>
      </div>
      <h1 class="font-title font-bold bg-clip-text bg-text-black uppercase text-lg md:text-2xl lg:text-4xl xl:text-6xl text-balance leading-tight text-center lg:text-left sm:mb-4 opacity-0 animate-slideup" style="animation-delay:400ms"><?= $content['hero'] ?></h1>
      <p class="lg:text-xl mb-6 lg:mb-12 text-center lg:text-left opacity-0 animate-slideup" style="animation-delay:500ms"><?= $content['hero_text'] ?></p>
      <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 justify-center lg:justify-start opacity-0 animate-slideup" style="animation-delay:600ms">
        <a href="<?= $content['hero_cta_main']['link'].$constants['contact_info']['wame'] ?>" target="_blank" rel="noopener noreferrer" class="button rounded-full sm:px-7 bg-white text-secondary-200 border-2 border-brand-100 hover:bg-brand-100 active:bg-brand-100 hover:text-white active:text-white text-center">
          <?= $content['hero_cta_main']['text'] ?>
        </a>
        <a href="<?= $content['hero_cta_secondary']['link'] ?>" class="button rounded-full sm:px-7 text-center">
          <?= $content['hero_cta_secondary']['text'] ?>
        </a>
      </div>
    </div>
    <div class="lg:w-1/2">
      <img src="/public/images/services/ips/<?= $content['hero_image'] ?>" alt="" class="rounded-xl lg:rounded-2xl w-4/5 max-w-xl lg:w-full lg:max-w-none mx-auto mb-8 lg:mb-0 opacity-0 animate-fadein" style="animation-delay:100ms">
    </div>
  </div>
</section>

<!-- Benefits -->
<section class="relative text-white">
  <span class="absolute top-0 left-0" id="benefits"></span>
  <div class="block-content py-16 lg:py-40">
    <h2 class="font-semibold uppercase text-center text-sm md:text-base lg:text-xl mb-2 lg:mb-4 slide-up"><?= $trans('common_titles.benefits') ?></h2>
    <p class="font-title pt-1 uppercase text-center text-xl sm:text-3xl lg:text-8xl xl:text-10xl leading-tight text-balance slide-up-words-white-scroll"><?= $content['benefits_title'] ?></p>
    <p class="text-center lg:text-xl max-w-[64ch] mb-8 mx-auto lg:mb-20 slide-up"><?= $content['benefits_text'] ?></p>
    <div class="flex flex-col gap-20 max-w-screen-xl mx-auto snap-y snap-proximity">
      <?php foreach($content['benefits'] as $k => $item): ?>
        <article class="ip-benefit opacity-0 flex-center flex-col lg:flex-row gap-4 lg:gap-12 xl:gap-32 max-w-xl lg:max-w-none mx-auto lg:mx-0 snap-center">
          <img src="/public/images/services/ips/<?= $item['image'] ?>" alt="<?= $item['title'] ?>" class="rounded-xl lg:rounded-2xl w-full lg:w-1/2">
          <div class="w-full lg:w-1/2">
            <p class="text-base lg:text-2xl"><?= sprintf("%02d", $k + 1) ?></p>
            <h3 class="font-title bg-clip-text bg-text-white pt-1 uppercase leading-tight text-lg md:text-2xl lg:text-5xl xl:text-7xl text-balance my-2 sm:my-4 lg:my-6"><?= $item['title'] ?></h3>
            <p class="lg:text-lg xl:text-xl text-balance"><?= $item['text'] ?></p>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- How works -->
<section class="text-white">
  <div class="block-content py-16 lg:py-40 min-h-dvh">
    <h2 class="font-semibold uppercase text-center text-sm md:text-base lg:text-xl mb-2 lg:mb-4 slide-up"><?= $trans('common_titles.how_works') ?></h2>
    <p class="font-title pt-1 uppercase text-center text-xl sm:text-3xl lg:text-7xl xl:text-8xl leading-tight text-balance slide-up-words-white-scroll"><?= $content['how_works_title'] ?></p>
    <p class="text-center lg:text-xl mb-8 lg:mb-20 slide-up"><?= $content['how_works_text'] ?></p>
    <div class="lg:flex duration-300 stagger-parent">
      <ul id="ip-works-tabs" class="bg-secondary-200 p-4 sm:p-6 lg:p-8 lg:pr-12 rounded-xl lg:rounded-2xl flex flex-col gap-8 max-w-md lg:max-w-none lg:w-11/20 mx-auto lg:mx-0">
        <?php foreach($content['how_works_list'] as $k => $item): ?>
          <li class="ip-works-tab group slide-up-stagger <?= $k === 0 ? 'active' : '' ?>">
            <img src="/public/images/services/sec5_slide.svg" alt="<?= $item['title'] ?>" class="rounded-md lg:hidden">
            <div class="ip-works-trigger flex items-center gap-3 mt-4 lg:mt-0 cursor-pointer" data-index="<?= $k ?>">
              <span class="flex-center size-7 sm:size-8 bg-brand-100 lg:bg-brand-50/70 lg:group-hover:bg-brand-100 lg:group-[&.active]:bg-brand-200 font-semibold text-base leading-none rounded-full shrink-0 pt-1 mb-2 transition-colors"><?= $k + 1; ?></span>
              <h3 class="font-title uppercase text-base sm:text-xl xl:text-2xl lg:text-surface-300 lg:group-hover:text-white lg:group-[&.active]:text-white transition-colors"><?= $item['title'] ?></h3>
            </div>
            <div class="ip-works-content lg:grid grid-rows-[0fr] [&.open]:grid-rows-[1fr] transition-grid-rows <?= $k === 0 ? 'open' : '' ?>">
              <p class="lg:overflow-hidden"><?= $item['text'] ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
      <div class="relative hidden lg:flex items-center w-9/20">
        <?php foreach($content['how_works_list'] as $k => $item): ?>
          <div data-index="<?= $k ?>" class="ip-works-image-wrap absolute top-1/2 -left-10 w-4/5 -translate-y-1/2 perspective-distant group opacity-stagger <?= $k === 0 ? 'active': '' ?>">
            <img src="/public/images/services/ips/<?= $item['image'] ?>" alt="<?= $item['title'] ?>" class="ip-works-image relative rounded-2xl -rotate-y-24 group-[&.active]:rotate-y-0 shadow-xl shadow-secondary-200/40 transition-transform">
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="relative">
  <?php generateBackground('white2',3, true); ?>

  <div class="block-content max-w-screen-lg py-16 lg:py-40 min-h-dvh">
    <h2 class="font-title uppercase text-center text-lg md:text-2xl lg:text-4xl xl:text-6xl mb-8 lg:mb-20 slide-up-words-black"><?= $trans('common_titles.faqs') ?></h2>
    <ul class="flex flex-col gap-2 lg:gap-0">
      <?php foreach($content['faqs'] as $k => $item): ?>
        <li class="flex w-full group lg:odd:justify-end slide-up">
          <div class="relative rounded-xl bg-brand-100 group-odd:bg-secondary-200 text-white p-4 pl-6 lg:p-6 lg:group-odd:pl-8 lg:group-even:pr-8 w-full lg:w-2/3 group-odd:origin-right group-even:origin-left lg:scale-100 lg:hover:scale-110 transition-transform duration-300 lg:hover:z-2">
            <span class="flex-center size-8 lg:size-10 pt-1 bg-inherit rounded-full font-bold text-lg lg:text-xl leading-none absolute top-1/2 left-0 -translate-1/2 lg:group-even:left-full"><?= $k + 1; ?></span>
            <h3 class="font-bold text-xl lg:text-2xl mb-2"><?= $item['title'] ?></h3>
            <p><?= $item['text'] ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<!-- Banner -->
<section class="relative text-white">
  <?php generateBackground('builder',3, true); ?>

  <div class="block-content flex-center flex-col min-h-dvh py-16 lg:py-40">
    <h2 class="font-title pt-1 uppercase text-center text-3xl sm:text-5xl lg:text-7xl xl:text-8xl leading-tight text-balance slide-up-words-white-scroll"><?= $content['banner_title'] ?></h2>
    <p class="text-center lg:text-2xl my-5 lg:my-8 text-pretty max-w-[52ch] slide-up"><?= $content['banner_text'] ?></p>
    <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 justify-center lg:justify-start w-full lg:w-fit slide-up">
      <a href="<?= $content['banner_cta_main']['link'].$constants['contact_info']['wame'] ?>" target="_blank" rel="noopener noreferrer" class="button rounded-full sm:px-7 bg-white text-secondary-200 border-2 border-brand-100 hover:bg-brand-100 active:bg-brand-100 hover:text-white active:text-white text-center">
        <?= $content['banner_cta_main']['text'] ?>
      </a>
      <a href="<?= route($content['banner_cta_secondary']['link'], $currentLang) ?>" class="button rounded-full sm:px-7 text-center">
        <?= $content['banner_cta_secondary']['text'] ?>
      </a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>