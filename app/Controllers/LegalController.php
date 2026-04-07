<?php

namespace App\Controllers;

use App\Request;
use App\Response;

class LegalController extends BaseController
{
  private function renderLegalPage(string $template, ?string $metaDescription = null, ?string $legalPageKey = null): Response
  {
    return $this->view($template, [
      'includeTracking' => true,
      'metaDescription' => $metaDescription,
      'legalPageKey' => $legalPageKey,
    ]);
  }

  public function privacy(Request $request): Response
  {
    return $this->renderLegalPage('privacy');
  }

  public function terms(Request $request): Response
  {
    return $this->renderLegalPage('terms');
  }

  public function cookies(Request $request): Response
  {
    return $this->renderLegalPage('legal-static', 'Cookies Policy', 'cookies');
  }

  public function refunds(Request $request): Response
  {
    return $this->renderLegalPage('legal-static', 'Refund Policy', 'refunds');
  }

  public function complianceUse(Request $request): Response
  {
    return $this->renderLegalPage('legal-static', 'Acceptable Use', 'compliance-use');
  }

  public function compliancePolicy(Request $request): Response
  {
    return $this->renderLegalPage('legal-static', 'Compliance Policy', 'compliance-policy');
  }

  public function complianceRisk(Request $request): Response
  {
    return $this->renderLegalPage('legal-static', 'Risk Disclosure', 'compliance-risk');
  }

  public function complianceSecurity(Request $request): Response
  {
    return $this->renderLegalPage('legal-static', 'Security', 'compliance-security');
  }

  public function platformSla(Request $request): Response
  {
    return $this->renderLegalPage('legal-static', 'Service Level Agreement', 'platform-sla');
  }

  public function platformIp(Request $request): Response
  {
    return $this->renderLegalPage('legal-static', 'Intellectual Property', 'platform-ip');
  }

  public function platformCopyright(Request $request): Response
  {
    return $this->renderLegalPage('legal-static', 'Copyright Policy', 'platform-copyright');
  }

  public function technologyArchitecture(Request $request): Response
  {
    return $this->renderLegalPage('legal-static', 'Security Architecture', 'technology-architecture');
  }
}
