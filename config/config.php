<?php

return [
  'app' => [
    'env' => $_ENV['APP_ENV'] ?? 'production',
    'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
    'url' => $_ENV['APP_URL'] ?? 'https://softwareformlm.com',
  ],

  'mail' => [
    'host' => $_ENV['MAIL_HOST'] ?? '',
    'port' => (int) ($_ENV['MAIL_PORT'] ?? 587),
    'username' => $_ENV['MAIL_USERNAME'] ?? '',
    'password' => $_ENV['MAIL_PASSWORD'] ?? '',
    'encryption' => $_ENV['MAIL_ENCRYPTION'] ?? 'tls',
    'from' => [
      'address' => $_ENV['MAIL_FROM_ADDRESS'] ?? '',
      'name' => $_ENV['MAIL_FROM_NAME'] ?? '',
    ],
    'to' => $_ENV['MAIL_TO_ADDRESS'] ?? '',
  ],

  'recaptcha' => [
    'site_key' => $_ENV['RECAPTCHA_SITE_KEY'] ?? '',
    'secret_key' => $_ENV['RECAPTCHA_SECRET_KEY'] ?? '',
    'score_threshold' => (float) ($_ENV['RECAPTCHA_SCORE_THRESHOLD'] ?? 0.5),
  ],

  'gohighlevel' => [
    'base_url' => $_ENV['GHL_BASE_URL'] ?? 'https://services.leadconnectorhq.com',
    'api_version' => $_ENV['GHL_API_VERSION'] ?? '2021-07-28',
    'api_token' => $_ENV['GHL_API_TOKEN'] ?? '',
    'location_id' => $_ENV['GHL_LOCATION_ID'] ?? '',
    'exit_intent' => [
      'source' => $_ENV['GHL_EXIT_INTENT_SOURCE'] ?? 'softwareformlm_exit_popup',
      'tags' => array_values(array_filter(array_map(
        static fn (string $tag): string => trim($tag),
        explode(',', $_ENV['GHL_EXIT_INTENT_TAGS'] ?? 'website,exit_popup')
      ))),
      'custom_fields' => [
        'campaign_medium' => 'FGUsybZUkfrNPerLCYvd',
        'campaign_name' => 'LQKJSrDEtxJnVItZyL64',
        'campaign_source' => 'SZcTeXNiSpl2Tqk9hulc',
        'ad_id' => 'OLpF1SE0sdiBW3r9PsM7',
        'campaign_content' => 'WT5jyXt1XxQXgYvg56xE',
        'country' => 'JxlJuPgiwkbLgBxQhGvA',
      ],
      'custom_field_values' => [
        'campaign_medium' => 'sfmlm-website',
        'campaign_name' => 'sfmlm-prevent-exit',
        'campaign_source' => 'website',
        'ad_id' => 'sfmlm_exit_popup',
        'campaign_content' => 'Website_prevent_user_from_leaving',
      ],
    ],
  ],

  'languages' => [
    'default' => 'es',
    'available' => ['es', 'en'],
    'names' => [
      'es' => 'Esp',
      'en' => 'Eng'
    ]
  ],
];
