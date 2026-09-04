<?php
$pageTitle = $title ?? $trans('blog.title');
require __DIR__ . '/../../layouts/header.php';
?>

<!-- Blog Index Page -->
<section class="relative bg-surface-100">
  <div class="block-content py-24 lg:py-40">

    <!-- Page Header -->
    <div class="text-center mb-12 lg:mb-16">
      <h1 class="font-title leading-tight uppercase bg-clip-text bg-text-black text-4xl md:text-7xl lg:text-11xl">
        <?= htmlspecialchars($title ?? $trans('blog.title')) ?>
      </h1>
      <?php if (isset($metaDescription) && $metaDescription): ?>
        <p class="md:text-xl text-black mx-auto">
          <?= htmlspecialchars($metaDescription) ?>
        </p>
      <?php endif; ?>
    </div>

    <!-- Error Message -->
    <?php if (isset($error) && $error): ?>
      <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-lg mb-8 text-center">
        <p><?= htmlspecialchars($error) ?></p>
      </div>
    <?php endif; ?>

    <div class="flex flex-col lg:flex-row gap-8">

      <!-- Main Content - Posts Grid -->
      <div class="flex-1">
        <?php if (!empty($posts)): ?>
          <div class="grid grid-cols-1 gap-6 lg:gap-8">
            <?php foreach ($posts as $k => $post): ?>
              <article class="bg-white rounded-2xl p-2 overflow-hidden grid grid-cols-1 lg:grid-cols-2 gap-4">

                <!-- Featured Image -->
                <?php
                  $backupImage = $k % 3;
                  $featuredPath = $post['featuredImage']['url'] ?? "/public/images/background/blog-cover-{$backupImage}.webp";
                  $featuredAlt = $post['featuredImage']['alt'] ?? $post['title'];
                ?>
                <a href="<?= htmlspecialchars($post['url']) ?>" class="block aspect-video lg:aspect-square rounded-lg overflow-hidden">
                  <?= responsive_image($featuredPath, $featuredAlt, 'w-full h-full object-cover hover:scale-105 transition-transform duration-300', '(min-width: 1088px) 50vw, 100vw', ['loading' => 'lazy']) ?>
                </a>

                <div class="flex flex-col justify-between p-4">
                  <!-- Title -->
                  <a href="<?= htmlspecialchars($post['url']) ?>" class="hover:text-brand-100 transition-colors">
                    <h2 class="text-xl lg:text-3xl 2xl:text-5xl leading-tight font-bold mb-3 line-clamp-3">
                      <?= htmlspecialchars($post['title']) ?>
                    </h2>
                  </a>

                  <!-- Categories -->
                  <?php if (!empty($post['categories'])): ?>
                    <div class="flex flex-wrap gap-2 mb-3">
                      <?php foreach (array_slice($post['categories'], 0, 2) as $category): ?>
                        <span class="text-xs font-semibold px-3 py-1 bg-secondary-50 text-white rounded-full">
                          <?= htmlspecialchars($category['name']) ?>
                        </span>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>

                  <!-- Excerpt -->
                  <?php if ($post['excerpt']): ?>
                    <p class="mb-4 mt-auto line-clamp-3">
                      <?= htmlspecialchars($post['excerpt']) ?>
                    </p>
                  <?php endif; ?>

                  <!-- Meta Info -->
                  <div class="flex items-center justify-between text-sm pt-4 border-t border-surface-300">
                    <time datetime="<?= htmlspecialchars($post['dateRaw']) ?>">
                      <?= htmlspecialchars($post['date']) ?>
                    </time>
                  </div>
                </div>
              </article>
            <?php endforeach; ?>
          </div>

          <!-- Pagination Component -->
          <?php require __DIR__ . '/../../components/pagination.php'; ?>

        <?php else: ?>
          <!-- No Posts -->
          <div class="text-center py-12">
            <p class="text-xl text-gray-600"><?= $trans('blog.no_posts') ?></p>
          </div>
        <?php endif; ?>
      </div>

      <!-- Sidebar -->
      <aside class="w-full lg:w-80 shrink-0 relative">

        <!-- Categories -->
        <?php if (!empty($categories)): ?>
          <div class="bg-secondary-100 text-white rounded-xl shadow-lg p-6 mb-6 lg:sticky lg:top-28">
            <h3 class="text-xl font-bold mb-4"><?= $trans('blog.categories') ?></h3>
            <ul class="space-y-2">
              <li>
                <a
                  href="<?= route('blog', $currentLang) ?>"
                  class="block px-4 py-2 rounded-lg transition-colors <?= !$selectedCategory ? 'text-secondary-100 bg-brand-100 hover:bg-brand-200' : 'hover:bg-secondary-50' ?>"
                >
                  <?= $trans('blog.all_posts') ?>
                </a>
              </li>
              <?php
                foreach ($categories as $category):
                  if ($category['count'] <= 0) continue;
              ?>
                <li>
                  <a
                    href="?category=<?= urlencode($category['slug']) ?>"
                    class="flex items-center justify-between px-4 py-2 rounded-lg transition-colors <?= $selectedCategory === $category['slug'] ? 'bg-brand-100 hover:bg-brand-200' : 'hover:bg-secondary-50' ?>"
                  >
                    <span><?= htmlspecialchars($category['name']) ?></span>
                    <span class="text-sm">(<?= $category['count'] ?>)</span>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

      </aside>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
