<?php

namespace App\Services;

use GuzzleHttp\Client;
use RuntimeException;

class HighLevelClient
{
  private Client $client;
  private string $locationId;
  private array $exitIntentConfig;

  public function __construct(array $config)
  {
    $baseUrl = rtrim($config['base_url'] ?? '', '/');
    $apiToken = $config['api_token'] ?? '';
    $apiVersion = $config['api_version'] ?? '';
    $this->locationId = $config['location_id'] ?? '';

    if ($baseUrl === '' || $apiToken === '' || $apiVersion === '' || $this->locationId === '') {
      throw new RuntimeException('GoHighLevel configuration is incomplete');
    }

    $this->exitIntentConfig = $config['exit_intent'] ?? [];

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
      'source' => $this->exitIntentConfig['source'] ?? ($data['source'] ?? 'softwareformlm_exit_popup'),
      'tags' => $this->exitIntentConfig['tags'] ?? ['website', 'exit_popup'],
    ];

    $contactCountry = trim((string) ($data['country'] ?? ''));
    if ($this->isValidContactCountry($contactCountry)) {
      $payload['country'] = $contactCountry;
    }

    $customFields = $this->buildCustomFields($data);
    if ($customFields !== []) {
      $payload['customFields'] = $customFields;
    }

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

  private function isValidContactCountry(string $country): bool
  {
    return preg_match('/^[A-Z]{2}$/', $country) === 1;
  }

  private function buildCustomFields(array $data): array
  {
    $fieldMappings = $this->exitIntentConfig['custom_fields'] ?? [];
    $configuredValues = $this->exitIntentConfig['custom_field_values'] ?? [];
    $valuesByField = [
      'campaign_medium' => $this->resolveCustomFieldValue(
        $configuredValues['campaign_medium'] ?? '',
        $data['campaignMedium'] ?? ''
      ),
      'campaign_name' => $this->resolveCustomFieldValue(
        $configuredValues['campaign_name'] ?? '',
        $data['campaignName'] ?? ''
      ),
      'campaign_source' => $this->resolveCustomFieldValue(
        $configuredValues['campaign_source'] ?? '',
        $data['campaignSource'] ?? ''
      ),
      'ad_id' => $this->resolveCustomFieldValue(
        $configuredValues['ad_id'] ?? '',
        $data['adId'] ?? ''
      ),
      'campaign_content' => $this->resolveCustomFieldValue(
        $configuredValues['campaign_content'] ?? '',
        $data['campaignContent'] ?? ''
      ),
      'country' => $data['country'] ?? '',
    ];

    $customFields = [];

    foreach ($valuesByField as $fieldName => $fieldValue) {
      $rawFieldMapping = $fieldMappings[$fieldName] ?? '';
      $fieldReference = $this->normalizeCustomFieldReference($rawFieldMapping);

      if ($rawFieldMapping !== '' && $fieldReference === null) {
        error_log(sprintf(
          'Skipping invalid GoHighLevel custom field mapping for %s. Expected a custom field ID or field key.',
          $fieldName
        ));
      }

      if ($fieldReference === null || $fieldValue === '') {
        continue;
      }

      $customField = [
        'field_value' => $fieldValue,
      ];

      if ($fieldReference['type'] === 'id') {
        $customField['id'] = $fieldReference['value'];
      } else {
        $customField['key'] = $fieldReference['value'];
      }

      $customFields[] = $customField;
    }

    return $customFields;
  }

  private function resolveCustomFieldValue(mixed $configuredValue, mixed $fallbackValue): string
  {
    $preferredValue = trim((string) $configuredValue);
    if ($preferredValue !== '') {
      return $preferredValue;
    }

    return trim((string) $fallbackValue);
  }

  private function normalizeCustomFieldReference(mixed $value): ?array
  {
    $fieldReference = trim((string) $value);
    if ($fieldReference === '') {
      return null;
    }

    if (str_starts_with($fieldReference, 'id:')) {
      $fieldId = substr($fieldReference, 3);

      return $this->isLikelyCustomFieldId($fieldId)
        ? ['type' => 'id', 'value' => $fieldId]
        : null;
    }

    if (str_starts_with($fieldReference, 'key:')) {
      $fieldKey = substr($fieldReference, 4);

      return $this->isLikelyCustomFieldKey($fieldKey)
        ? ['type' => 'key', 'value' => $fieldKey]
        : null;
    }

    if ($this->isLikelyCustomFieldId($fieldReference)) {
      return ['type' => 'id', 'value' => $fieldReference];
    }

    if ($this->isLikelyCustomFieldKey($fieldReference)) {
      return ['type' => 'key', 'value' => $fieldReference];
    }

    return null;
  }

  private function isLikelyCustomFieldId(string $value): bool
  {
    return preg_match('/^[A-Za-z0-9]{15,}$/', $value) === 1;
  }

  private function isLikelyCustomFieldKey(string $value): bool
  {
    return preg_match('/^[A-Za-z0-9._-]{2,}$/', $value) === 1;
  }
}
