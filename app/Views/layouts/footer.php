</main>

<footer id="main-footer" class="bg-secondary-200 <?= (isset($hasSnapScroll) && $hasSnapScroll) ? 'snap-start' : '' ?>">
  <div class="block-content flex flex-col items-center gap-6 lg:gap-12 py-12 lg:py-16">
    <div class="flex flex-col items-center lg:items-start">
      <svg width="250" height="60" class="h-12 w-auto"><use href="#disruptive-studio-logo"/></svg>
      <ul class="flex flex-wrap items-center gap-6 mt-4 lg:mt-2 mx-auto">
        <?php foreach($constants['social_media'] as $key => $url): ?>
          <li>
            <a href="<?= $url ?>" target="_blank" rel="noopener noreferrer" class="block text-white hover:text-brand-200 active:text-brand-200 p-2 transition-colors">
              <svg class="size-6"><use href="#<?= $key ?>"/></svg>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 justify-center lg:justify-end gap-8 text-center lg:text-left text-white">
      <?php foreach(getFooterMenu($currentLang, $trans) as $menu): ?>
        <div>
          <h3 class="font-title text-lg mb-4"><?= $menu['label'] ?></h3>
          <ul class="space-y-2">
            <?php foreach($menu['items'] as $item): ?>
            <li>
              <a href="<?= $item['url'] ?>" class="text-surface-50 hover:text-brand-100"><?= $item['label'] ?></a>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endforeach; ?>
      <div>
        <h3 class="font-title text-lg mb-4"><?= $trans('footer.about') ?></h3>
        <ul class="space-y-2 text-surface-50">
          <li><?= $constants['contact_info']['email'] ?></li>
          <li><?= $constants['contact_info']['phone'] ?></li>
          <li><?= $constants['contact_info']['address'] ?></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="p-7 border-t border-grey-100 text-center text-surface-100">
    <ul class="flex justify-center gap-4 sm:gap-6 mb-4">
      <li class=""><svg width="180" height="120" class="h-5 sm:h-7 lg:h-9 w-auto aspect-[3/2]"><use href="#card-americanexpress"/></svg></li>
      <li class=""><svg width="180" height="120" class="h-5 sm:h-7 lg:h-9 w-auto aspect-[3/2]"><use href="#card-dinnersclub"/></svg></li>
      <li class=""><svg width="180" height="120" class="h-5 sm:h-7 lg:h-9 w-auto aspect-[3/2]"><use href="#card-mastercard"/></svg></li>
      <li class=""><svg width="180" height="120" class="h-5 sm:h-7 lg:h-9 w-auto aspect-[3/2]"><use href="#card-visa"/></svg></li>
      <li class=""><svg width="180" height="120" class="h-5 sm:h-7 lg:h-9 w-auto aspect-[3/2]"><use href="#card-usdt"/></svg></li>
    </ul>
    <small class="block mb-4"><?= $trans('footer.legal_small') ?></small>
    <small class="block mb-4"><a href="https://www.comparasoftware.com/software-for-mlm" target="_blank" rel="noopener noreferrer"><?= $trans('footer.affiliate_brand') ?></a> <?= $trans('footer.affiliate_text') ?> <a href="https://www.comparasoftware.com/mlm" target="_blank" rel="noopener noreferrer"><?= $trans('footer.affiliate_name') ?></a></small>
    <small>&copy; <?= date("Y") ?> Software for MLM. All rights reserved</small>
  </div>
  <a
    href="https://wa.me/<?= $constants['contact_info']['wame'] ?>?text=<?= $trans('common.wame_message') ?>" target="_blank" rel="noopener noreferrer"
    class="fixed bottom-4 right-4 flex-center p-2 rounded-full bg-green-400 hover:bg-green-700 active:bg-green-700 transition-colors z-1"
  >
    <span class="h-4/5 w-4/5 rounded-full bg-green-400/70 backdrop-blur-3xl absolute top-1/10 left-1/10 animate-ping -z-1 pointer-events-none"></span>
    <svg class="size-9 text-white"><use href="#whatsapp"/></svg>
  </a>
  <?php require_once __DIR__ .'/../components/svgSprites.php'; ?>
</footer>
<?php include __DIR__ . '/../components/footer-traking.php'; ?>
</body>
</html>
