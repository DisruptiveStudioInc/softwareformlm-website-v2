<?php
$pageTitle = $meta['meta_title'] ?? $content['hero']['title'];
$encodedTitle = urlencode($pageTitle);
$metaDescription = $meta['meta_description'] ?? '';
$iconSprite = '/public/assets/icons.svg';
require __DIR__ . '/../layouts/header.php';
include __DIR__ . '/../components/fixedBackground.php';
?>

<div class="fixed left-2 right-2 bottom-5 md:left-7 md:right-7 md:bottom-7 flex flex-col md:flex-row justify-between items-center en:items-start en:md:items-center z-10 gap-0 en:mr-14">
  <div id="serv-dots" role="group" aria-label="Service sections" class="flex gap-2 xs:gap-4 !transform-none en:ml-22 en:md:ml-0"></div>
  <nav class="absolute top-1/2 md:static flex gap-4 en:gap-1.5 en:lg:gap-4 w-full en:w-auto md:w-auto justify-between">
    <button type="button" id="serv-prev" aria-label="<?= htmlspecialchars($trans('common.previous')) ?>" class="button rounded-lg leading-none gap-2 cursor-pointer -translate-y-1/2 md:translate-none disabled:opacity-0 disabled:pointer-events-none max-md:p-2">
      <svg class="size-5"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#arrow-left"/></svg>
      <span class="hidden md:inline"><?= $trans('common.previous') ?></span>
    </button>
    <button type="button" id="serv-next" aria-label="<?= htmlspecialchars($trans('common.next')) ?>" class="button rounded-lg leading-none gap-2 cursor-pointer -translate-y-1/2 md:translate-none disabled:opacity-0 disabled:pointer-events-none max-md:p-2">
      <span class="hidden md:inline"><?= $trans('common.next') ?></span>
      <svg class="size-5"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#arrow-right"/></svg>
    </button>
  </nav>
</div>

