<?php
namespace Controllers;

use Includes\Localization;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class BlogController extends BaseController {

  private $postsPath;

  public function __construct() {
    parent::__construct();
    $this->postsPath = __DIR__ . '/../posts';
  }

  public function index($lang) {
    $this->setLang($lang);
    Localization::setCurrentRoute('blog');

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $perPage = 10;

    $posts = $this->getAllPosts($lang);

    // Sort by date desc
    usort($posts, function($a, $b) {
      return strtotime($b['publish-date']) - strtotime($a['publish-date']);
    });

    $total = count($posts);
    $totalPages = ceil($total / $perPage);

    // Slice for pagination
    $offset = ($page - 1) * $perPage;
    $currentPosts = array_slice($posts, $offset, $perPage);

    // Format dates for display
    foreach ($currentPosts as &$post) {
      if (isset($post['publish-date'])) {
        $post['formatted-date'] = $this->formatDate($post['publish-date'], $lang);
      }
    }
    unset($post); // Break reference

    // Prepare legacy data for view
    $data = [
      'posts' => $currentPosts,
      'pagination' => [
        'current' => $page,
        'total' => $totalPages,
        'url' => Localization::url('blog', [], $lang) . '?page='
      ]
    ];

    $this->view('blog', $data);
  }

  public function show($lang, $slug) {
    $this->setLang($lang);

    $post = $this->getPostBySlug($slug, $lang);

    if (!$post) {
      $this->notFound();
      return;
    }

    // Set Translation Map for the Switcher
    $this->setupLocalization($post, $lang);

    // Format the publish date
    if (isset($post['publish-date'])) {
      $post['formatted-date'] = $this->formatDate($post['publish-date'], $lang);
    }

    // Render content
    $converter = new GithubFlavoredMarkdownConverter([
      'html_input' => 'strip',
      'allow_unsafe_links' => false,
    ]);
    $contentHtml = $converter->convert($post['content']);
    $post['contentHtml'] = $contentHtml;

    // Related
    if (isset($post['related'])){
      $related = $this->getPostBySlug($post['related'], $lang);
      $post['relatedContent'] = $related;
    }

    $data = [];
    $data['post'] = $post;

    // SEO Data
    if (isset($post['meta-title']) && isset($post['meta-description']) && isset($post['keywords'])){
      $data['metaTitle'] = $post['meta-title'];
      $data['metaDescription'] = $post['meta-description'];
      $data['keywords'] = $post['keywords'];
    }

    $this->view('single_post', $data);
  }

  private function getAllPosts($lang) {
    $allPosts = $this->getPostsFromCache();

    $filtered = [];
    foreach ($allPosts as $post) {
      if (isset($post['language']) && $post['language'] === $lang) {
        $filtered[] = $post;
      }
    }
    return $filtered;
  }

  private function formatDate($dateString, $lang) {
    // Parse date from dd-mm-yyyy format
    $parts = explode('-', $dateString);
    if (count($parts) !== 3) {
      return $dateString; // Return original if format is unexpected
    }

    $day = $parts[0];
    $month = $parts[1];
    $year = $parts[2];

    // Create DateTime object
    $date = \DateTime::createFromFormat('d-m-Y', $dateString);
    if (!$date) {
      return $dateString; // Return original if parsing fails
    }

    // Month names in both languages
    $monthNames = [
      'en' => [
        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
      ],
      'es' => [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
      ]
    ];

    $monthName = $monthNames[$lang][(int)$month] ?? $month;

    // Format: Month Day, Year
    return $monthName . ' ' . (int)$day . ', ' . $year;
  }

  private function getPostBySlug($slug, $lang) {
    $allPosts = $this->getPostsFromCache();

    foreach ($allPosts as $post) {
      if (isset($post['slug']) && $post['slug'] === $slug &&
          isset($post['language']) && $post['language'] === $lang) {
        return $post;
      }
    }
    return null;
  }

  private function getPostsFromCache() {
    $cacheFile = $this->postsPath . '/posts_index.json';

    if (file_exists($cacheFile)) {
      // Check for invalidation
      $cacheTime = filemtime($cacheFile);
      $files = glob($this->postsPath . '/*.md');
      $isStale = false;

      foreach ($files as $file) {
        if (filemtime($file) > $cacheTime) {
          $isStale = true;
          break;
        }
      }

      if (!$isStale) {
        return json_decode(file_get_contents($cacheFile), true);
      }
    }

    return $this->buildCache($cacheFile);
  }

  private function buildCache($cacheFile) {
    $files = glob($this->postsPath . '/*.md');
    $posts = [];

    foreach ($files as $file) {
      $object = YamlFrontMatter::parse(file_get_contents($file));
      $metadata = $object->matter();
      // Cache body as well for single post retrieval
      $posts[] = array_merge($metadata, ['content' => $object->body()]);
    }

    file_put_contents($cacheFile, json_encode($posts));

    return $posts;
  }

  private function setupLocalization($post, $lang) {
    // Determine canonical slug (Prefer EN as canonical)
    // If post is EN, its slug is canonical.
    // If post is ES, its translation (EN) is canonical.
    // Note: This relies on 'translation' field being populated correctly.

    $currentSlug = $post['slug'];
    $otherSlug = $post['translation'] ?? $currentSlug;

    $canonical = ($post['language'] === 'en') ? $currentSlug : $otherSlug;

    // Construct the map
    $map = [];
    if ($post['language'] === 'en') {
       $map = [
          'en' => $currentSlug,
          'es' => $otherSlug
       ];
    } else {
       // If current is ES
       $map = [
          'es' => $currentSlug,
          'en' => $otherSlug
       ];
    }

    // Populate Localization
    Localization::$slugMap['blog-post'] = [
      $canonical => $map
    ];

    // BIG IMPORTANT STEP: Set the current route using the CANONICAL slug
    Localization::setCurrentRoute('blog-post', [$canonical]);
  }

  private function notFound() {
    http_response_code(404);
    include __DIR__ . '/../pages/404.inc.php';
  }
}
