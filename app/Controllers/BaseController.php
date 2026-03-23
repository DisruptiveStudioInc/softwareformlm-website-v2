<?php

namespace App\Controllers;

use App\Response;
use App\Models\Language;

class BaseController
{
  protected string $language = 'en';
  protected array $config;
  protected array $constants;

  public function __construct()
  {
    $this->config = require __DIR__ . '/../../config/config.php';
    $this->constants = require __DIR__ . '/../../config/constants.php';
  }

  public function setLanguage(string $language): void
  {
    $this->language = $language;
    Language::setLanguage($language);
  }

  protected function view(string $template, array $data = []): Response
  {
    $response = new Response();

    // Make data available to the view
    extract($data);

    // Add language helper to views
    $trans = function(string $key, array $replacements = []) {
      return Language::trans($key, $replacements);
    };

    // Add current language to views
    $currentLang = $this->language;

    // Add config to views
    $config = $this->config;

    // Add constants to views
    $constants = $this->constants;

    // Add navigation menu to views
    $navigationMenu = getNavigationMenu($currentLang, $trans);

    ob_start();
    require __DIR__ . "/../Views/templates/{$template}.php";
    $content = ob_get_clean();

    $response->setContent($content);
    return $response;
  }

  protected function json(array $data, int $statusCode = 200): Response
  {
    $response = new Response();
    return $response->json($data, $statusCode);
  }

  protected function redirect(string $url, int $statusCode = 302): void
  {
    $response = new Response();
    $response->redirect($url, $statusCode);
  }

  protected function loadPageContent(string $page): array
  {
    $file = __DIR__ . "/../../content/pages/{$page}.php";

    if (!file_exists($file)) {
      return [];
    }

    return require $file;
  }
}
