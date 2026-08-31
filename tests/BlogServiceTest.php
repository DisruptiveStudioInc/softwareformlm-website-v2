<?php

declare(strict_types=1);

namespace Tests;

use App\Services\BlogService;
use App\Services\MarkdownRenderer;
use PHPUnit\Framework\Attributes\Test;

final class BlogServiceTest extends BlogTestCase
{
    #[Test]
    public function it_paginates_filters_and_counts_localized_categories(): void
    {
        for ($day = 1; $day <= 10; $day++) {
            $this->writePost('es', 'post-' . $day, ['date' => sprintf('2026-08-%02d', $day)]);
        }
        $service = new BlogService($this->repository(), new MarkdownRenderer());
        $first = $service->listing('es', 1, null);
        $second = $service->listing('es', 2, 'multinivel');
        self::assertCount(8, $first['posts']);
        self::assertCount(2, $second['posts']);
        self::assertSame(2, $first['totalPages']);
        self::assertSame('multinivel', $second['selectedCategory']);
        self::assertSame(10, $first['categories'][0]['count']);
    }

    #[Test]
    public function it_clamps_pages_and_returns_related_posts_and_language_options(): void
    {
        $this->writePost('en', 'english-post', ['translation' => 'articulo-espanol']);
        $this->writePost('es', 'articulo-espanol', ['translation' => 'english-post']);
        $this->writePost('en', 'related-post');
        $service = new BlogService($this->repository(), new MarkdownRenderer());
        $post = $service->find('en', 'english-post');
        self::assertNotNull($post);
        self::assertSame(1, $service->listing('en', 99, null)['currentPage']);
        self::assertSame(['related-post'], array_column($service->related($post), 'slug'));
        self::assertSame('/blog/articulo-espanol', $service->languageOptions($post)[1]['url']);
        self::assertGreaterThanOrEqual(1, $service->readingTime($post));
    }
}
