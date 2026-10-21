<?php

declare(strict_types=1);

// Minimum releases fixing CVE-2026-109618 and CVE-2026-109619.
// Review security releases before enabling another PHP branch.
$minimumVersion = match (PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION) {
    '8.3' => '8.3.36',
    '8.4' => '8.4.27',
    '8.5' => '8.5.12',
    default => null,
};

if ($minimumVersion === null || version_compare(PHP_VERSION, $minimumVersion, '<')) {
    fwrite(STDERR, 'Unsupported or unpatched PHP ' . PHP_VERSION
        . '. Required: 8.3.36+, 8.4.27+, or 8.5.12+ within those branches.' . PHP_EOL);
    exit(1);
}

fwrite(STDOUT, 'PHP ' . PHP_VERSION . ' meets the security minimum.' . PHP_EOL);
