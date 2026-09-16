<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

require_once dirname(__DIR__) . '/src/helpers.php';

final class PerformanceHelpersTest extends TestCase
{
    #[Test]
    public function animated_and_still_backgrounds_are_valid_svg_documents(): void
    {
        foreach (['glowing-bg', 'light-bg', 'glowing-bg-still', 'light-bg-still'] as $name) {
            $document = new \DOMDocument();
            self::assertTrue($document->load(dirname(__DIR__) . '/public/images/background/' . $name . '.svg', LIBXML_NONET));
            self::assertSame('svg', $document->documentElement->localName);
        }
    }

    #[Test]
    public function preload_matches_picture_candidates_and_sizes(): void
    {
        $path = '/public/images/home/bo-computer.webp';
        $sizes = '(min-width: 1088px) 45vw, min(40vh, 90vw)';
        $picture = responsive_image($path, '', 'hero', $sizes);
        $preload = responsive_image_preload($path, $sizes);
        preg_match('/<source type="image\/avif" srcset="([^"]+)"/', $picture, $match);
        self::assertStringContainsString('imagesrcset="' . $match[1] . '"', $preload);
        self::assertStringContainsString('imagesizes="' . $sizes . '"', $preload);
        self::assertStringNotContainsString(' href=', $preload);
        foreach (responsive_image_data($path)['sources'] as $candidates) {
            foreach ($candidates as $candidate) {
                $url = explode(' ', $candidate)[0];
                self::assertFileExists(dirname(__DIR__) . parse_url($url, PHP_URL_PATH));
            }
        }
    }

    #[Test]
    public function missing_variants_do_not_generate_a_broken_preload(): void
    {
        self::assertSame('', responsive_image_preload('/public/images/missing.webp', '100vw'));
        self::assertSame('', responsive_image_preload('https://example.com/image.jpg', '100vw'));
    }

    #[Test]
    public function import_map_versions_transitive_modules(): void
    {
        $map = json_decode(javascript_import_map(), true, flags: JSON_THROW_ON_ERROR);
        foreach (['widgets.js', 'third-parties.js', 'recaptcha.js', 'depthSlider.js', 'animations.js'] as $module) {
            $path = '/public/assets/js/' . $module;
            self::assertSame(asset_url($path), $map['imports'][$path]);
            self::assertStringContainsString('?v=', $map['imports'][$path]);
        }
    }

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
