  </main>

<!-- ============================================== -->
<!-- FOOTER -->
<!-- ============================================== -->

<footer class="c-surf-100">
  <div class="mw-1440 pb-100 md-pb-80">


    <?php $Condicion_1 =(isset($user_replica))? 'g-30 jc-between':''; ?>
    <?php $Condicion =(isset($user_replica))? '':'ai-center t-c fd-col'; ?>
    <div class="med-fd-col ai-start <?php echo $Condicion_1; ?>">
      <div class="w-50 small-w-100 small-jc-center <?php echo $Condicion; ?>">

        <img src="./images/logo/logo.svg" class="mw-200 med-m-center" alt="logo evo">
        <ul class="fw-wrap med-jc-center g-10 mt-20">
          <?php foreach($Socials as $name => $url): ?>
            <li>
              <a target="_blank" href="<?= $url; ?>" class="v-black icon small br-2 icon-<?= $name; ?>"></a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php if($user_replica): ?>
        <div class="w-100 jc-end med-jc-center med-fd-col g-40 small-g-20">
          <ul class="menu-list link">
            <h3><?php echo $Footer_title_02; ?></h3>
            <li><a href="?p=terms"><?php echo $Footer_link_01; ?></a></li>
            <li><a href="?p=privacy_policy"><?php echo $Footer_link_02; ?></a></li>
          </ul>
          <ul class="menu-list link">
            <h3><?php echo $Footer_title_03; ?></h3>
            <li><?php echo $Email; ?></li>
            <li><?php echo $Phone; ?></li>
            <li><?php echo $Address; ?></li>
          </ul>
        </div>
      <?php endif; ?>
    </div>
    <div class="t-c p-10 mt-20" style="border-top:1px solid #464f77;">
      <p><?php echo $Footer_Rights; ?></p>
    </div>
  </div>
</footer>

<?php include_once('iconSprite.php'); ?>

<!-- ============================================== -->
<!-- SCRIPTS -->
<!-- ============================================== -->

<script src="./js/lozad.min.js"></script>
<script src="./js/script.js"></script>
<script src="./js/slider_tabs.js"></script>

</body>
</html>
