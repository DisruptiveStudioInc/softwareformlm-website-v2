<?php
/**
 * Language Switcher Component
 *
 * Displays available language options. When viewing a blog post with translations,
 * it shows only available languages and links to the translated versions.
 *
 * @param array|null $postTranslations Post translations (if on a blog post page)
 */

// Determine if we're on a post with translations
$hasPostTranslations = isset($postTranslations) && !empty($postTranslations);

if ($hasPostTranslations) {
  // Use post translations - show only available languages
  $languageOptions = [];
  foreach ($postTranslations as $translation) {
    $languageOptions[$translation['code']] = [
      'url' => $translation['url'],
      'name' => substr($translation['name'], 0, 3),
      'isCurrent' => $translation['code'] === $currentLang,
    ];
  }
} else {
  // Use default language switching for non-post pages
  $availableLanguages = $config['languages']['available'];
  $defaultLanguage = $config['languages']['default'];
  $currentPath = $_SERVER['REQUEST_URI'];

  $languageOptions = [];
  foreach ($availableLanguages as $lang) {
    $languageOptions[$lang] = [
      'url' => getLanguageSwitchUrl($currentPath, $currentLang, $lang, $defaultLanguage),
      'name' => $config['languages']['names'][$lang],
      'isCurrent' => $lang === $currentLang,
    ];
  }
}

// Only show switcher if there's more than one language option
// if (count($languageOptions) <= 1) {
//   return;
// }
?>

<div class="language-switcher relative group">
  <button type="button" class="lang-trigger flex items-center pl-3 lg:es:pl-1.5 py-4 lg:py-5 gap-1">
    <svg class="size-7 text-secondary-50/80 group-hover:text-brand-100"><use href="#world"/></svg>
    <svg class="size-5 text-brand-100 lg:group-hover:rotate-180 [&.open]:rotate-180 transition-transform"><use href="#chevron-down"/></svg>
  </button>
  <ul class="lang-options absolute top-full left-0 min-w-max w-full space-y-1 p-2 rounded-lg bg-white border border-surface-300 opacity-0 pointer-events-none lg:group-hover:opacity-100 [&.open]:opacity-100 lg:group-hover:pointer-events-auto [&.open]:pointer-events-auto transition-opacity">
    <?php foreach ($languageOptions as $langCode => $langData): ?>
      <li>
        <?php if ($langData['isCurrent']): ?>
          <span class="block text-center p-2 rounded-sm bg-brand-100 text-white">
            <?= htmlspecialchars($langData['name']) ?>
          </span>
        <?php else: ?>
          <a class="block text-center p-2 rounded-sm active:bg-surface-100 lg:hover:bg-surface-100 active:text-brand-100 lg:hover:text-brand-100 transition-colors" href="<?= htmlspecialchars($langData['url']) ?>" title="<?= htmlspecialchars($langData['name']) ?>">
            <?= htmlspecialchars($langData['name']) ?>
          </a>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ul>
</div>
