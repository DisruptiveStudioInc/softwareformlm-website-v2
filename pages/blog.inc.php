<section class="mw-1280 t-c pt-150 med-pt-80 pb-100 m-center">
  <h1 class="h1-special short"><?= $Menu_04 ?></h1>

  <div class="blog-grid col-2 g-40 med-g-20 mt-40">
    <?php foreach($posts as $post): ?>
      <!-- Blog Card -->
      <article class="blog-card p-20 br-16 c-0 t-l d-flex fd-col g-20">
        <a href="<?= \Includes\Localization::url('blog-post', [$post['slug']]) ?>" class="d-block">
          <img src="<?= $post['cover'] ?>" alt="<?= $post['title'] ?>" class="w-100 br-8" style="aspect-ratio: 16/9; object-fit: cover;">
        </a>
        <div class="">
          <h2 class="h5 m-0"><a href="<?= \Includes\Localization::url('blog-post', [$post['slug']]) ?>" class="font-bold"><?= $post['title'] ?></a></h2>
          <small class="tc-gray d-block"><?= $Blog_published ?> <?= $post['formatted-date'] ?? $post['publish-date'] ?></small>
          <a href="<?= \Includes\Localization::url('blog-post', [$post['slug']]) ?>" class="btn c-acc br-8 mt-20"><?= $Btn_read ?></a>
        </div>
      </article>
    <?php endforeach; ?>
  </div>

  <!-- Pagination -->
  <?php if ($pagination['total'] > 1): ?>
    <div class="pagination mt-50 d-flex fw-wrap jc-center g-10 ai-center">
      <?php
        $current = $pagination['current'];
        $total = (int)$pagination['total'];
        $baseUrl = $pagination['url'];

        // Previous Button
        if ($current > 1) {
          echo '<a href="' . $baseUrl . ($current - 1) . '" class="btn-page c-0 tc-gray">&lt;</a>';
        } else {
          echo '<span class="btn-page disabled">&lt;</span>';
        }

        // Calculate Pages to Show
        $pagesToShow = [1, $total]; // Always first and last

        // Add range around current
        for ($i = $current - 1; $i <= $current + 1; $i++) {
          if ($i > 1 && $i < $total) {
            $pagesToShow[] = $i;
          }
        }

        $pagesToShow = array_unique($pagesToShow);
        sort($pagesToShow);

        $prev = 0;
        foreach ($pagesToShow as $p) {
          // Dots logic
          if ($prev > 0 && $p > $prev + 1) {
            echo '<span class="btn-page dots">...</span>';
          }

          $activeClass = ($p === $current) ? 'c-acc tc-pri' : 'c-0 tc-gray';
          echo '<a href="' . $baseUrl . $p . '" class="btn-page ' . $activeClass . '">' . $p . "</a>";

          $prev = $p;
        }

        // Next Button
        if ($current < $total) {
          echo '<a href="' . $baseUrl . ($current + 1) . '" class="btn-page c-0 tc-gray">&gt;</a>';
        } else {
          echo '<span class="btn-page disabled">&gt;</span>';
        }
      ?>
    </div>
  <?php endif; ?>
</section>
