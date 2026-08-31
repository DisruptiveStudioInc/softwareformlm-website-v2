<?php
/**
 * Numbered blog pagination.
 *
 * @param array{hasNext: bool, hasPrev: bool, currentPage: int, totalPages: int, pages: list<int|string>} $pagination
 * @param string|null $selectedCategory
 */

if (!isset($pagination) || !$pagination || ($pagination['totalPages'] ?? 0) <= 1) {
  return;
}

$href = static function (int $page) use ($selectedCategory): string {
  $query = [];
  if (isset($selectedCategory) && $selectedCategory !== '') {
    $query['category'] = $selectedCategory;
  }
  if ($page > 1) {
    $query['page'] = $page;
  }
  return $query === [] ? '?' : '?' . http_build_query($query);
};

$currentPage = (int) $pagination['currentPage'];
$totalPages = (int) $pagination['totalPages'];
?>

<nav class="mt-12 flex flex-wrap justify-center items-center gap-2" aria-label="<?= htmlspecialchars($trans('blog.pagination')) ?>">
  <?php if ($pagination['hasPrev']): ?>
    <a href="<?= htmlspecialchars($href($currentPage - 1)) ?>" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-lg hover:bg-brand-100 transition-colors" aria-label="<?= htmlspecialchars($trans('blog.previous')) ?>">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
    </a>
  <?php else: ?>
    <span class="inline-flex items-center justify-center w-10 h-10 bg-surface-200 rounded-lg text-grey-100/70 cursor-not-allowed" aria-disabled="true">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
    </span>
  <?php endif; ?>

  <?php foreach ($pagination['pages'] as $page): ?>
    <?php if (!is_int($page)): ?>
      <span class="inline-flex items-center justify-center h-10 px-1" aria-hidden="true"><?= htmlspecialchars($page) ?></span>
    <?php elseif ($page === $currentPage): ?>
      <span class="inline-flex items-center justify-center w-10 h-10 bg-brand-200 text-white rounded-lg font-semibold" aria-current="page"><?= $page ?></span>
    <?php else: ?>
      <a href="<?= htmlspecialchars($href($page)) ?>" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-lg hover:bg-brand-100 transition-colors font-medium" aria-label="<?= htmlspecialchars($trans('blog.page')) ?> <?= $page ?>"><?= $page ?></a>
    <?php endif; ?>
  <?php endforeach; ?>

  <?php if ($pagination['hasNext']): ?>
    <a href="<?= htmlspecialchars($href($currentPage + 1)) ?>" class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-lg hover:bg-brand-100 transition-colors" aria-label="<?= htmlspecialchars($trans('blog.next')) ?>">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
    </a>
  <?php else: ?>
    <span class="inline-flex items-center justify-center w-10 h-10 bg-surface-200 rounded-lg text-grey-100/70 cursor-not-allowed" aria-disabled="true">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
    </span>
  <?php endif; ?>
</nav>
