<?php

namespace App\Controllers;

use App\Request;
use App\Response;
use App\Models\Service;

class ServiceController extends BaseController
{
  public function show(Request $request): Response
  {
    $uri = $request->getUri();

    // Extract slug from URI (remove language prefix if present)
    $slug = trim($uri, '/');
    if ($this->language !== 'en') {
      $slug = str_replace($this->language . '/', '', $slug);
    }

    // Find service by slug
    $service = Service::findBySlug($slug, $this->language);

    if ($service === null) {
      // Service not found - return 404
      $errorController = new ErrorController();
      $errorController->setLanguage($this->language);
      return $errorController->notFound($request);
    }

    // Render the appropriate template
    return $this->view($service['template'], [
      'service' => $service,
      'meta' => $service['meta'],
      'content' => $service['content'],
      'hasSnapScroll' => false
    ]);
  }
}
