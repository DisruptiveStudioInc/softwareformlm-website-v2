<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\BlogPost;
use App\Models\Language;
use App\Request;
use App\Response;
use App\Services\BlogRepository;
use App\Services\BlogService;
use App\Services\MarkdownRenderer;
use Throwable;

final class BlogController extends BaseController
{
    private readonly BlogService $blog;

    public function __construct()
    {
        parent::__construct();
        $root = dirname(__DIR__, 2);
        $this->blog = new BlogService(
            new BlogRepository($root . '/content/blog', $root . '/public/images/blog'),
            new MarkdownRenderer(),
        );
    }

    public function index(Request $request): Response
    {
        $language = Language::getCurrentLanguage();
        $pageValue = $request->getQuery('page', 1);
        $page = is_scalar($pageValue) ? max(1, (int) $pageValue) : 1;
        $categoryValue = $request->getQuery('category');
        $category = is_string($categoryValue) ? $categoryValue : null;

        try {
            $listing = $this->blog->listing($language, $page, $category);
            $posts = array_map(fn(BlogPost $post): array => $this->card($post), $listing['posts']);
            $pagination = [
                'hasNext' => $listing['currentPage'] < $listing['totalPages'],
                'hasPrev' => $listing['currentPage'] > 1,
                'currentPage' => $listing['currentPage'],
                'totalPages' => $listing['totalPages'],
                'pages' => $listing['pages'],
            ];

            return $this->view('blog/index', [
                'title' => Language::trans('blog.title'),
                'metaDescription' => Language::trans('blog.description'),
                'posts' => $posts,
                'categories' => $listing['categories'],
                'pagination' => $pagination,
                'selectedCategory' => $listing['selectedCategory'],
                'includeTracking' => true,
                'hasSnapScroll' => false,
                'hasTextTexture' => false,
            ]);
        } catch (Throwable $exception) {
            error_log('Blog index error: ' . $exception->getMessage());
            return $this->view('blog/index', [
                'title' => Language::trans('blog.title'),
                'metaDescription' => Language::trans('blog.description'),
                'posts' => [],
                'categories' => [],
                'pagination' => null,
                'selectedCategory' => null,
                'error' => Language::trans('blog.error_loading'),
                'includeTracking' => true,
                'hasSnapScroll' => false,
                'hasTextTexture' => false,
            ]);
        }
    }

    public function show(Request $request): Response
    {
        $slugValue = $request->getRouteParam('slug');
        $language = Language::getCurrentLanguage();
        if (!is_string($slugValue) || $slugValue === '') {
            return $this->notFound($request);
        }

        try {
            $post = $this->blog->find($language, $slugValue);
            if ($post === null) {
                return $this->notFound($request);
            }
            $formattedPost = $this->formatPost($post);
            $relatedPosts = array_map(fn(BlogPost $item): array => $this->card($item), $this->blog->related($post));
            $image = rtrim((string) $this->config['app']['url'], '/') . $post->coverUrl();

            return $this->view('blog/show', [
                'title' => $post->name,
                'metaDescription' => $post->seoDescription,
                'post' => $formattedPost,
                'relatedPosts' => $relatedPosts,
                'readingTime' => $this->blog->readingTime($post),
                'structuredData' => $this->structuredData($post),
                'postTranslations' => $this->blog->languageOptions($post),
                'includeTracking' => true,
                'hasSnapScroll' => false,
                'hasTextTexture' => false,
                'ogType' => 'article',
                'ogTitle' => $post->name,
                'ogDescription' => $post->seoDescription,
                'ogImage' => $image,
                'twitterTitle' => $post->name,
                'twitterDescription' => $post->seoDescription,
                'twitterImage' => $image,
            ]);
        } catch (Throwable $exception) {
            error_log('Blog show error: ' . $exception->getMessage());
            return $this->notFound($request);
        }
    }

    /** @return array<string, mixed> */
    private function card(BlogPost $post): array
    {
        return [
            'title' => $post->name,
            'slug' => $post->slug,
            'excerpt' => $post->seoDescription,
            'date' => $this->blog->formatDate($post),
            'dateRaw' => $post->date->format('Y-m-d'),
            'featuredImage' => [
                'url' => $post->coverUrl(),
                'alt' => $post->coverAlt,
            ],
            'categories' => $this->blog->categoryTerms($post),
            'url' => $this->postUrl($post),
        ];
    }

    /** @return array<string, mixed> */
    private function formatPost(BlogPost $post): array
    {
        return [
            'title' => $post->name,
            'slug' => $post->slug,
            'excerpt' => $post->seoDescription,
            'content' => $this->blog->render($post),
            'date' => $this->blog->formatDate($post),
            'dateRaw' => $post->date->format('Y-m-d'),
            'modified' => $post->updated->format('Y-m-d'),
            'featuredImage' => [
                'url' => $post->coverUrl(),
                'alt' => $post->coverAlt,
            ],
            'categories' => $this->blog->categoryTerms($post),
            'tags' => [],
            'url' => $this->postUrl($post),
        ];
    }

    private function structuredData(BlogPost $post): string
    {
        $baseUrl = rtrim((string) $this->config['app']['url'], '/');
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $post->name,
            'description' => $post->seoDescription,
            'image' => [
                '@type' => 'ImageObject',
                'url' => $baseUrl . $post->coverUrl(),
            ],
            'datePublished' => $post->date->format('Y-m-d'),
            'dateModified' => $post->updated->format('Y-m-d'),
            'inLanguage' => $post->language,
            'articleSection' => array_column($this->blog->categoryTerms($post), 'name'),
            'mainEntityOfPage' => $baseUrl . $this->postUrl($post),
            'author' => ['@type' => 'Organization', 'name' => $post->author],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Disruptive Studio',
                'logo' => ['@type' => 'ImageObject', 'url' => $baseUrl . '/public/logo.svg'],
            ],
        ];
        $json = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return $json === false ? '' : $json;
    }

    private function postUrl(BlogPost $post): string
    {
        return ($post->language === 'en' ? '/en' : '') . '/blog/' . rawurlencode($post->slug);
    }

    private function notFound(Request $request): Response
    {
        $controller = new ErrorController();
        $controller->setLanguage($this->language);
        return $controller->notFound($request);
    }
}
