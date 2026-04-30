<?php

namespace App\Services;

use GuzzleHttp\Client;
use RuntimeException;

class HighLevelClient
{
  private Client $client;
  private string $locationId;

  public function __construct(array $config)
  {
    $baseUrl = rtrim($config['base_url'] ?? '', '/');
    $apiToken = $config['api_token'] ?? '';
    $apiVersion = $config['api_version'] ?? '';
    $this->locationId = $config['location_id'] ?? '';

    if ($baseUrl === '' || $apiToken === '' || $apiVersion === '' || $this->locationId === '') {
      throw new RuntimeException('GoHighLevel configuration is incomplete');
    }

    $this->client = new Client([
      'base_uri' => $baseUrl . '/',
      'timeout' => 10,
      'connect_timeout' => 5,
      'http_errors' => false,
      'headers' => [
        'Authorization' => 'Bearer ' . $apiToken,
        'Version' => $apiVersion,
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
      ],
    ]);
  }

  public function upsertExitIntentLead(array $data): array
  {
    $payload = [
      'locationId' => $this->locationId,
      'firstName' => $data['firstName'] ?? '',
      'lastName' => $data['lastName'] ?? '',
      'name' => $data['name'] ?? '',
      'email' => $data['email'] ?? '',
      'phone' => $data['phone'] ?? '',
      'source' => 'softwareformlm_exit_intent_popup',
      'tags' => [
        'website',
        'exit_intent_popup',
      ],
    ];

    $response = $this->client->post('contacts/upsert', [
      'json' => $payload,
    ]);

    $statusCode = $response->getStatusCode();
    $body = (string) $response->getBody();
    $decoded = $body !== '' ? json_decode($body, true) : null;

    if ($statusCode < 200 || $statusCode >= 300) {
      throw new RuntimeException('GoHighLevel upsert failed with status ' . $statusCode . ': ' . $body);
    }

    return is_array($decoded) ? $decoded : [];
  }
}
