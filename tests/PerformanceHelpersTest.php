<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__) . '/src/helpers.php';

final class PerformanceHelpersTest extends TestCase
{
    #[Test]
    public function animated_words_escapes_content_and_preserves_word_spacing(): void
    {
        $html = animated_words('Fast & <safe>');

        self::assertSame(
            '<span class="animated-word word1">Fast</span> <span class="animated-word word2">&amp;</span> <span class="animated-word word3">&lt;safe&gt;</span>',
            $html,
        );
    }

    #[Test]
    public function local_responsive_image_uses_intrinsic_dimensions_and_modern_sources(): void
    {
        $html = responsive_image(
            '/public/images/home/bo-computer.webp',
            'Back office',
            'hero-image',
            '80vw',
            ['loading' => 'eager'],
        );

        self::assertStringContainsString('type="image/avif"', $html);
        self::assertStringContainsString('bo-computer-w384.avif', $html);
        self::assertStringContainsString('width="850" height="850"', $html);
        self::assertStringContainsString('loading="eager"', $html);
    }

    #[Test]
    public function remote_responsive_image_preserves_the_external_url(): void
    {
        $html = responsive_image(
            'https://cdn.example.com/cover.webp',
            'Cover',
            'cover',
            '100vw',
            ['loading' => 'lazy'],
        );

        self::assertStringContainsString('src="https://cdn.example.com/cover.webp"', $html);
        self::assertStringNotContainsString('/https://', $html);
    }
}
