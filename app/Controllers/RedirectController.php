<?php

namespace App\Controllers;

use App\Request;
use App\Response;

class RedirectController extends BaseController
{
  public function zoomDemoRedirect(Request $request): Response
  {
    return $this->view('zoom-demo-redirect', [
      'pageTitle' => 'Zoom Demo Redirect',
      'redirectUrl' => 'https://disr.vip/demo',
      'redirectDelayMs' => 200,
      'metaRefreshSeconds' => 1,
    ]);
  }

  public function calendarDemoRedirect(Request $request): Response
  {
    return $this->view('calendar-demo-redirect', [
      'pageTitle' => 'Calendar Demo Redirect',
      'redirectUrl' => 'https://disr.vip/calendar',
      'redirectDelayMs' => 200,
      'metaRefreshSeconds' => 1,
    ]);
  }
}
