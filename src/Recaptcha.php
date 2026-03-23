<?php

namespace App;

class Recaptcha
{
  private string $secretKey;
  private float $scoreThreshold;
  private const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

  public function __construct(array $config)
  {
    $this->secretKey = $config['secret_key'];
    $this->scoreThreshold = $config['score_threshold'];
  }

  public function verify(string $token, ?string $action = null): array
  {
    $data = [
      'secret' => $this->secretKey,
      'response' => $token,
    ];

    if (!empty($_SERVER['REMOTE_ADDR'])) {
      $data['remoteip'] = $_SERVER['REMOTE_ADDR'];
    }

    $options = [
      'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
      ],
    ];

    $context = stream_context_create($options);
    $response = file_get_contents(self::VERIFY_URL, false, $context);

    if ($response === false) {
      return [
        'success' => false,
        'error' => 'Failed to verify reCAPTCHA',
      ];
    }

    $result = json_decode($response, true);

    // Check if verification was successful
    if (!isset($result['success']) || !$result['success']) {
      return [
        'success' => false,
        'error' => 'reCAPTCHA verification failed',
        'error-codes' => $result['error-codes'] ?? [],
      ];
    }

    // Check score threshold
    $score = $result['score'] ?? 0;
    if ($score < $this->scoreThreshold) {
      return [
        'success' => false,
        'error' => 'reCAPTCHA score too low',
        'score' => $score,
      ];
    }

    // Check action if provided
    if ($action !== null && isset($result['action']) && $result['action'] !== $action) {
      return [
        'success' => false,
        'error' => 'reCAPTCHA action mismatch',
      ];
    }

    return [
      'success' => true,
      'score' => $score,
      'action' => $result['action'] ?? null,
    ];
  }

  public function isValid(string $token, ?string $action = null): bool
  {
    $result = $this->verify($token, $action);
    return $result['success'];
  }
}
