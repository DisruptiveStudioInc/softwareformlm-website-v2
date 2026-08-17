<?php

declare(strict_types=1);

/**
 * Externalised SVG symbol sheet. Keeping symbols out of each HTML document
 * removes hundreds of nodes from the initial parse while retaining the
 * existing currentColor-based icon system.
 */
header('Content-Type: image/svg+xml; charset=utf-8');
header('Cache-Control: public, max-age=31536000, immutable');

require dirname(__DIR__, 2) . '/app/Views/components/svgSprites.php';
