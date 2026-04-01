<?php

namespace App\Controllers;

use App\Request;
use App\Response;

class RedirectController extends BaseController
{
  public function zoomDemoRedirect(Request $request): Response
  {
    return $this->view('demo-redirect', [
      'pageTitle' => 'Zoom Demo Redirect',
      'eventName' => 'zoom_demo_redirect',
      'redirectUrl' => 'https://disr.vip/demo',
      'redirectDelayMs' => 200,
      'metaRefreshSeconds' => 1,
    ]);
  }

  public function calendarDemoRedirect(Request $request): Response
  {
    return $this->view('demo-redirect', [
      'pageTitle' => 'Calendar Demo Redirect',
      'eventName' => 'calendar_demo_redirect',
      'redirectUrl' => 'https://disr.vip/calendar',
      'redirectDelayMs' => 200,
      'metaRefreshSeconds' => 1,
    ]);
  }
}
