<div class="language-switcher relative group">
  <button type="button" class="lang-trigger flex items-center pl-4 pr-3.5 py-4 lg:py-5 gap-1">
    <?= $config['languages']['names'][$currentLang] ?>
    <svg class="size-5 text-brand-100 lg:group-hover:rotate-180 [&.open]:rotate-180 transition-transform"><use href="#chevron-down"/></svg>
  </button>
  <ul class="lang-options absolute top-full left-0 min-w-max w-full p-2 rounded-lg bg-white border border-surface-300 opacity-0 pointer-events-none lg:group-hover:opacity-100 [&.open]:opacity-100 lg:group-hover:pointer-events-auto [&.open]:pointer-events-auto transition-opacity">
    <?php
      $availableLanguages = $config['languages']['available'];
      $defaultLanguage = $config['languages']['default'];
      $currentPath = $_SERVER['REQUEST_URI'];

      foreach ($availableLanguages as $lang):
        $langUrl = getLanguageSwitchUrl($currentPath, $currentLang, $lang, $defaultLanguage);
        if ($lang !== $currentLang):
    ?>
      <li>
        <a class="block text-center p-2 rounded-sm active:bg-surface-100 lg:hover:bg-surface-100 active:text-brand-100 lg:hover:text-brand-100 transition-colors" href="<?= $langUrl ?>" title="<?= $config['languages']['names'][$lang] ?>">
          <?= $config['languages']['names'][$lang] ?>
        </a>
      </li>
    <?php endif; endforeach; ?>
  </ul>
</div>
