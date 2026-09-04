<?php

declare(strict_types=1);

ob_start();
require dirname(__DIR__) . '/app/Views/components/svgSprites.php';
$svg = ob_get_clean();

if ($svg === false || trim($svg) === '') {
    fwrite(STDERR, "Unable to render SVG sprite.\n");
    exit(1);
}

$target = dirname(__DIR__) . '/public/assets/icons.svg';
if (file_put_contents($target, $svg) === false) {
    fwrite(STDERR, "Unable to write {$target}.\n");
    exit(1);
}

fwrite(STDOUT, "generated public/assets/icons.svg\n");
