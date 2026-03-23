<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Exception;

class WordPressClient
{
  private string $endpoint;
  private Client $client;
  private string $cacheDir;
  private string $username;
  private string $password;

  public function __construct()
  {
    $this->endpoint = $_ENV['WP_API_URL'] ?? '';
    $this->username = $_ENV['WP_USER'] ?? '';
    $this->password = $_ENV['WP_APP_PASSWORD'] ?? '';

    if (empty($this->endpoint)) {
      throw new Exception('WP_API_URL environment variable is not set');
    }
    if (empty($this->username)) {
      throw new Exception('WP_USER environment variable is not set');
    }
    if (empty($this->password)) {
      throw new Exception('WP_APP_PASSWORD environment variable is not set');
    }

    $this->client = new Client([
      'timeout' => 10,
      'connect_timeout' => 5,
    ]);

    $this->cacheDir = __DIR__ . '/../../cache/wordpress';
    $this->ensureCacheDirectory();
  }

  /**
   * Get paginated posts by language
   *
   * @param string $lang Language code (ES or EN)
   * @param string|null $after Cursor for pagination (use endCursor from previous request)
   * @param int $limit Posts per page
   * @return array
   */
  public function getPosts(string $lang = 'EN', ?string $after = null, int $limit = 10): array
  {
    $cacheKey = "posts_{$lang}_" . ($after ?: 'first') . "_{$limit}";

    // Try cache first
    if ($cached = $this->getFromCache($cacheKey)) {
      return $cached;
    }

    // Optimized query: removed SEO fields, mediaDetails, tags to reduce memory usage
    $query = '
      query GetPosts($lang: LanguageCodeFilterEnum!, $limit: Int!, $after: String) {
        posts(where: {language: $lang, orderby: {field: DATE, order: DESC}}, first: $limit, after: $after) {
          pageInfo {
            hasNextPage
            endCursor
          }
          nodes {
            id
            title
            slug
            excerpt
            date
            featuredImage {
              node {
                sourceUrl
                altText
              }
            }
            categories {
              nodes {
                name
                slug
              }
            }
          }
        }
      }
    ';

    $variables = [
      'lang' => strtoupper($lang),
      'limit' => $limit,
      'after' => $after
    ];

    $result = $this->request($query, $variables);

    if (isset($result['data']['posts'])) {
      $data = [
        'posts' => $result['data']['posts']['nodes'] ?? [],
        'pageInfo' => $result['data']['posts']['pageInfo'] ?? []
      ];

      $this->saveToCache($cacheKey, $data);
      return $data;
    }

    return ['posts' => [], 'pageInfo' => []];
  }

  /**
   * Get total pages count for pagination
   * Uses a lightweight query that only fetches IDs
   *
   * @param string $lang Language code (ES or EN)
   * @param int $postsPerPage Posts per page
   * @return int Total number of pages
   */
  public function getTotalPages(string $lang = 'EN', int $postsPerPage = 10): int
  {
    $cacheKey = "total_pages_{$lang}_{$postsPerPage}";

    // Try cache first
    if ($cached = $this->getFromCache($cacheKey)) {
      return $cached;
    }

    // Lightweight query - only fetch IDs to count posts
    $query = '
      query GetPostsCount($lang: LanguageCodeFilterEnum!) {
        posts(where: {language: $lang}, first: 1000) {
          nodes {
            id
          }
        }
      }
    ';

    $variables = ['lang' => strtoupper($lang)];
    $result = $this->request($query, $variables);

    $totalPosts = count($result['data']['posts']['nodes'] ?? []);
    $totalPages = max(1, (int) ceil($totalPosts / $postsPerPage));

    $this->saveToCache($cacheKey, $totalPages);
    return $totalPages;
  }

  /**
   * Get all page cursors for numbered pagination
   * Optimized: Only fetches cursors when needed, heavily cached
   *
   * @param string $lang Language code
   * @param int $limit Posts per page
   * @return array Array of cursors indexed by page number
   */
  public function getPageCursors(string $lang = 'EN', int $limit = 10): array
  {
    $cacheKey = "page_cursors_{$lang}_{$limit}";

    // Try cache first - cursors are cached for the full TTL
    if ($cached = $this->getFromCache($cacheKey)) {
      return $cached;
    }

    // Lightweight query to get all post IDs with cursors
    $query = '
      query GetAllPostCursors($lang: LanguageCodeFilterEnum!) {
        posts(where: {language: $lang, orderby: {field: DATE, order: DESC}}, first: 1000) {
          edges {
            cursor
          }
        }
      }
    ';

    $variables = ['lang' => strtoupper($lang)];
    $result = $this->request($query, $variables);

    $edges = $result['data']['posts']['edges'] ?? [];
    $totalPosts = count($edges);
    $cursors = [1 => null]; // Page 1 has no cursor

    // Calculate cursor for each page
    // Only add cursor if there are more posts after this page
    $pageNumber = 1;
    foreach ($edges as $index => $edge) {
      // If this is the last post of a page AND there are more posts after
      if (($index + 1) % $limit === 0 && ($index + 1) < $totalPosts) {
        $pageNumber++;
        $cursors[$pageNumber] = $edge['cursor'];
      }
    }

    $this->saveToCache($cacheKey, $cursors);
    return $cursors;
  }

