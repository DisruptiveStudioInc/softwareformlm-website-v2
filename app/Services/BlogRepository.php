<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\BlogPost;
use Closure;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Throwable;

final class BlogRepository
{
    /** @var array<string, array<string, BlogPost>> */
    private array $postCache = [];

    /** @var array<string, array{labels: array<string, string>, slugs: array<string, string>}>|null */
    private ?array $categoryCache = null;

    /** @var Closure(string): void */
    private readonly Closure $logger;

    private readonly DateTimeImmutable $today;

    /**
     * @param list<string> $languages
     */
    public function __construct(
        private readonly string $contentDirectory,
        private readonly string $coverDirectory,
        private readonly array $languages = ['en', 'es'],
        ?DateTimeImmutable $today = null,
        ?callable $logger = null,
    ) {
        $this->today = $today ?? new DateTimeImmutable('today', new DateTimeZone('UTC'));
        $this->logger = static function (string $message) use ($logger): void {
            if ($logger !== null) {
                $logger($message);
                return;
            }
            error_log($message);
        };
    }

    /** @return list<BlogPost> */
    public function published(string $language): array
    {
        $this->assertLanguage($language);
        $posts = array_values(array_filter(
            $this->postsForLanguage($language),
            fn(BlogPost $post): bool => $post->isVisible($this->today),
        ));
        usort(
            $posts,
            static fn(BlogPost $left, BlogPost $right): int =>
                $right->date <=> $left->date ?: strcmp($left->slug, $right->slug),
        );
        return $posts;
    }

    /** @return list<BlogPost> */
    public function allPublished(): array
    {
        $posts = [];
        foreach ($this->languages as $language) {
            array_push($posts, ...$this->published($language));
        }
        return $posts;
    }

    public function findPublished(string $language, string $slug): ?BlogPost
    {
        if (!in_array($language, $this->languages, true) || !$this->isSlug($slug)) {
            return null;
        }
        $post = $this->postsForLanguage($language)[$slug] ?? null;
        return $post !== null && $post->isVisible($this->today) ? $post : null;
    }

    public function translatedSlug(string $sourceSlug, string $targetLanguage): ?string
    {
        if (!in_array($targetLanguage, $this->languages, true) || !$this->isSlug($sourceSlug)) {
            return null;
        }
        foreach ($this->languages as $language) {
            $source = $this->findPublished($language, $sourceSlug);
            if ($source === null) {
                continue;
            }
            if ($source->language === $targetLanguage) {
                return $source->slug;
            }
            if ($source->translation === null) {
                return null;
            }
            return $this->findPublished($targetLanguage, $source->translation)?->slug;
        }
        return null;
    }

    /**
     * @return array<string, array{labels: array<string, string>, slugs: array<string, string>}>
     */
    public function categories(): array
    {
        if ($this->categoryCache !== null) {
            return $this->categoryCache;
        }
        $path = $this->contentDirectory . '/categories.yaml';
        if (!is_file($path) || !is_readable($path)) {
            throw new RuntimeException('Blog category catalog is missing or unreadable.');
        }
        try {
            $parsed = Yaml::parseFile($path);
        } catch (ParseException $exception) {
            throw new RuntimeException('Blog category catalog contains invalid YAML.', 0, $exception);
        }
        if (!is_array($parsed) || !isset($parsed['categories']) || !is_array($parsed['categories'])) {
            throw new RuntimeException('Blog category catalog must contain a categories map.');
        }

        $catalog = [];
        foreach ($parsed['categories'] as $key => $definition) {
            if (!is_string($key) || !$this->isSlug($key) || !is_array($definition)) {
                throw new RuntimeException('Blog category keys must be lowercase hyphenated slugs.');
            }
            $labels = $definition['labels'] ?? null;
            $slugs = $definition['slugs'] ?? null;
            if (!is_array($labels) || !is_array($slugs)) {
                throw new RuntimeException("Category {$key} requires labels and slugs maps.");
            }
            $catalog[$key] = ['labels' => [], 'slugs' => []];
            foreach ($this->languages as $language) {
                $label = $labels[$language] ?? null;
                $localizedSlug = $slugs[$language] ?? null;
                if (!is_string($label) || trim($label) === '' || !is_string($localizedSlug) || !$this->isSlug($localizedSlug)) {
                    throw new RuntimeException("Category {$key} has invalid {$language} localization.");
                }
                $catalog[$key]['labels'][$language] = trim($label);
                $catalog[$key]['slugs'][$language] = $localizedSlug;
            }
        }
        return $this->categoryCache = $catalog;
    }

    public function categoryKeyFromSlug(string $language, ?string $slug): ?string
    {
        if ($slug === null || !$this->isSlug($slug)) {
            return null;
        }
        foreach ($this->categories() as $key => $definition) {
            if (($definition['slugs'][$language] ?? null) === $slug) {
                return $key;
            }
        }
        return null;
    }

