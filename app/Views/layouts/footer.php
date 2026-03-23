</main>

<footer class="bg-surface-300 <?= (isset($hasSnapScroll) && $hasSnapScroll) ? 'snap-start' : '' ?>">
  <div class="block-content flex flex-col lg:flex-row items-center justify-between gap-6 py-12 lg:py-16">
    <div class="flex flex-col items-center lg:items-start">
      <svg width="250" height="60" class="h-12 w-auto"><use href="#disruptive-studio-logo"/></svg>
      <ul class="flex flex-wrap gap-6 mt-4">
        <?php foreach($constants['social_media'] as $key => $url): ?>
          <li>
            <a href="<?= $url ?>" target="_blank" rel="noopener noreferrer" class="block text-secondary-100 hover:text-brand-200 active:text-brand-200 p-2 transition-colors">
              <svg class="size-6"><use href="#<?= $key ?>"/></svg>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="flex flex-col md:flex-row justify-center lg:justify-end gap-8 text-center lg:text-left">
      <div>
        <h3 class="font-title text-lg mb-4"><?= $trans('footer.legal') ?></h3>
        <ul class="space-y-2">
          <li>
            <a href="<?= route('privacy', $currentLang) ?>"><?= $trans('footer.privacy') ?></a>
          </li>
          <li>
            <a href="<?= route('terms', $currentLang) ?>"><?= $trans('footer.terms') ?></a>
          </li>
        </ul>
      </div>
      <div>
        <h3 class="font-title text-lg mb-4"><?= $trans('footer.about') ?></h3>
        <ul class="space-y-2">
          <li><?= $constants['contact_info']['email'] ?></li>
          <li><?= $constants['contact_info']['phone'] ?></li>
          <li><?= $constants['contact_info']['address'] ?></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="p-7 border-t border-grey-100/30 text-center">
    <ul class="flex justify-center gap-4 sm:gap-6 mb-4">
      <li class=""><svg width="80" height="80" class="h-5 sm:h-6 w-auto aspect-square"><use href="#americanexpress"/></svg></li>
      <li class=""><svg width="289" height="80" class="h-5 sm:h-6 w-auto aspect-[289/80]"><use href="#dinnersclub"/></svg></li>
      <li class=""><svg width="103" height="80" class="h-5 sm:h-6 w-auto aspect-[103/80]"><use href="#mastercard"/></svg></li>
      <li class=""><svg width="247" height="80" class="h-5 sm:h-6 w-auto aspect-[247/80]"><use href="#visa"/></svg></li>
    </ul>
    <small>&copy; <?= date("Y") ?> Software for MLM. All rights reserved</small>
  </div>
  <?php require_once __DIR__ .'/../components/svgSprites.php'; ?>
</footer>
</body>
</html>
