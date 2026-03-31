<?php

use App\Router;

return function(Router $router) {
  // Home
  $router->get('/', 'App\\Controllers\\HomeController', 'index');
  $router->get('/zoom-demo-redirect', 'App\\Controllers\\RedirectController', 'zoomDemoRedirect');

  // Contact
  // $router->get('/contacto', 'App\\Controllers\\ContactController', 'index');
  // $router->get('/contact', 'App\\Controllers\\ContactController', 'index');
  // $router->post('/contacto', 'App\\Controllers\\ContactController', 'submit');
  // $router->post('/contact', 'App\\Controllers\\ContactController', 'submit');

  $router->get('/privacy-policy', 'App\\Controllers\\LegalController', 'privacy');
  $router->get('/politica-de-privacidad', 'App\\Controllers\\LegalController', 'privacy');
  $router->get('/terms-and-conditions', 'App\\Controllers\\LegalController', 'terms');
  $router->get('/terminos-y-condiciones', 'App\\Controllers\\LegalController', 'terms');
  $router->get('/cookies-policy', 'App\\Controllers\\LegalController', 'cookies');
  $router->get('/politica-de-cookies', 'App\\Controllers\\LegalController', 'cookies');
  $router->get('/refund-policy', 'App\\Controllers\\LegalController', 'refunds');
  $router->get('/politica-de-reembolsos', 'App\\Controllers\\LegalController', 'refunds');
  $router->get('/acceptable-use', 'App\\Controllers\\LegalController', 'complianceUse');
  $router->get('/uso-aceptable', 'App\\Controllers\\LegalController', 'complianceUse');
  $router->get('/compliance-policy', 'App\\Controllers\\LegalController', 'compliancePolicy');
  $router->get('/politica-de-cumplimiento', 'App\\Controllers\\LegalController', 'compliancePolicy');
  $router->get('/risk-disclosure', 'App\\Controllers\\LegalController', 'complianceRisk');
  $router->get('/divulgacion-de-riesgos', 'App\\Controllers\\LegalController', 'complianceRisk');
  $router->get('/security', 'App\\Controllers\\LegalController', 'complianceSecurity');
  $router->get('/seguridad', 'App\\Controllers\\LegalController', 'complianceSecurity');
  $router->get('/sla', 'App\\Controllers\\LegalController', 'platformSla');
  $router->get('/intellectual-property', 'App\\Controllers\\LegalController', 'platformIp');
  $router->get('/propiedad-intelectual', 'App\\Controllers\\LegalController', 'platformIp');
  $router->get('/copyright', 'App\\Controllers\\LegalController', 'platformCopyright');
  $router->get('/derechos-de-autor', 'App\\Controllers\\LegalController', 'platformCopyright');
  $router->get('/security-architecture', 'App\\Controllers\\LegalController', 'technologyArchitecture');
  $router->get('/arquitectura-de-seguridad', 'App\\Controllers\\LegalController', 'technologyArchitecture');

  // Blog
  $router->get('/blog', 'App\\Controllers\\BlogController', 'index');
  $router->get('/blog/{slug}', 'App\\Controllers\\BlogController', 'show');

  // Blog cache clear (optional - for webhook)
  $router->post('/blog/cache/clear', 'App\\Controllers\\BlogController', 'clearCache');

  // Services - dynamic route with slug (keep this last as it's a catch-all)
  // $router->get('/{slug}', 'App\\Controllers\\ServiceController', 'show');
};