  /**
   * Get a single post by slug
   *
   * @param string $slug Post slug
   * @param string|null $lang Language code (ES or EN), null for any language
   * @return array|null
   */
  public function getPostBySlug(string $slug, ?string $lang = null): ?array
  {
    $cacheKey = "post_{$slug}" . ($lang ? "_{$lang}" : '');

    // Try cache first
    if ($cached = $this->getFromCache($cacheKey)) {
      return $cached;
    }

    // Optimized query: removed SEO fields (using title/excerpt instead)
    // Kept only essential fields for single post view
    $query = '
      query GetPostBySlug($slug: ID!) {
        post(id: $slug, idType: SLUG) {
          id
          title
          slug
          content
          excerpt
          date
          modified
          featuredImage {
            node {
              sourceUrl
              altText
              mediaDetails {
                width
                height
              }
            }
          }
          categories {
            nodes {
              name
              slug
            }
          }
          tags {
            nodes {
              name
              slug
            }
          }
          translations {
            slug
            language {
              code
              name
            }
          }
        }
      }
    ';

    $variables = ['slug' => $slug];
    if ($lang) {
      $variables['lang'] = strtoupper($lang);
    }

    $result = $this->request($query, $variables);

    if (isset($result['data']['post']) && $result['data']['post'] !== null) {
      $post = $result['data']['post'];
      $this->saveToCache($cacheKey, $post);
      return $post;
    }

    return null;
  }

  /**
   * Get posts by category with pagination support
   *
   * @param string $categorySlug Category slug
   * @param string $lang Language code
   * @param string|null $after Cursor for pagination
   * @param int $limit Posts per page
   * @return array
   */
  public function getPostsByCategory(string $categorySlug, string $lang = 'ES', ?string $after = null, int $limit = 10): array
  {
    $cacheKey = "posts_category_{$categorySlug}_{$lang}_" . ($after ?: 'first') . "_{$limit}";

    if ($cached = $this->getFromCache($cacheKey)) {
      return $cached;
    }

    // Query with pagination support
    $query = '
      query GetPostsByCategory($categorySlug: String!, $lang: LanguageCodeFilterEnum!, $limit: Int!, $after: String) {
        posts(where: {categoryName: $categorySlug, language: $lang, orderby: {field: DATE, order: DESC}}, first: $limit, after: $after) {
          pageInfo {
            hasNextPage
            endCursor
          }
          nodes {
            id
            title
            slug
            excerpt
            date
            featuredImage {
              node {
                sourceUrl
                altText
              }
            }
            categories {
              nodes {
                name
                slug
              }
            }
          }
        }
      }
    ';

    $variables = [
      'categorySlug' => $categorySlug,
      'lang' => strtoupper($lang),
      'limit' => $limit,
      'after' => $after
    ];

    $result = $this->request($query, $variables);

    if (isset($result['data']['posts'])) {
      $data = [
        'posts' => $result['data']['posts']['nodes'] ?? [],
        'pageInfo' => $result['data']['posts']['pageInfo'] ?? []
      ];
      $this->saveToCache($cacheKey, $data);
      return $data;
    }

    return ['posts' => [], 'pageInfo' => []];
  }

  /**
   * Get page cursors for category pagination
   *
   * @param string $categorySlug Category slug
   * @param string $lang Language code
   * @param int $limit Posts per page
   * @return array Array of cursors indexed by page number
   */
  public function getCategoryPageCursors(string $categorySlug, string $lang = 'EN', int $limit = 10): array
  {
    $cacheKey = "category_cursors_{$categorySlug}_{$lang}_{$limit}";

    if ($cached = $this->getFromCache($cacheKey)) {
      return $cached;
    }

    // Get all posts in category to calculate cursors
    $query = '
      query GetCategoryPostCursors($categorySlug: String!, $lang: LanguageCodeFilterEnum!) {
        posts(where: {categoryName: $categorySlug, language: $lang, orderby: {field: DATE, order: DESC}}, first: 1000) {
          edges {
            cursor
          }
        }
      }
    ';

    $variables = [
      'categorySlug' => $categorySlug,
      'lang' => strtoupper($lang)
    ];
    $result = $this->request($query, $variables);

    $edges = $result['data']['posts']['edges'] ?? [];
    $totalPosts = count($edges);
    $cursors = [1 => null]; // Page 1 has no cursor

    // Calculate cursor for each page
    $pageNumber = 1;
    foreach ($edges as $index => $edge) {
      if (($index + 1) % $limit === 0 && ($index + 1) < $totalPosts) {
        $pageNumber++;
        $cursors[$pageNumber] = $edge['cursor'];
      }
    }

    $this->saveToCache($cacheKey, $cursors);
    return $cursors;
  }

