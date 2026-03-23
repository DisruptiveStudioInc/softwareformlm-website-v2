<?php

return [
  'app' => [
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
    'url' => $_ENV['APP_URL'] ?? 'https://staging.softwareformlm.com',
  ],

  'languages' => [
    'default' => 'en',
    'available' => ['es', 'en'],
    'names' => [
      'es' => 'Esp',
      'en' => 'Eng'
    ]
  ],
];
