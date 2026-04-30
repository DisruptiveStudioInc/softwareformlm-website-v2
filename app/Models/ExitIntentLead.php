<?php

namespace App\Models;

class ExitIntentLead
{
  private array $data;
  private array $errors = [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  public function validate(): bool
  {
    $this->errors = [];

    if (empty($this->data['name']) || trim($this->data['name']) === '') {
      $this->errors['name'] = Language::trans('contact.validation.name_required');
    }

    if (empty($this->data['email']) || trim($this->data['email']) === '') {
      $this->errors['email'] = Language::trans('contact.validation.email_required');
    } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
      $this->errors['email'] = Language::trans('contact.validation.email_invalid');
    }

    return empty($this->errors);
  }

  public function getErrors(): array
  {
    return $this->errors;
  }

  public function toHighLevelPayload(): array
  {
    $name = $this->sanitize($this->data['name'] ?? '');
    [$firstName, $lastName] = $this->splitName($name);

    return [
      'firstName' => $firstName,
      'lastName' => $lastName,
      'name' => $name,
      'email' => $this->sanitize($this->data['email'] ?? ''),
      'phone' => $this->sanitize($this->data['phone'] ?? ''),
      'source' => $this->sanitize($this->data['source'] ?? 'exit_intent_popup'),
      'language' => $this->sanitize($this->data['language'] ?? ''),
      'pagePath' => $this->sanitize($this->data['page_path'] ?? ''),
    ];
  }

  private function splitName(string $name): array
  {
    $parts = preg_split('/\s+/', trim($name)) ?: [];

    if (count($parts) <= 1) {
      return [$name, ''];
    }

    $firstName = array_shift($parts);
    $lastName = implode(' ', $parts);

    return [$firstName, $lastName];
  }

  private function sanitize(string $value): string
  {
    return trim(strip_tags($value));
  }
}
