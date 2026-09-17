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
// Keep every symbol mentioned anywhere in application templates or local data.
// Dynamic keys (service benefits, social links) are literal IDs in these files.
// Deliberately conservative substring matching retains ambiguous short IDs.
$sources = '';
foreach (['app', 'config', 'content', 'lang', 'src', 'public/assets/js'] as $directory) {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__DIR__) . '/' . $directory));
    foreach ($files as $file) {
        if (!$file->isFile() || $file->getFilename() === 'svgSprites.php') {
            continue;
        }
        $sources .= file_get_contents($file->getPathname());
    }
}
$document = new DOMDocument();
$document->preserveWhiteSpace = false;
if (!$document->loadXML($svg, LIBXML_NONET)) {
    throw new RuntimeException('Invalid source sprite.');
}
$symbols = [];
$keep = [];
foreach ($document->getElementsByTagName('symbol') as $symbol) {
    $id = $symbol->getAttribute('id');
    $symbols[$id] = $symbol;
    if (str_contains($sources, $id)) {
        $keep[$id] = true;
    }
}
// Preserve referenced symbols transitively; retain all shared masks/gradients.
do {
    $previous = count($keep);
    foreach (array_keys($keep) as $id) {
        preg_match_all('/(?:href=["\']#|url\(#)([\w.-]+)/', $document->saveXML($symbols[$id]), $references);
        foreach ($references[1] as $reference) {
            if (isset($symbols[$reference])) {
                $keep[$reference] = true;
            }
        }
    }
} while (count($keep) !== $previous);
foreach ($symbols as $id => $symbol) {
    if (!isset($keep[$id])) {
        $symbol->parentNode->removeChild($symbol);
    }
}
$svg = $document->saveXML($document->documentElement);
if (file_put_contents($target, $svg) === false) {
    fwrite(STDERR, "Unable to write {$target}.\n");
    exit(1);
}

fwrite(STDOUT, sprintf("generated public/assets/icons.svg (%d/%d symbols, %d bytes)\n", count($keep), count($symbols), strlen($svg)));

// Non-service pages need only shared UI symbols. Keep the full sprite for
// service templates whose benefit icons come from per-service content data.
$uiIds = [];
$views = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(dirname(__DIR__) . '/app/Views'));
foreach ($views as $file) {
    if (!$file->isFile() || in_array($file->getFilename(), ['svgSprites.php', 'service-type-1.php', 'service-type-2.php'], true)) {
        continue;
    }
    preg_match_all('/\?>#([\w-]+)/', file_get_contents($file->getPathname()), $matches);
    foreach ($matches[1] as $id) {
        $uiIds[$id] = true;
    }
}
// Footer social keys are the only dynamic UI symbol names outside services.
// Conservatively retain any symbol named in constants (including those keys).
$constants = file_get_contents(dirname(__DIR__) . '/config/constants.php');
foreach (array_keys($keep) as $id) {
    if (str_contains($constants, $id)) {
        $uiIds[$id] = true;
    }
}
do {
    $previous = count($uiIds);
    foreach (array_keys($uiIds) as $id) {
        if (!isset($symbols[$id])) {
            throw new RuntimeException("Unknown UI icon {$id}");
        }
        preg_match_all('/(?:href=["\']#|url\(#)([\w.-]+)/', $document->saveXML($symbols[$id]), $references);
        foreach ($references[1] as $reference) {
            if (isset($symbols[$reference])) {
                $uiIds[$reference] = true;
            }
        }
    }
} while (count($uiIds) !== $previous);
$uiDocument = clone $document;
$remove = [];
foreach ($uiDocument->getElementsByTagName('symbol') as $symbol) {
    if (!isset($uiIds[$symbol->getAttribute('id')])) {
        $remove[] = $symbol;
    }
}
foreach ($remove as $symbol) {
    $symbol->parentNode->removeChild($symbol);
}
$uiSvg = $uiDocument->saveXML($uiDocument->documentElement);
if (file_put_contents(dirname(__DIR__) . '/public/assets/icons-ui.svg', $uiSvg) === false) {
    throw new RuntimeException('Unable to write UI sprite.');
}
fwrite(STDOUT, sprintf("generated public/assets/icons-ui.svg (%d symbols, %d bytes)\n", count($uiIds), strlen($uiSvg)));
