<?php

declare(strict_types=1);

namespace Tests;

use App\Services\BlogRepository;
use DateTimeImmutable;
use DateTimeZone;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

abstract class BlogTestCase extends TestCase
{
    protected string $root;
    /** @var list<string> */
    protected array $logs = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->root = sys_get_temp_dir() . '/sfmlm-blog-' . bin2hex(random_bytes(6));
        mkdir($this->root . '/content/en', 0755, true);
        mkdir($this->root . '/content/es', 0755, true);
        mkdir($this->root . '/covers', 0755, true);
        file_put_contents($this->root . '/covers/cover.webp', 'test-cover');
        file_put_contents($this->root . '/content/categories.yaml', "categories:\n  multilevel:\n    labels:\n      en: Multilevel\n      es: Multinivel\n    slugs:\n      en: multilevel\n      es: multinivel\n");
    }

    protected function tearDown(): void
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($this->root, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST,
        );
        foreach ($iterator as $item) {
            $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
        }
        rmdir($this->root);
        parent::tearDown();
    }

    /** @param array<string, mixed> $overrides */
    protected function writePost(string $language, string $slug, array $overrides = []): void
    {
        $metadata = array_replace([
            'name' => ucfirst(str_replace('-', ' ', $slug)),
            'cover' => 'cover.webp',
            'cover_alt' => 'Cover alt',
            'url' => $slug,
            'seo_description' => 'Description for ' . $slug,
            'language' => $language,
            'translation' => null,
            'date' => '2026-08-20',
            'updated' => '2026-08-20',
            'published' => true,
            'categories' => ['multilevel'],
            'author' => 'Disruptive Studio',
        ], $overrides);
        $source = "---\n" . Yaml::dump($metadata, 3, 2) . "---\n\n## Heading\n\nArticle body.\n";
        file_put_contents($this->root . '/content/' . $language . '/' . $slug . '.md', $source);
    }

    protected function repository(): BlogRepository
    {
        return new BlogRepository(
            $this->root . '/content',
            $this->root . '/covers',
            today: new DateTimeImmutable('2026-08-31', new DateTimeZone('UTC')),
            logger: function (string $message): void {
                $this->logs[] = $message;
            },
        );
    }
}
