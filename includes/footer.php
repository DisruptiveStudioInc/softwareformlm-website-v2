</main>

<footer class="c-surf-100">
  <div class="mw-1440 pb-100 md-pb-80">

    <div class="med-fd-col ai-start g-30 jc-between">
      <div class="w-50 small-w-100 small-jc-center">

        <img src="/images/logo/logo.svg" class="mw-200 med-m-center" alt="<?= $company_fullname ?>">
        <ul class="fw-wrap med-jc-center g-10 mt-20">
          <?php foreach($constants['socials'] as $name => $url): ?>
            <li>
              <a target="_blank" href="<?= $url; ?>" class="v-black icon small br-2 icon-<?= $name; ?>"></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="w-100 jc-end med-jc-center med-fd-col g-40 small-g-20">
        <ul class="menu-list link">
          <h3><?= $Footer_title_02; ?></h3>
          <?php foreach($Footer_menu['legal'] as $item): ?>
            <li><a href="<?= $item['link']; ?>"><?= $item['title']; ?></a></li>
          <?php endforeach; ?>
        </ul>
        <ul class="menu-list link">
          <h3><?= $Footer_title_03; ?></h3>
          <li><?= $constants['email'] ?></li>
          <li><?= $constants['phone'] ?></li>
          <li><?= $constants['address'] ?></li>
        </ul>
      </div>
    </div>
    <div class="t-c p-10 mt-20" style="border-top:1px solid #464f77;">
      <p><?= $Footer_Rights; ?></p>
    </div>
  </div>
</footer>

<?php include_once('iconSprite.php'); ?>

<script src="/js/lozad.min.js"></script>
<script src="/js/script.js"></script>
</body>
</html>