  /**
   * Get all categories
   *
   * @param string $lang Language code
   * @return array
   */
  public function getCategories(string $lang = 'ES'): array
  {
    $cacheKey = "categories_{$lang}";

    if ($cached = $this->getFromCache($cacheKey)) {
      return $cached;
    }

    // Optimized query: minimal fields for category list
    $query = '
      query GetCategories($lang: LanguageCodeFilterEnum!) {
        categories(where: {language: $lang}) {
          nodes {
            name
            slug
            count
          }
        }
      }
    ';

    $variables = ['lang' => strtoupper($lang)];
    $result = $this->request($query, $variables);

    if (isset($result['data']['categories']['nodes'])) {
      $categories = $result['data']['categories']['nodes'];
      $this->saveToCache($cacheKey, $categories);
      return $categories;
    }

    return [];
  }

  /**
   * Make GraphQL request to WordPress
   *
   * @param string $query GraphQL query
   * @param array $variables Query variables
   * @return array
   * @throws Exception
   */
  private function request(string $query, array $variables = []): array
  {
    static $requestCount = 0;
    $requestCount++;

    if ($requestCount > 15) {
      throw new Exception("Infinite loop detected in WordPressClient: Too many requests.");
    }
    try {
      $response = $this->client->post($this->endpoint, [
        'auth' => [$this->username, $this->password],
        'json' => [
          'query' => $query,
          'variables' => $variables
        ],
        'headers' => [
          'Content-Type' => 'application/json',
          'Accept' => 'application/json',
        ]
      ]);

      $body = $response->getBody()->getContents();
      $data = json_decode($body, true);

      if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Invalid JSON response from WordPress API');
      }

      // Check for GraphQL errors
      if (isset($data['errors']) && !empty($data['errors'])) {
        $errorMessage = $data['errors'][0]['message'] ?? 'Unknown GraphQL error';
        throw new Exception("GraphQL Error: {$errorMessage}");
      }

      return $data;

    } catch (GuzzleException $e) {
      if ($e->getCode() === 401) {
        throw new Exception("WordPress API Authentication failed: Check your App Password.");
      }
      throw new Exception("WordPress API request failed: " . $e->getMessage());
    }
  }

  /**
   * Get data from cache
   * Cache is persistent until cleared by webhook
   *
   * @param string $key Cache key
   * @return mixed|null
   */
  private function getFromCache(string $key): mixed
  {
    $cacheFile = $this->cacheDir . '/' . md5($key) . '.json';

    if (!file_exists($cacheFile)) {
      return null;
    }

    $content = @file_get_contents($cacheFile);
    if ($content === false) {
      return null;
    }

    return json_decode($content, true);
  }

  /**
   * Save data to cache
   *
   * @param string $key Cache key
   * @param mixed $data Data to cache
   * @return bool
   */
  private function saveToCache(string $key, mixed $data): bool
  {
    $cacheFile = $this->cacheDir . '/' . md5($key) . '.json';
    $content = json_encode($data, JSON_PRETTY_PRINT);

    return @file_put_contents($cacheFile, $content) !== false;
  }

  /**
   * Clear all cache
   *
   * @return void
   */
  public function clearCache(): void
  {
    $files = glob($this->cacheDir . '/*.json');
    foreach ($files as $file) {
      if (is_file($file)) {
        @unlink($file);
      }
    }
  }

  /**
   * Clear cache for specific key pattern
   *
   * @param string $pattern Pattern to match (e.g., 'posts_*')
   * @return void
   */
  public function clearCachePattern(string $pattern): void
  {
    $files = glob($this->cacheDir . '/*.json');
    foreach ($files as $file) {
      if (is_file($file)) {
        $content = @file_get_contents($file);
        if ($content && str_contains($file, md5($pattern))) {
          @unlink($file);
        }
      }
    }
  }

  /**
   * Ensure cache directory exists
   *
   * @return void
   */
  private function ensureCacheDirectory(): void
  {
    if (!is_dir($this->cacheDir)) {
      @mkdir($this->cacheDir, 0755, true);
    }
  }
}
