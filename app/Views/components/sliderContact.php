<div class="w-full lg:w-1/2 h-112 lg:h-auto">
  <div class="relative rounded-lg lg:rounded-xl h-full bg-grey-100/10 overflow-hidden">
    <div class="absolute top-4 left-4 flex items-center gap-2 text-white font-bold text-xl leading-none z-2">
      <svg class="size-7 rounded-full"><use href="#flag-mx"/></svg>
      <span class="pt-1.5">MEX</span>
    </div>

    <div id="offices-swiper" class="swiper !h-full w-full z-0">
      <div class="swiper-wrapper !h-full">
        <?php foreach($content['offices'] as $slide): ?>
          <div class="swiper-slide !h-full relative block">
            <img src="/public/images/office/<?= $slide['image']?>" alt="<?= $slide['alt']?>" class="absolute top-0 left-0 w-full h-full object-cover">
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div id="offices-thumbs-swiper" class="swiper w-[calc(100%_-_--spacing(8))] z-1 !absolute bottom-4 left-4 right-4">
      <div class="swiper-wrapper !h-full">
        <?php foreach($content['offices'] as $slide): ?>
          <div class="swiper-slide group !h-full relative block">
            <img src="/public/images/office/<?= $slide['image']?>" alt="<?= $slide['alt']?> thumbnail" class="w-full h-28 md:h-32 object-cover border-surface-100 border rounded-lg group-[&.swiper-slide-thumb-active]:border-brand-100">
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>