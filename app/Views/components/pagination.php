<?php
/**
 * Pagination Component with Page Numbers
 *
 * A reusable cursor-based pagination component with numbered pages
 *
 * @param array $pagination Pagination data with pages, cursors, currentPage, etc.
 * @param string|null $selectedCategory Optional category filter
 * @param array $additionalParams Additional query parameters to preserve
 */

if (!isset($pagination) || !$pagination || ($pagination['totalPages'] ?? 0) <= 1) {
  return; // Don't render if no pagination needed
}

// Build query parameters
$queryParams = [];
if (isset($selectedCategory) && $selectedCategory) {
  $queryParams[] = 'category=' . urlencode($selectedCategory);
}
if (isset($additionalParams) && is_array($additionalParams)) {
  foreach ($additionalParams as $key => $value) {
    $queryParams[] = urlencode($key) . '=' . urlencode($value);
  }
}
$queryString = !empty($queryParams) ? implode('&', $queryParams) : '';
$separator = !empty($queryString) ? '&' : '';

$currentPage = $pagination['currentPage'];
$totalPages = $pagination['totalPages'];
$pageCursors = $pagination['pageCursors'];
?>

<nav class="mt-12 flex flex-wrap justify-center items-center gap-2" aria-label="<?= $trans('blog.pagination') ?>">

  <!-- Previous Button -->
  <?php if ($pagination['hasPrev']): ?>
    <a
      href="?<?= $queryString ?>"
      class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-lg hover:bg-brand-100 transition-colors"
      aria-label="<?= $trans('blog.previous') ?>"
      title="<?= $trans('blog.previous') ?>"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </a>
  <?php else: ?>
    <span class="inline-flex items-center justify-center w-10 h-10 bg-surface-200 rounded-lg text-grey-100/70 cursor-not-allowed">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
    </span>
  <?php endif; ?>

  <!-- Page Numbers -->
  <?php foreach ($pagination['pages'] as $page): ?>
    <?php if ($page['type'] === 'ellipsis'): ?>
      <span class="inline-flex items-center justify-center h-10 text-white">
        <?= $page['value'] ?>
      </span>
    <?php else: ?>
      <?php
      $pageNum = $page['value'];
      $isActive = $pageNum === $currentPage;
      $cursor = $pageCursors[$pageNum] ?? null;
      $href = $cursor ? "?{$queryString}{$separator}after=" . urlencode($cursor) : "?{$queryString}";
      ?>

      <?php if ($isActive): ?>
        <span class="inline-flex items-center justify-center w-10 h-10 bg-brand-200 text-white rounded-lg font-semibold">
          <?= $pageNum ?>
        </span>
      <?php else: ?>
        <a
          href="<?= $href ?>"
          class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-lg hover:bg-brand-100 transition-colors font-medium"
          aria-label="<?= $trans('blog.page') ?> <?= $pageNum ?>"
        >
          <?= $pageNum ?>
        </a>
      <?php endif; ?>
    <?php endif; ?>
  <?php endforeach; ?>

  <!-- Next Button -->
  <?php if ($pagination['hasNext']): ?>
    <a
      href="?<?= $queryString ?><?= $separator ?>after=<?= urlencode($pagination['endCursor']) ?>"
      class="inline-flex items-center justify-center w-10 h-10 bg-white rounded-lg hover:bg-brand-100 transition-colors"
      aria-label="<?= $trans('blog.next') ?>"
      title="<?= $trans('blog.next') ?>"
    >
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </a>
  <?php else: ?>
    <span class="inline-flex items-center justify-center w-10 h-10 bg-surface-200 rounded-lg text-grey-100/70 cursor-not-allowed">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
    </span>
  <?php endif; ?>
</nav>
