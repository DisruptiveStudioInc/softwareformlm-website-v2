<?php

declare(strict_types=1);

namespace Tests;

use App\Services\BlogRepository;
use PHPUnit\Framework\Attributes\Test;

final class BlogRepositoryTest extends BlogTestCase
{
    #[Test]
    public function it_returns_only_visible_posts_in_descending_date_order(): void
    {
        $this->writePost('en', 'older-post', ['date' => '2026-08-10']);
        $this->writePost('en', 'newer-post', ['date' => '2026-08-25']);
        $this->writePost('en', 'draft-post', ['published' => false]);
        $this->writePost('en', 'future-post', ['date' => '2026-09-01']);
        self::assertSame(['newer-post', 'older-post'], array_column($this->repository()->published('en'), 'slug'));
    }

    #[Test]
    public function it_skips_invalid_posts_and_logs_each_reason(): void
    {
        $this->writePost('en', 'valid-post');
        $this->writePost('en', 'bad-category', ['categories' => ['unknown']]);
        $this->writePost('en', 'wrong-language', ['language' => 'es']);
        $posts = $this->repository()->published('en');
        self::assertSame(['valid-post'], array_column($posts, 'slug'));
        self::assertCount(2, $this->logs);
    }

    #[Test]
    public function it_maps_localized_category_and_translation_slugs(): void
    {
        $this->writePost('en', 'english-post', ['translation' => 'articulo-espanol']);
        $this->writePost('es', 'articulo-espanol', ['translation' => 'english-post']);
        $repository = $this->repository();
        self::assertSame('multilevel', $repository->categoryKeyFromSlug('es', 'multinivel'));
        self::assertSame('articulo-espanol', $repository->translatedSlug('english-post', 'es'));
        self::assertNull($repository->findPublished('en', '../english-post'));
    }

    #[Test]
    public function migrated_content_contains_all_38_posts_and_19_pairs(): void
    {
        $root = dirname(__DIR__);
        $repository = new BlogRepository($root . '/content/blog', $root . '/public/images/blog');
        self::assertCount(19, $repository->published('en'));
        self::assertCount(19, $repository->published('es'));
        foreach ($repository->published('en') as $post) {
            self::assertNotNull($post->translation);
            self::assertSame($post->translation, $repository->translatedSlug($post->slug, 'es'));
        }
    }
}
