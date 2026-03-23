<?php
$pageTitle = $trans('error.404.title');
require __DIR__ . '/../layouts/header.php';
?>

<section class="py-20">
  <div class="container mx-auto px-4">
    <div class="max-w-2xl mx-auto text-center">
      <div class="mb-8 fade-in">
        <h1 class="text-9xl font-bold text-blue-600">404</h1>
      </div>

      <h2 class="text-4xl font-bold mb-4 fade-in">
        <?= $trans('error.404.title') ?>
      </h2>

      <p class="text-xl text-gray-600 mb-8 fade-in">
        <?= $trans('error.404.message') ?>
      </p>

      <a href="<?= route('home', $currentLang, $config['languages']['default']) ?>" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
        <?= $trans('error.404.back_home') ?>
      </a>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
