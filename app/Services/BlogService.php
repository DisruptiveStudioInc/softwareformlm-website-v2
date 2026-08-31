<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\BlogPost;

final readonly class BlogService
{
    public function __construct(
        private BlogRepository $repository,
        private MarkdownRenderer $renderer,
        private int $postsPerPage = 8,
    ) {
    }

    /**
     * @return array{
     *   posts: list<BlogPost>,
     *   totalPosts: int,
     *   categories: list<array{key: string, slug: string, name: string, count: int}>,
     *   selectedCategory: ?string,
     *   currentPage: int,
     *   totalPages: int,
     *   pages: list<int|string>
     * }
     */
    public function listing(string $language, int $requestedPage, ?string $requestedCategorySlug): array
    {
        $catalog = $this->repository->categories();
        $categoryKey = $this->repository->categoryKeyFromSlug($language, $requestedCategorySlug);
        $allPosts = $this->repository->published($language);
        $counts = [];
        foreach ($allPosts as $post) {
            foreach ($post->categories as $key) {
                $counts[$key] = ($counts[$key] ?? 0) + 1;
            }
        }
        $categories = [];
        foreach ($catalog as $key => $definition) {
            $count = $counts[$key] ?? 0;
            if ($count > 0) {
                $categories[] = [
                    'key' => $key,
                    'slug' => $definition['slugs'][$language],
                    'name' => $definition['labels'][$language],
                    'count' => $count,
                ];
            }
        }
        $filtered = $categoryKey === null
            ? $allPosts
            : array_values(array_filter(
                $allPosts,
                static fn(BlogPost $post): bool => in_array($categoryKey, $post->categories, true),
            ));
        $totalPages = max(1, (int) ceil(count($filtered) / $this->postsPerPage));
        $currentPage = min(max(1, $requestedPage), $totalPages);
        $posts = array_slice($filtered, ($currentPage - 1) * $this->postsPerPage, $this->postsPerPage);

        return [
            'posts' => $posts,
            'totalPosts' => count($allPosts),
            'categories' => $categories,
            'selectedCategory' => $categoryKey === null ? null : $catalog[$categoryKey]['slugs'][$language],
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'pages' => $this->pageNumbers($currentPage, $totalPages),
        ];
    }

    public function find(string $language, string $slug): ?BlogPost
    {
        return $this->repository->findPublished($language, $slug);
    }

    public function translatedSlug(string $slug, string $targetLanguage): ?string
    {
        return $this->repository->translatedSlug($slug, $targetLanguage);
    }

    public function render(BlogPost $post): string
    {
        return $this->renderer->render($post->markdown);
    }

    /** @return list<BlogPost> */
    public function related(BlogPost $post, int $limit = 3): array
    {
        if ($post->categories === []) {
            return [];
        }
        $related = array_filter(
            $this->repository->published($post->language),
            static fn(BlogPost $candidate): bool =>
                $candidate->slug !== $post->slug
                && array_intersect($post->categories, $candidate->categories) !== [],
        );
        return array_slice(array_values($related), 0, $limit);
    }

    /** @return list<array{slug: string, code: string, name: string, url: string}> */
    public function languageOptions(BlogPost $post): array
    {
        $options = [[
            'slug' => $post->slug,
            'code' => $post->language,
            'name' => $post->language === 'es' ? 'Esp' : 'Eng',
            'url' => $this->postUrl($post->language, $post->slug),
        ]];
        $otherLanguage = $post->language === 'en' ? 'es' : 'en';
        if ($post->translation !== null) {
            $translation = $this->repository->findPublished($otherLanguage, $post->translation);
            if ($translation !== null) {
                $options[] = [
                    'slug' => $translation->slug,
                    'code' => $translation->language,
                    'name' => $translation->language === 'es' ? 'Esp' : 'Eng',
                    'url' => $this->postUrl($translation->language, $translation->slug),
                ];
            }
        }
        usort($options, static fn(array $left, array $right): int => strcmp($left['code'], $right['code']));
        return $options;
    }

    /** @return list<array{name: string, slug: string}> */
    public function categoryTerms(BlogPost $post): array
    {
        $catalog = $this->repository->categories();
        $terms = [];
        foreach ($post->categories as $key) {
            $terms[] = [
                'name' => $catalog[$key]['labels'][$post->language],
                'slug' => $catalog[$key]['slugs'][$post->language],
            ];
        }
        return $terms;
    }

    public function formatDate(BlogPost $post): string
    {
        if ($post->language === 'es') {
            $months = [1 => 'enero', 2 => 'febrero', 3 => 'marzo', 4 => 'abril', 5 => 'mayo', 6 => 'junio', 7 => 'julio', 8 => 'agosto', 9 => 'septiembre', 10 => 'octubre', 11 => 'noviembre', 12 => 'diciembre'];
            return $post->date->format('d') . ' de ' . $months[(int) $post->date->format('n')] . ' de ' . $post->date->format('Y');
        }
        return $post->date->format('F d, Y');
    }

    public function readingTime(BlogPost $post, int $wordsPerMinute = 200): int
    {
        $words = str_word_count(strip_tags($post->markdown));
        return max(1, (int) ceil($words / $wordsPerMinute));
    }

    /** @return list<int|string> */
    private function pageNumbers(int $current, int $total): array
    {
        if ($total <= 1) {
            return [];
        }
        $pages = [1];
        $start = max(2, $current - 2);
        $end = min($total - 1, $current + 2);
        if ($start > 2) {
            $pages[] = '…';
        }
        for ($page = $start; $page <= $end; $page++) {
            $pages[] = $page;
        }
        if ($end < $total - 1) {
            $pages[] = '…';
        }
        $pages[] = $total;
        return $pages;
    }

    private function postUrl(string $language, string $slug): string
    {
        return ($language === 'en' ? '/en' : '') . '/blog/' . rawurlencode($slug);
    }
}