    /** @return array<string, BlogPost> */
    private function postsForLanguage(string $language): array
    {
        if (isset($this->postCache[$language])) {
            return $this->postCache[$language];
        }
        $posts = [];
        $files = glob($this->contentDirectory . '/' . $language . '/*.md') ?: [];
        sort($files, SORT_STRING);
        foreach ($files as $path) {
            try {
                $post = $this->parseFile($path, $language);
                if (isset($posts[$post->slug])) {
                    throw new InvalidArgumentException('Duplicate blog slug: ' . $post->slug);
                }
                $posts[$post->slug] = $post;
            } catch (Throwable $exception) {
                ($this->logger)('Skipping invalid blog post ' . basename($path) . ': ' . $exception->getMessage());
            }
        }
        return $this->postCache[$language] = $posts;
    }

    private function parseFile(string $path, string $folderLanguage): BlogPost
    {
        $source = file_get_contents($path);
        if ($source === false || !preg_match('/\A---\R(.*?)\R---(?:\R|\z)(.*)\z/s', $source, $matches)) {
            throw new InvalidArgumentException('Front matter must be enclosed by --- markers.');
        }
        try {
            $metadata = Yaml::parse($matches[1]);
        } catch (ParseException $exception) {
            throw new InvalidArgumentException('Front matter contains invalid YAML.', 0, $exception);
        }
        if (!is_array($metadata)) {
            throw new InvalidArgumentException('Front matter must be a YAML map.');
        }

        $name = $this->requiredString($metadata, 'name');
        $cover = $this->requiredString($metadata, 'cover');
        $coverAlt = $this->requiredString($metadata, 'cover_alt');
        $slug = $this->requiredString($metadata, 'url');
        $description = $this->requiredString($metadata, 'seo_description');
        $language = $this->requiredString($metadata, 'language');
        $translation = $this->optionalString($metadata, 'translation');
        $author = $this->optionalString($metadata, 'author') ?? 'Disruptive Studio';
        $date = $this->parseDate($metadata['date'] ?? null, 'date');
        $updated = isset($metadata['updated']) ? $this->parseDate($metadata['updated'], 'updated') : $date;
        $published = $metadata['published'] ?? null;
        $categories = $metadata['categories'] ?? null;
        $markdown = trim($matches[2]);

        if ($language !== $folderLanguage || !in_array($language, $this->languages, true)) {
            throw new InvalidArgumentException('Language metadata must match a supported containing folder.');
        }
        if (!$this->isSlug($slug) || basename($path, '.md') !== $slug) {
            throw new InvalidArgumentException('The filename and url must be the same lowercase hyphenated slug.');
        }
        if ($translation !== null && !$this->isSlug($translation)) {
            throw new InvalidArgumentException('The translation must be a valid slug.');
        }
        if (!is_bool($published)) {
            throw new InvalidArgumentException('The published field must be true or false.');
        }
        if (!is_array($categories) || !array_is_list($categories)) {
            throw new InvalidArgumentException('The categories field must be a YAML list.');
        }
        $validCategories = [];
        $catalog = $this->categories();
        foreach ($categories as $category) {
            if (!is_string($category) || !isset($catalog[$category])) {
                throw new InvalidArgumentException('Every category must reference a catalog key.');
            }
            if (!in_array($category, $validCategories, true)) {
                $validCategories[] = $category;
            }
        }
        if (!preg_match('/\A[a-zA-Z0-9][a-zA-Z0-9._-]*\.(?:webp|avif|jpe?g|png)\z/i', $cover)
            || !is_file($this->coverDirectory . '/' . $cover)) {
            throw new InvalidArgumentException('The cover must name an existing safe local image.');
        }
        if ($markdown === '') {
            throw new InvalidArgumentException('The Markdown body cannot be empty.');
        }

        return new BlogPost($name, $cover, $coverAlt, $slug, $description, $language, $translation, $date, $updated, $published, $validCategories, $author, $markdown, $path);
    }

    /** @param array<array-key, mixed> $metadata */
    private function requiredString(array $metadata, string $key): string
    {
        $value = $metadata[$key] ?? null;
        if (!is_string($value) || trim($value) === '') {
            throw new InvalidArgumentException("The {$key} field is required.");
        }
        return trim($value);
    }

    /** @param array<array-key, mixed> $metadata */
    private function optionalString(array $metadata, string $key): ?string
    {
        $value = $metadata[$key] ?? null;
        if ($value === null || $value === '') {
            return null;
        }
        if (!is_string($value)) {
            throw new InvalidArgumentException("The {$key} field must be a string.");
        }
        return trim($value);
    }

    private function parseDate(mixed $value, string $field): DateTimeImmutable
    {
        if ($value instanceof DateTimeInterface) {
            return DateTimeImmutable::createFromInterface($value)->setTimezone(new DateTimeZone('UTC'));
        }
        if (!is_string($value)) {
            throw new InvalidArgumentException("The {$field} field must use YYYY-MM-DD.");
        }
        $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value, new DateTimeZone('UTC'));
        $errors = DateTimeImmutable::getLastErrors();
        if ($date === false || ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0))) {
            throw new InvalidArgumentException("The {$field} field must use YYYY-MM-DD.");
        }
        return $date;
    }

    private function isSlug(string $value): bool
    {
        return preg_match('/\A[a-z0-9]+(?:-[a-z0-9]+)*\z/', $value) === 1;
    }

    private function assertLanguage(string $language): void
    {
        if (!in_array($language, $this->languages, true)) {
            throw new InvalidArgumentException('Unsupported blog language.');
        }
    }
}
