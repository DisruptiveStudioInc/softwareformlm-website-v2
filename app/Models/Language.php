<?php

namespace App\Models;

class Language
{
  private static ?array $translations = null;
  private static string $currentLanguage = 'en';

  public static function setLanguage(string $lang): void
  {
    self::$currentLanguage = $lang;
    self::$translations = null; // Reset cache
  }

  public static function getCurrentLanguage(): string
  {
    return self::$currentLanguage;
  }

  private static function loadTranslations(): void
{
    if (self::$translations !== null) {
      return;
    }

    $file = __DIR__ . "/../../lang/" . self::$currentLanguage . ".php";

    if (!file_exists($file)) {
      $file = __DIR__ . "/../../lang/en.php"; // Fallback to English
    }

    self::$translations = require $file;
  }

  public static function get(string $key, array $replacements = []): string
  {
    self::loadTranslations();

    $keys = explode('.', $key);
    $value = self::$translations;

    foreach ($keys as $k) {
      if (!isset($value[$k])) {
        return $key; // Return key if translation not found
      }
      $value = $value[$k];
    }

    if (!is_string($value)) {
      return $key;
    }

    // Replace placeholders
    foreach ($replacements as $search => $replace) {
      $value = str_replace(":{$search}", $replace, $value);
    }

    return $value;
  }

  public static function trans(string $key, array $replacements = []): string
  {
    return self::get($key, $replacements);
  }

  public static function getAll(): array
  {
    self::loadTranslations();
    return self::$translations;
  }
}
