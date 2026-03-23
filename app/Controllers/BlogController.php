<?php

namespace App\Controllers;

use App\Request;
use App\Response;
use App\Models\Language;
use App\Models\Blog;
use App\Services\WordPressClient;
use Exception;

class BlogController extends BaseController
{
  private WordPressClient $wp;
  private int $postsPerPage = 8;

  public function __construct()
  {
    parent::__construct();

    try {
      $this->wp = new WordPressClient();
    } catch (Exception $e) {
      // Log error or handle appropriately
      error_log('WordPress Client initialization failed: ' . $e->getMessage());
    }
  }

  /**
   * Blog landing page with post listing
   *
   * @param Request $request
   * @return Response
   */
  public function index(Request $request): Response
  {
    $currentLang = Language::getCurrentLanguage();
    $cursor = $request->getQuery('after'); // Cursor for pagination
    $category = $request->getQuery('category');

    try {
      // Fetch posts data
      if ($category) {
        // Get category page cursors for numbered pagination
        $pageCursors = $this->wp->getCategoryPageCursors($category, strtoupper($currentLang), $this->postsPerPage);

        // Fetch posts with pagination (method signature: categorySlug, lang, after, limit)
        $data = $this->wp->getPostsByCategory($category, strtoupper($currentLang), $cursor, $this->postsPerPage);
        $posts = $data['posts'] ?? [];
        $pageInfo = $data['pageInfo'] ?? [];

        $formattedPosts = Blog::formatMultiple($posts);
        $pagination = Blog::generatePagination($pageInfo, $pageCursors, $cursor, $this->postsPerPage);
      } else {
        // Get page cursors for numbered pagination (cached)
        $pageCursors = $this->wp->getPageCursors(strtoupper($currentLang), $this->postsPerPage);

        // Fetch posts using cursor-based pagination
        $data = $this->wp->getPosts(strtoupper($currentLang), $cursor, $this->postsPerPage);
        $posts = $data['posts'] ?? [];
        $pageInfo = $data['pageInfo'] ?? [];

        $formattedPosts = Blog::formatMultiple($posts);
        $pagination = Blog::generatePagination($pageInfo, $pageCursors, $cursor, $this->postsPerPage);
      }

      // Fetch categories for sidebar/filter
      $categories = $this->wp->getCategories(strtoupper($currentLang));

      return $this->view('blog/index', [
        'title' => Language::trans('blog.title'),
        'metaDescription' => Language::trans('blog.description'),
        'posts' => $formattedPosts,
        'categories' => $categories,
        'pagination' => $pagination,
        'selectedCategory' => $category,
        'hasSnapScroll' => false,
        'hasTextTexture' => false,
      ]);

    } catch (Exception $e) {
      error_log('Blog index error: ' . $e->getMessage());

      return $this->view('blog/index', [
        'title' => Language::trans('blog.title'),
        'posts' => [],
        'categories' => [],
        'pagination' => null,
        'error' => Language::trans('blog.error_loading'),
        'hasSnapScroll' => false,
        'hasTextTexture' => false,
      ]);
    }
  }

