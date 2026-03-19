<article class="mw-1080 pt-150 med-pt-100 pb-0 m-center p-20">
  <div class="post-header t-c mb-50 med-mb-40">
    <h1 class="h2 tc-ter mt-0"><?= $post['title'] ?></h1>
    <img src="<?= $post['cover'] ?>" alt="<?= $post['title'] ?>" class="w-100 br-10 mt-20 mb-10" style="max-height: 580px; object-fit: cover;">
    <small class="tc-gray d-block t-l"><?= $post['formatted-date'] ?? $post['publish-date'] ?></small>
  </div>

  <div class="post-content">
    <?= $post['contentHtml'] ?>
  </div>
</article>

<div class="mw-1080 m-center p-20 pb-100 med-pb-60 pt-50 mt-50" style="border-top:1px solid var(--color-pri)">
  <?php if(isset($post['relatedContent'])): ?>
    <h2 class="h3 mb-30"><?= $relatedTitle ?></h2>
    <article class="related-card p-20 br-16 c-0 t-l d-flex ai-center med-fd-col g-20 mb-40">
      <a href="<?= \Includes\Localization::url('blog-post', [$post['related']]) ?>" class="d-block w-50 med-w-100">
        <img src="<?= $post['relatedContent']['cover'] ?>" alt="<?= $post['relatedContent']['title'] ?>" class="w-100 br-8" style="aspect-ratio: 16/9; object-fit: cover;">
      </a>
      <div class="w-50 med-w-100">
        <h2 class="h5 m-0"><a href="<?= \Includes\Localization::url('blog-post', [$post['related']]) ?>" class="font-bold"><?= $post['relatedContent']['title'] ?></a></h2>
        <small class="tc-gray d-block"><?= $Blog_published ?> <?= $post['relatedContent']['formatted-date'] ?? $post['relatedContent']['publish-date'] ?></small>
        <a href="<?= \Includes\Localization::url('blog-post', [$post['related']]) ?>" class="btn c-acc br-8 mt-20"><?= $Btn_read ?></a>
      </div>
    </article>
  <?php endif; ?>

  <small class="d-block"><?= $Blog_footnote ?></small>
  <a href="<?= \Includes\Localization::url('blog') ?>" class="btn c-ter br-8 mt-40"><?= $Blog_backBtn ?></a>
</div>

<script src="/js/post-tables.js"></script>
