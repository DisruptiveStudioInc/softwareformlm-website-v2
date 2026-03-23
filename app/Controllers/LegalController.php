<?php

namespace App\Controllers;

use App\Request;
use App\Response;

class LegalController extends BaseController
{
  public function privacy(Request $request): Response
  {
    // Load page content
    // $pageContent = $this->loadPageContent('privacy');

    return $this->view('privacy', [
      // 'content' => $pageContent,
      'metaDescription' => $pageContent['seoDescription'] ?? null
    ]);
  }

  public function terms(Request $request): Response
  {
    // Load page content
    // $pageContent = $this->loadPageContent('terms');

    return $this->view('terms', [
      // 'content' => $pageContent,
      'metaDescription' => $pageContent['seoDescription'] ?? null
    ]);
  }
}