  /**
   * Single post page
   *
   * @param Request $request
   * @return Response
   */
  public function show(Request $request): Response
  {
    $slug = $request->getRouteParam('slug');
    $currentLang = Language::getCurrentLanguage();

    if (empty($slug)) {
      return $this->callController('App\\Controllers\\ErrorController', 'notFound', $request);
    }

    try {
      // Fetch post data
      $post = $this->wp->getPostBySlug($slug, strtoupper($currentLang));

      if (!$post) {
        return $this->callController('App\\Controllers\\ErrorController', 'notFound', $request);
      }

      $formattedPost = Blog::format($post);

      // Get related posts from the same category
      $relatedPosts = [];
      if (!empty($formattedPost['categories'])) {
        $firstCategory = $formattedPost['categories'][0]['slug'] ?? null;
        if ($firstCategory) {
          $relatedData = $this->wp->getPostsByCategory($firstCategory, strtoupper($currentLang), null, 4);
          $related = $relatedData['posts'] ?? [];
          // Remove current post from related
          $related = array_filter($related, function($p) use ($slug) {
            return ($p['slug'] ?? '') !== $slug;
          });
          $relatedPosts = Blog::formatMultiple(array_slice($related, 0, 3));
        }
      }

      // Calculate reading time
      $readingTime = Blog::getReadingTime($formattedPost['content']);

      // Build structured data for SEO
      $structuredData = $this->buildStructuredData($formattedPost);

      // Prepare post translations for language switcher
      $postTranslations = $formattedPost['translations'] ?? [];

      // Use title and excerpt for SEO (Yoast SEO removed for lighter queries)
      $seoTitle = $formattedPost['title'];
      $seoDescription = $formattedPost['excerpt'];
      $seoImage = $formattedPost['featuredImage']['url'] ?? '';

      return $this->view('blog/show', [
        'title' => $seoTitle,
        'metaDescription' => $seoDescription,
        'post' => $formattedPost,
        'relatedPosts' => $relatedPosts,
        'readingTime' => $readingTime,
        'structuredData' => $structuredData,
        'postTranslations' => $postTranslations, // Pass translations to header
        'hasSnapScroll' => false,
        'hasTextTexture' => false,
        // SEO meta tags (using title/excerpt/featuredImage)
        'ogType' => 'article',
        'ogTitle' => $seoTitle,
        'ogDescription' => $seoDescription,
        'ogImage' => $seoImage,
        'twitterTitle' => $seoTitle,
        'twitterDescription' => $seoDescription,
        'twitterImage' => $seoImage,
      ]);

    } catch (Exception $e) {
      error_log('Blog show error: ' . $e->getMessage());
      return $this->callController('App\\Controllers\\ErrorController', 'notFound', $request);
    }
  }

  /**
   * Build structured data (JSON-LD) for SEO
   *
   * @param array $post Formatted post data
   * @return string JSON-LD structured data
   */
  private function buildStructuredData(array $post): string
  {
    $data = [
      '@context' => 'https://schema.org',
      '@type' => 'BlogPosting',
      'headline' => $post['title'],
      'description' => $post['excerpt'],
      'datePublished' => $post['dateRaw'],
      'dateModified' => $post['modified'],
    ];

    if ($post['featuredImage']) {
      $data['image'] = [
        '@type' => 'ImageObject',
        'url' => $post['featuredImage']['url'],
        'width' => $post['featuredImage']['width'],
        'height' => $post['featuredImage']['height'],
      ];
    }

    if (!empty($post['categories'])) {
      $data['articleSection'] = array_map(function($cat) {
        return $cat['name'];
      }, $post['categories']);
    }

    if (!empty($post['tags'])) {
      $data['keywords'] = array_map(function($tag) {
        return $tag['name'];
      }, $post['tags']);
    }

    return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  }

  /**
   * Helper to call error controller
   */
  private function callController(string $controller, string $method, Request $request): Response
  {
    $instance = new $controller();
    if (method_exists($instance, 'setLanguage')) {
      $instance->setLanguage($this->language);
    }
    return $instance->$method($request);
  }

  /**
   * Clear WordPress cache (useful for webhooks)
   *
   * @param Request $request
   * @return Response
   */
  public function clearCache(Request $request): Response
  {
    // This could be protected with a secret token
    $token = $request->getQuery('token');
    $expectedToken = $_ENV['CACHE_CLEAR_TOKEN'] ?? '';

    if (empty($expectedToken) || $token !== $expectedToken) {
      return $this->json(['error' => 'Unauthorized'], 403);
    }

    try {
      $this->wp->clearCache();
      return $this->json(['success' => true, 'message' => 'Cache cleared']);
    } catch (Exception $e) {
      return $this->json(['error' => $e->getMessage()], 500);
    }
  }
}
