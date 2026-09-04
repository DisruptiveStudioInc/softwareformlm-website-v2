<?php
$pageTitle = $title ?? $post['title'] ?? $trans('blog.post');
$backupImage = rand(0, 2);
require __DIR__ . '/../../layouts/header.php';
?>

<!-- Single Post Page -->
<article class="relative bg-surface-100">

  <!-- Featured Image Hero -->
  <header class="relative w-full h-96 lg:h-[600px] overflow-hidden bg-secondary-50">
    <?php
      $featuredPath = $post['featuredImage']['url'] ?? "/public/images/background/blog-cover-{$backupImage}.webp";
      $featuredAlt = $post['featuredImage']['alt'] ?? $post['title'];
    ?>
    <?= responsive_image($featuredPath, $featuredAlt, 'w-full h-full object-cover opacity-90', '100vw', ['loading' => 'eager', 'fetchpriority' => 'high']) ?>
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 from-15% to-transparent"></div>

    <!-- Title Overlay -->
    <div class="absolute bottom-0 left-0 right-0 text-white">
      <div class="block-content max-w-screen-lg pb-8 lg:pb-20">
        <h1 class="font-title text-3xl md:text-5xl lg:text-6xl 2xl:text-9xl bg-clip-text bg-text-white leading-tight text-pretty text-center uppercase es:pt-2 lg:es:pt-4">
          <?= htmlspecialchars($post['title']) ?>
        </h1>
      </div>
    </div>
  </header>

  <!-- Article Content -->
  <div class="block-content max-w-screen-lg py-16">

    <!-- Post Meta -->
    <div class="flex flex-wrap items-center justify-between gap-4 pb-6 mb-8 border-b border-grey-100">
      <div class="flex items-center gap-4">
        <div>
          <p class="text-sm text-grey-100">
            <time datetime="<?= htmlspecialchars($post['dateRaw']) ?>">
              <?= htmlspecialchars($post['date']) ?>
            </time>
            <?php if (isset($readingTime) && $readingTime): ?>
              <span class="mx-2">•</span>
              <span><?= $readingTime ?> <?= $trans('blog.min_read') ?></span>
            <?php endif; ?>
          </p>
        </div>
      </div>

      <!-- Categories & Tags -->
      <div class="flex flex-wrap gap-2">
        <?php foreach ($post['categories'] as $category): ?>
          <a
            href="<?= htmlspecialchars(route('blog', $currentLang) . '?' . http_build_query(['category' => $category['slug']])) ?>"
            class="text-xs font-semibold px-3 py-1 bg-brand-100 text-secondary-100 rounded-full hover:bg-brand-200 transition-colors"
          >
            <?= htmlspecialchars($category['name']) ?>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Post Content -->
    <div class="prose prose-lg max-w-none">
      <?= $post['content'] ?>
    </div>

    <!-- Tags -->
    <?php if (!empty($post['tags'])): ?>
      <div class="flex flex-wrap gap-2 mt-12 pb-8 border-b border-gray-100">
        <span class="font-semibold text-gray-700"><?= $trans('blog.tags') ?>:</span>
        <?php foreach ($post['tags'] as $tag): ?>
          <span class="text-sm px-3 py-1 bg-gray-100 text-gray-100 rounded-full">
            #<?= htmlspecialchars($tag['name']) ?>
          </span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

  </div>

  <!-- Related Posts -->
  <?php if (!empty($relatedPosts)): ?>
    <section class="pb-12 lg:pb-16">
      <div class="block-content">
        <h2 class="text-3xl lg:text-6xl font-title uppercase bg-clip-text bg-text-black mb-8 text-center"><?= $trans('blog.related_posts') ?></h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <?php foreach ($relatedPosts as $k => $related): ?>
            <article class="bg-white rounded-2xl p-2">
              <?php
                $relatedBackupImage = $k % 3;
                $relatedPath = $related['featuredImage']['url'] ?? "/public/images/background/blog-cover-{$relatedBackupImage}.webp";
                $relatedAlt = $related['featuredImage']['alt'] ?? $related['title'];
              ?>
              <a href="<?= htmlspecialchars($related['url']) ?>" class="block aspect-video rounded-lg overflow-hidden">
                <?= responsive_image($relatedPath, $relatedAlt, 'w-full h-full object-cover hover:scale-105 transition-transform duration-300', '(min-width: 768px) 33vw, 100vw', ['loading' => 'lazy']) ?>
              </a>
              <h3 class="text-lg font-bold line-clamp-2 p-2 mt-2">
                <a href="<?= htmlspecialchars($related['url']) ?>" class="hover:text-brand-100 transition-colors">
                  <?= htmlspecialchars($related['title']) ?>
                </a>
              </h3>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

</article>

<!-- Structured Data for SEO -->
<?php if (isset($structuredData)): ?>
<script type="application/ld+json">
<?= $structuredData ?>
</script>
<?php endif; ?>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
