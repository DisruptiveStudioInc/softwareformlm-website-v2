<!DOCTYPE html>
<html lang="<?= $currentLang ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle ?? 'Zoom Demo Redirect', ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="robots" content="noindex, nofollow">
  <meta http-equiv="refresh" content="<?= (int) ($metaRefreshSeconds ?? 1) ?>;url=<?= htmlspecialchars($redirectUrl, ENT_QUOTES, 'UTF-8') ?>">
  <?php include __DIR__ . '/../components/header-traking.php'; ?>
  <script>
    window.dataLayer = window.dataLayer || [];
    window.dataLayer.push({
      event: 'zoom_demo_redirect',
      destination: <?= json_encode($redirectUrl, JSON_UNESCAPED_SLASHES) ?>
    });

    window.setTimeout(function () {
      window.location.replace(<?= json_encode($redirectUrl, JSON_UNESCAPED_SLASHES) ?>);
    }, <?= (int) ($redirectDelayMs ?? 250) ?>);
  </script>
</head>
<body style="display:flex;justify-content:center;align-items:center;height:100vh;margin:0;">
  <p>Redirecting to demo. If you are not redirected automatically, <a href="<?= htmlspecialchars($redirectUrl, ENT_QUOTES, 'UTF-8') ?>">continue here</a>.</p>
  <?php include __DIR__ . '/../components/footer-traking.php'; ?>
</body>
</html>
