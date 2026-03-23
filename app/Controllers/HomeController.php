<?php

namespace App\Controllers;

use App\Request;
use App\Response;
use App\Models\Service;

class HomeController extends BaseController
{
  public function index(Request $request): Response
  {
    // Load page content
    $pageContent = $this->loadPageContent('home');

    // Get all services for displaying in home page if needed
    $services = Service::getAll($this->language);
    $ecosystem = Service::getByCategory('ecosystem', $this->language);
    $subcatServices = getServiceSubcategoryName($this->language);
    $disrIps = Service::getByCategory('ips', $this->language);

    return $this->view('home', [
      'content' => $pageContent,
      'services' => $services,
      'ecosystem' => $ecosystem,
      'subcategories' => $subcatServices,
      'ips' => $disrIps,
      'hasSnapScroll' => true,
      'hasTextTexture' => true,
      'metaDescription' => $pageContent['seoDescription'] ?? null
    ]);
  }
}
