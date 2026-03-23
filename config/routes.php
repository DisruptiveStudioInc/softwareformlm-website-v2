<?php

use App\Router;

return function(Router $router) {
  // Home
  $router->get('/', 'App\\Controllers\\HomeController', 'index');

  // Contact
  // $router->get('/contacto', 'App\\Controllers\\ContactController', 'index');
  // $router->get('/contact', 'App\\Controllers\\ContactController', 'index');
  // $router->post('/contacto', 'App\\Controllers\\ContactController', 'submit');
  // $router->post('/contact', 'App\\Controllers\\ContactController', 'submit');

  $router->get('/privacy-policy', 'App\\Controllers\\LegalController', 'privacy');
  $router->get('/politica-de-privacidad', 'App\\Controllers\\LegalController', 'privacy');
  $router->get('/terms-and-conditions', 'App\\Controllers\\LegalController', 'terms');
  $router->get('/terminos-y-condiciones', 'App\\Controllers\\LegalController', 'terms');

  // Blog
  $router->get('/blog', 'App\\Controllers\\BlogController', 'index');
  $router->get('/blog/{slug}', 'App\\Controllers\\BlogController', 'show');

  // Blog cache clear (optional - for webhook)
  $router->post('/blog/cache/clear', 'App\\Controllers\\BlogController', 'clearCache');

  // Services - dynamic route with slug (keep this last as it's a catch-all)
  // $router->get('/{slug}', 'App\\Controllers\\ServiceController', 'show');
};
