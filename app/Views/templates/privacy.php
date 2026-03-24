<?php

use App\Models\Language;

$pageTitle = $trans('footer.privacy');
$allTranslations = Language::getAll();
$privacy = $allTranslations['privacy'][$currentLang] ?? $allTranslations['privacy']['en'] ?? [];

$escape = static fn(string $text): string => htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

require __DIR__ . '/../layouts/header.php';
?>

<div class="block-content py-14 lg:py-32 2xl:max-w-screen-lg">
  <h1 class="text-2xl sm:text-3xl lg:text-5xl font-title text-secondary-100 text-center mb-8 lg:mb-10"><?= $escape($privacy['page'] ?? ''); ?></h1>

  <?php if (!empty($privacy['updated_at'])): ?>
    <p class="mb-6 lg:mb-8 font-semibold"><?= $escape($privacy['updated_at']); ?></p>
  <?php endif; ?>

  <?php foreach (($privacy['intro'] ?? []) as $paragraph): ?>
    <p class="mb-4 last:mb-0"><?= $escape($paragraph); ?></p>
  <?php endforeach; ?>

  <?php foreach (($privacy['sections'] ?? []) as $section): ?>
    <section class="mb-8 lg:mb-16 last:mb-0">
      <h2 class="text-xl sm:text-2xl lg:text-3xl font-title text-secondary-100 mb-4 lg:mb-6"><?= $escape($section['title'] ?? ''); ?></h2>

      <?php foreach (($section['blocks'] ?? []) as $block): ?>
        <?php if (($block['type'] ?? '') === 'paragraph'): ?>
          <p class="mb-4 last:mb-0"><?= $escape($block['text'] ?? ''); ?></p>
        <?php elseif (($block['type'] ?? '') === 'subheading'): ?>
          <h3 class="text-base sm:text-lg font-title text-secondary-100 mt-6 mb-3"><?= $escape($block['text'] ?? ''); ?></h3>
        <?php elseif (($block['type'] ?? '') === 'list'): ?>
          <ul class="list-disc pl-6 mb-4 space-y-3">
            <?php foreach (($block['items'] ?? []) as $item): ?>
              <li><?= $escape($item); ?></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      <?php endforeach; ?>
    </section>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
