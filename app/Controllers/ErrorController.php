<?php

namespace App\Controllers;

use App\Request;
use App\Response;

class ErrorController extends BaseController
{
  public function notFound(Request $request): Response
  {
    $response = $this->view('404');
    $response->setStatusCode(404);
    return $response;
  }
}
