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
      event: '<?= htmlspecialchars($eventName ?? 'zoom_demo_redirect', ENT_QUOTES, 'UTF-8') ?>',
      destination: <?= json_encode($redirectUrl, JSON_UNESCAPED_SLASHES) ?>
    });

    window.setTimeout(function () {
      window.location.replace(<?= json_encode($redirectUrl, JSON_UNESCAPED_SLASHES) ?>);
    }, <?= (int) ($redirectDelayMs ?? 250) ?>);
  </script>
</head>
<body style="display:flex;flex-direction:column;justify-content:center;align-items:center;height:100vh;margin:0;">
  <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
    <style>
      #spin-loader {
        transform-origin: 20px 20px;
        animation: spin-loader-rotation 1s linear infinite;
      }

      @keyframes spin-loader-rotation {
        from {
          transform: rotate(0deg);
        }

        to {
          transform: rotate(360deg);
        }
      }
    </style>
    <path opacity="0.5" d="M20.0007 3.33301C16.7043 3.33301 13.482 4.31049 10.7412 6.14185C8.00034 7.9732 5.86413 10.5762 4.60267 13.6216C3.34121 16.6671 3.01115 20.0182 3.65424 23.2512C4.29732 26.4842 5.88467 29.4539 8.21555 31.7848C10.5464 34.1157 13.5161 35.703 16.7492 36.3461C19.9822 36.9892 23.3333 36.6591 26.3787 35.3977C29.4242 34.1362 32.0271 32 33.8585 29.2592C35.6898 26.5184 36.6673 23.296 36.6673 19.9997C36.6673 17.811 36.2362 15.6437 35.3987 13.6216C34.5611 11.5995 33.3334 9.7622 31.7858 8.21456C30.2381 6.66692 28.4008 5.43926 26.3787 4.60168C24.3566 3.7641 22.1894 3.33301 20.0007 3.33301ZM20.0007 33.333C17.3636 33.333 14.7857 32.551 12.5931 31.0859C10.4004 29.6209 8.69143 27.5385 7.68227 25.1021C6.6731 22.6658 6.40905 19.9849 6.92352 17.3985C7.43799 14.8121 8.70787 12.4363 10.5726 10.5716C12.4373 8.70688 14.813 7.43701 17.3995 6.92254C19.9859 6.40807 22.6668 6.67211 25.1031 7.68128C27.5395 8.69045 29.6218 10.3994 31.0869 12.5921C32.552 14.7847 33.334 17.3626 33.334 19.9997C33.334 23.5359 31.9292 26.9273 29.4287 29.4278C26.9283 31.9283 23.5369 33.333 20.0007 33.333Z" fill="#DDDDDD"/>
    <path id="spin-loader" d="M33.2293 18.3373C33.3441 19.2506 34.0795 19.9997 35 19.9997C35.9205 19.9997 36.6753 19.2516 36.5834 18.3358C36.4211 16.7179 36.0225 15.1294 35.398 13.6216C34.5604 11.5995 33.3328 9.7622 31.7851 8.21456C30.2375 6.66692 28.4002 5.43926 26.3781 4.60168C24.8703 3.97714 23.2818 3.57861 21.6639 3.41627C20.748 3.32438 20 4.0792 20 4.99967C20 5.92015 20.7491 6.65558 21.6624 6.77033C24.5857 7.1376 27.3227 8.46618 29.4281 10.5716C31.5335 12.677 32.8621 15.414 33.2293 18.3373Z" fill="#00FFE8"/>
  </svg>
  <p style="font-family:sans-serif;">Redirecting to demo. If you are not redirected automatically, <a href="<?= htmlspecialchars($redirectUrl, ENT_QUOTES, 'UTF-8') ?>">continue here</a>.</p>
  <?php include __DIR__ . '/../components/footer-traking.php'; ?>
</body>
</html>