<div class="service-slider-shell">

  <div data-service-slider class="service-slider">
    <div data-service-slides class="service-slider-track">
      <!-- Hero section -->
      <section data-service-slide class="slide-section swiper-slide group min-h-dvh lg:h-screen w-full">
        <div class="block-content py-16 lg:py-24 h-full flex-center gap-4 flex-col lg:flex-row">
          <div class="lg:w-1/2 text-center lg:text-left">
            <h1 class="font-khand uppercase bg-clip-text bg-text-black leading-none text-5xl xs:text-7xl sm:text-8xl md:text-11xl xl:text-12xl text-balance es:pt-2"><?= $content['hero'] ?></h1>
            <p class="lg:text-xl text-secondary-200 text-balance"><?= $content['hero_text'] ?></p>
            <button class="button rounded-lg mt-4 mx-auto lg:mx-0 lg:mt-8 px-7 lg:px-10 bg-white border border-brand-100 text-secondary-200 hover:bg-brand-100 active:bg-brand-100 hover:text-white active:text-white" type="button" id="serv-int-button"><?= $trans('common.know_more') ?></button>
          </div>
          <div class="relative lg:w-1/2">
            <?= responsive_image('/public/images/services/solutions/' . $content['hero_images']['big'], '', 'rounded-xl md:rounded-2xl lg:min-w-[44vw] relative max-h-[45vh] h-full lg:max-h-none lg:h-auto lg:absolute lg:top-1/2 lg:left-1/5 opacity-0 group-[&.swiper-slide-fully-visible]:opacity-100 translate-y-12 group-[&.swiper-slide-fully-visible]:translate-y-0 lg:-translate-y-[calc(50%_-_--spacing(12))] lg:group-[&.swiper-slide-fully-visible]:-translate-y-1/2 transition-op-trans duration-500 delay-200', '(min-width: 1088px) 44vw, 90vw', ['loading' => 'eager', 'fetchpriority' => 'high']) ?>
            <img src="/public/images/services/solutions/<?= $content['hero_images']['small'] ?>" <?= image_dimensions('/public/images/services/solutions/' . $content['hero_images']['small']) ?> alt="" class="absolute lg:relative rounded-xl md:rounded-2xl w-1/3 bottom-6 lg:bottom-0 -left-6 sm:-left-16 lg:left-0 lg:w-52 xl:w-auto shadow-lg lg:shadow-xl xl:shadow-serv opacity-0 group-[&.swiper-slide-fully-visible]:opacity-100 translate-y-12 group-[&.swiper-slide-fully-visible]:translate-y-0 lg:translate-y-22 lg:group-[&.swiper-slide-fully-visible]:translate-y-10 xl:translate-y-20 xl:group-[&.swiper-slide-fully-visible]:translate-y-8 transition-op-trans duration-500 delay-300" loading="eager">
          </div>
        </div>
      </section>

      <!-- About 1 section -->
      <section data-service-slide class="slide-section swiper-slide group min-h-dvh lg:h-screen w-full">
        <div class="block-content py-16 lg:py-24 h-full flex-center gap-4 flex-col lg:flex-row">
          <div class="lg:w-11/20 text-center lg:text-left">
            <h2 class="font-khand uppercase bg-clip-text bg-text-black leading-none text-5xl xs:text-7xl sm:text-8xl md:text-11xl xl:text-12xl text-balance es:pt-2"><?= $content['about1_title'] ?></h2>
          </div>
          <div class="lg:w-9/20 flex">
            <img src="/public/images/services/solutions/<?= $content['about1_images']['front'] ?>" <?= image_dimensions('/public/images/services/solutions/' . $content['about1_images']['front']) ?> alt="" class="rounded-xl md:rounded-2xl max-h-[45vh] h-full lg:max-h-none lg:h-auto w-1/2 shadow-lg lg:shadow-xl xl:shadow-serv opacity-0 group-[&.swiper-slide-fully-visible]:opacity-100 scale-90 group-[&.swiper-slide-fully-visible]:scale-100 transition-op-trans duration-500 delay-200" loading="lazy">
            <img src="/public/images/services/solutions/<?= $content['about1_images']['back'] ?>" <?= image_dimensions('/public/images/services/solutions/' . $content['about1_images']['back']) ?> alt="" class="rounded-xl md:rounded-2xl max-h-[45vh] h-full lg:max-h-none lg:h-auto w-1/2 -translate-x-8 translate-y-16 shadow-lg lg:shadow-xl xl:shadow-serv opacity-0 group-[&.swiper-slide-fully-visible]:opacity-100 scale-90 group-[&.swiper-slide-fully-visible]:scale-100 transition-op-trans duration-500 delay-300" loading="lazy">
          </div>
        </div>
      </section>

      <!-- About 2 section -->
      <section data-service-slide class="slide-section swiper-slide group min-h-dvh lg:h-screen w-full">
        <div class="block-content py-16 lg:py-24 h-full flex-center gap-7 lg:gap-4 flex-col lg:flex-row">
          <div class="lg:w-1/2 text-center lg:text-left">
            <h2 class="font-khand uppercase bg-clip-text bg-text-black leading-none text-5xl xs:text-7xl sm:text-8xl md:text-11xl xl:text-12xl text-balance es:pt-2"><?= $content['about2_title'] ?></h2>
            <p class="text-secondary-200 lg:text-xl text-balance"><?= $content['about2_text'] ?></p>
          </div>
          <div class="relative lg:w-1/2 lg:pr-12">
            <img src="/public/images/services/solutions/<?= $content['about2_images']['big'] ?>" <?= image_dimensions('/public/images/services/solutions/' . $content['about2_images']['big']) ?> alt="" class="rounded-xl md:rounded-2xl mx-auto max-h-[45vh] h-full lg:max-h-none lg:h-auto opacity-0 group-[&.swiper-slide-fully-visible]:opacity-100 translate-y-12 group-[&.swiper-slide-fully-visible]:translate-y-0 transition-op-trans duration-500 delay-200" loading="lazy">
            <img src="/public/images/services/solutions/<?= $content['about2_images']['mid'] ?>" <?= image_dimensions('/public/images/services/solutions/' . $content['about2_images']['mid']) ?> alt="" class="rounded-xl md:rounded-2xl w-1/2 sm:w-2/3 lg:w-auto absolute -top-4 -right-6 sm:-right-16 lg:-top-8 lg:-right-2 xl:-right-8 shadow-lg lg:shadow-xl xl:shadow-serv opacity-0 group-[&.swiper-slide-fully-visible]:opacity-100 scale-90 group-[&.swiper-slide-fully-visible]:scale-100 transition-op-trans duration-500 delay-300" loading="lazy">
            <img src="/public/images/services/solutions/<?= $content['about2_images']['small'] ?>" <?= image_dimensions('/public/images/services/solutions/' . $content['about2_images']['small']) ?> alt="" class="rounded-xl md:rounded-2xl w-2/5 sm:w-1/2 lg:w-auto absolute bottom-8 -left-6 sm:bottom-4 sm:-left-16 lg:bottom-8 lg:-left-4 xl:left-0 shadow-lg lg:shadow-xl xl:shadow-serv opacity-0 group-[&.swiper-slide-fully-visible]:opacity-100 scale-90 group-[&.swiper-slide-fully-visible]:scale-100 transition-op-trans duration-500 delay-400" loading="lazy">
          </div>
        </div>
      </section>

      <!-- Benefits section -->
      <section data-service-slide class="slide-section swiper-slide group min-h-dvh lg:h-screen w-full">
        <div class="block-content py-16 lg:py-24 h-full flex-center gap-7 lg:gap-4 flex-col">
          <h2 class="font-khand uppercase bg-clip-text bg-text-black leading-none text-5xl xs:text-7xl sm:text-8xl md:text-11xl xl:text-12xl es:pt-2"><?= $trans('common_titles.benefits') ?></h2>
          <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 lg:gap-8 xl:gap-12 w-full">
            <?php foreach($content['benefits'] as $k => $benefit): ?>
              <li class="flex items-start gap-2 sm:flex-col opacity-0 group-[&.swiper-slide-fully-visible]:opacity-100 translate-y-12 group-[&.swiper-slide-fully-visible]:translate-y-0 transition-op-trans duration-300"
              style="transition-delay: calc(200ms + (100ms * <?= $k ?>));">
                <div class="p-2 rounded-lg bg-brand-100 text-secondary-100 mb-0 lg:mb-4 flex-center shadow-md lg:shadow-xl">
                  <svg class="size-6 lg:size-10"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#<?= $benefit['image'] ?>"/></svg>
                </div>
                <div>
                  <h3 class="font-bold sm:text-lg lg:text-xl w-full"><?= $benefit['title'] ?></h3>
                  <p class="text-xs sm:text-base text-balance"><?= $benefit['text'] ?></p>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </section>

      <!-- Process section -->
      <section data-service-slide class="slide-section swiper-slide min-h-dvh lg:h-screen w-full">
        <div class="block-content py-16 lg:py-24 h-full flex-center gap-4 lg:gap-12 flex-col lg:flex-row">
          <div class="lg:w-1/2">
            <h2 class="font-khand uppercase text-center lg:text-left bg-clip-text bg-text-black leading-none text-5xl xs:text-7xl sm:text-8xl md:text-11xl xl:text-12xl es:pt-2"><?= $content['process_title'] ?></h2>
            <div id="my-swiper-pagination" role="group" aria-label="Process steps" class="flex items-center justify-center lg:justify-start gap-2 lg:gap-4 mt-2 lg:mt-6"></div>
          </div>
          <div class="w-full lg:w-1/2 lg:pr-40">
            <div class="block w-9/10 md:w-full max-w-xs md:max-w-lg lg:max-w-none mx-auto">
              <div data-process-slider class="native-process-scroller">
                <div class="native-process-track">
                  <?php foreach($content['processes'] as $item): ?>
                    <article data-process-slide class="swiper-slide slide-ff transition-opacity duration-300">
                      <div class="flex-center flex-col text-center lg:text-left h-full bg-secondary-200 text-white rounded-xl">
                        <img src="/public/images/services/solutions/<?= $item['image'] ?>" <?= image_dimensions('/public/images/services/solutions/' . $item['image']) ?> alt="<?= $item['title'] ?>" class="rounded-xl w-full pointer-events-none" loading="lazy">
                        <div class="p-4 md:p-7 lg:p-12 grow">
                          <h3 class="font-title text-lg md:text-2xl lg:text-3xl xl:text-5xl leading-tight font-bold mb-2 md:mb-0"><?= $item['title'] ?></h3>
                          <p class="text-sm md:text-base"><?= $item['text'] ?></p>
                        </div>
                      </div>
                    </article>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- FAQ section -->
      <section data-service-slide class="slide-section swiper-slide min-h-dvh lg:h-screen w-full">
        <div class="block-content py-16 lg:py-24 w-full h-full flex-center gap-7 lg:gap-4 flex-col">
          <h2 class="font-khand uppercase bg-clip-text bg-text-black leading-none text-center text-5xl xs:text-7xl sm:text-8xl md:text-11xl xl:text-12xl es:pt-2"><?= $trans('common_titles.faqs') ?></h2>
          <div class="block w-full md:w-9/10 mx-auto mt-6 lg:mt-10">
            <div id="faq-slider" class="relative text-center perspective-distant transition-[height]">
              <?php foreach( $content['faq'] as $k => $item): ?>
              <article class="slide-depth absolute top-0 left-1/2 w-full h-fit bg-secondary-200 text-white p-4 lg:p-10 rounded-2xl transition-op-trans duration-300" data-index="<?= $k ?>">
                <h2 class="font-khand uppercase leading-tight text-pretty text-2xl md:text-5xl lg:text-7xl mb-2"><?= $item['question'] ?></h2>
                <p class="lg:text-lg xl:text-xl text-balance"><?= $item['answer'] ?></p>
              </article>
              <?php endforeach; ?>
            </div>

            <div class="mt-4 lg:mt-12 flex-center gap-2">
              <button type="button" aria-label="<?= htmlspecialchars($trans('common.previous')) ?>" class="lg:hidden flex-center bg-surface-100 text-secondary-50 hover:bg-brand-100 active:bg-brand-100 hover:text-white active:text-white p-1 rounded-full cursor-pointer" id="prevBtn">
                <svg class="size-7"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#chevron-left"/></svg>
              </button>
              <div class="pagination flex gap-1 p-0.5 rounded-full w-fit bg-white" id="pagination-depth"></div>
              <button type="button" aria-label="<?= htmlspecialchars($trans('common.next')) ?>" class="lg:hidden flex-center bg-surface-100 text-secondary-50 hover:bg-brand-100 active:bg-brand-100 hover:text-white active:text-white p-1 rounded-full cursor-pointer" id="nextBtn">
                <svg class="size-7"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#chevron-right"/></svg>
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- Sales section -->
      <section data-service-slide class="slide-section swiper-slide group min-h-dvh lg:h-screen w-full">
        <div class="block-content py-16 lg:py-40 h-full flex-center gap-4 flex-col lg:flex-row">
          <div class="lg:w-1/2 text-center lg:text-left">
            <h2 class="font-khand uppercase bg-clip-text bg-text-black leading-none text-5xl xs:text-7xl sm:text-8xl md:text-11xl xl:text-12xl text-balance es:pt-2"><?= $content['sales']['title'] ?></h2>
            <p class="text-secondary-200 lg:text-xl text-balance"><?= $content['sales']['text'] ?></p>
            <div class="relative w-fit mt-4 mx-auto lg:mt-8 lg:mx-0">
              <a href="https://wa.me/<?= $constants['contact_info']['wame'] ?>?text=<?= $trans('common.wame_message') ?>%20<?= $encodedTitle ?>" target="_blank" rel="noopener noreferrer" class="button leading-none relative gradient gap-2 rounded-lg w-fit px-7 md:text-xl font-semibold hover:text-white z-1">
                <svg class="relative size-7 md:size-8"><use href="<?= asset_url($iconSprite ?? '/public/assets/icons.svg') ?>#whatsapp" /></svg>
                <span class="relative pt-0.5"><?= $trans('common.sales') ?></span>
              </a>
              <div class="button-glow"></div>
            </div>
          </div>
          <div class="relative lg:w-1/2">
            <?= responsive_image('/public/images/services/solutions/' . $content['sales_images']['big'], '', 'rounded-xl md:rounded-2xl lg:min-w-[44vw] relative max-h-[45vh] h-full lg:max-h-none lg:h-auto lg:absolute lg:top-1/2 lg:left-1/5 opacity-0 group-[&.swiper-slide-fully-visible]:opacity-100 translate-y-12 group-[&.swiper-slide-fully-visible]:translate-y-0 lg:-translate-y-[calc(50%_-_--spacing(12))] lg:group-[&.swiper-slide-fully-visible]:-translate-y-1/2 transition-op-trans duration-500 delay-200', '(min-width: 1088px) 44vw, 90vw', ['loading' => 'lazy']) ?>
            <img src="/public/images/services/solutions/<?= $content['sales_images']['small'] ?>" <?= image_dimensions('/public/images/services/solutions/' . $content['sales_images']['small']) ?> alt="" class="absolute lg:relative rounded-xl md:rounded-2xl w-1/3 bottom-6 lg:bottom-0 -left-6 sm:-left-16 lg:left-0 lg:w-52 xl:w-auto shadow-lg lg:shadow-xl xl:shadow-serv opacity-0 group-[&.swiper-slide-fully-visible]:opacity-100 translate-y-12 group-[&.swiper-slide-fully-visible]:translate-y-0 lg:translate-y-22 lg:group-[&.swiper-slide-fully-visible]:translate-y-10 xl:translate-y-20 xl:group-[&.swiper-slide-fully-visible]:translate-y-8 transition-op-trans duration-500 delay-300" loading="lazy">
          </div>
        </div>
      </section>
    </div>
  </div>

</div>

<?php if (($includeExitIntentPopup ?? true) === true):
  require __DIR__ . '/../components/exitPopup.php';
endif; ?>

<?php include __DIR__ . '/../components/footer-traking.php'; ?>
</main>
</body>
</html>
