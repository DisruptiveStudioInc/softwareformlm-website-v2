<?php

namespace App\Models;

class Service
{
  private static ?array $services = null;

  private static function loadServices(): void
  {
    if (self::$services !== null) {
      return;
    }

    self::$services = require __DIR__ . '/../../config/services.php';
  }

  public static function findBySlug(string $slug, string $language): ?array
  {
    self::loadServices();

    foreach (self::$services as $key => $service) {
      if (isset($service[$language]['slug']) && $service[$language]['slug'] === $slug) {
        $content = self::loadContent($service['content_file']);

        return [
          'key' => $key,
          'template' => $service['template'],
          'meta' => $service[$language],
          'content' => $content,
        ];
      }
    }

    return null;
  }

  private static function loadContent(string $contentFile): array
  {
    $file = __DIR__ . "/../../content/services/{$contentFile}.php";

    if (!file_exists($file)) {
      return [];
    }

    $contentData = require $file;
    return $contentData ?? [];
  }

  /**
   * Check if a service is active
   *
   * @param array $service The service configuration array
   * @return bool True if the service is active, false otherwise
   */
  private static function isServiceActive(array $service): bool
  {
    return isset($service['isActive']) && $service['isActive'] === true;
  }

  public static function getAll(string $language): array|string
  {
    self::loadServices();

    $result = [];
    foreach (self::$services as $key => $service) {
      if (isset($service[$language]) && self::isServiceActive($service)) {
        $content = self::loadContent($service['content_file']);

        $result[] = [
          'key' => $key,
          'category' => $service['category'] ?? 'services',
          'template' => $service['template'],
          'meta' => $service[$language],
          'content' => $content,
        ];
      }
    }

    return empty($result) ? 'no_services' : $result;
  }

  public static function getByCategory(string $category, string $language): array|string
  {
    self::loadServices();

    $result = [];
    foreach (self::$services as $key => $service) {
      if (isset($service[$language]) && ($service['category'] ?? 'services') === $category && self::isServiceActive($service)) {
        $content = self::loadContent($service['content_file']);

        $result[] = [
          'key' => $key,
          'category' => $service['category'],
          'template' => $service['template'],
          'meta' => $service[$language],
          'content' => $content,
        ];
      }
    }

    return empty($result) ? 'no_services' : $result;
  }

  public static function getNavIps(string $language): array|string
  {
    self::loadServices();

    $result = [];
    foreach (self::$services as $key => $service) {
      if (isset($service[$language]) && ($service['category'] ?? 'services') === 'ips' && self::isServiceActive($service) && ($service['inNav'] ?? false) === true) {

        $content = self::loadContent($service['content_file']);

        $result[] = [
          'key' => $key,
          'category' => $service['category'],
          'template' => $service['template'],
          'meta' => $service[$language],
          'content' => $content,
        ];
      }
    }

    return empty($result) ? 'no_services' : $result;
  }

  public static function getCategories(): array
  {
    return ['services', 'ecosystem', 'ips'];
  }

  public static function getServiceSubcategories(): array
  {
    return [
      'blockchain',
      'custom-software',
      'payment-processing',
      'referral-marketing',
      'creative-services',
      'hr'
    ];
  }

  public static function getBySubcategory(string $subcategory, string $language): array|string
  {
    self::loadServices();

    $result = [];
    foreach (self::$services as $key => $service) {
      if (isset($service[$language]) && ($service['subcategory'] ?? null) === $subcategory && self::isServiceActive($service)) {
        $result[] = [
          'key' => $key,
          'category' => $service['category'],
          'subcategory' => $service['subcategory'],
          'icon' => $service['icon'],
          'meta' => $service[$language],
        ];
      }
    }

    return empty($result) ? 'no_services' : $result;
  }

  public static function getServicesGroupedBySubcategory(string $language): array|string
  {
    self::loadServices();

    $grouped = [];
    foreach (self::$services as $key => $service) {
      if (($service['category'] ?? 'services') !== 'services' || !isset($service[$language]) || !self::isServiceActive($service)) {
        continue;
      }

      $subcategory = $service['subcategory'] ?? 'other';

      if (!isset($grouped[$subcategory])) {
        $grouped[$subcategory] = [];
      }

      $grouped[$subcategory][] = [
        'key' => $key,
        'meta' => $service[$language],
      ];
    }

    return empty($grouped) ? 'no_services' : $grouped;
  }

  public static function exists(string $slug, string $language): bool
  {
    return self::findBySlug($slug, $language) !== null;
  }

  public static function getTranslatedSlug(string $slug, string $fromLang, string $toLang): ?string
  {
    self::loadServices();

    // Find the service key by slug in the source language
    $serviceKey = null;
    foreach (self::$services as $key => $service) {
      if (isset($service[$fromLang]['slug']) && $service[$fromLang]['slug'] === $slug) {
        $serviceKey = $key;
        break;
      }
    }

    if ($serviceKey === null) {
      return null;
    }

    // Return the slug in the target language
    return self::$services[$serviceKey][$toLang]['slug'] ?? null;
  }
}
