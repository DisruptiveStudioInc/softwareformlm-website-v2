<?php

namespace App\Models;

class Contact
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

    // Name validation
    if (empty($this->data['name']) || trim($this->data['name']) === '') {
      $this->errors['name'] = Language::trans('contact.validation.name_required');
    }

    // Email validation
    if (empty($this->data['email']) || trim($this->data['email']) === '') {
      $this->errors['email'] = Language::trans('contact.validation.email_required');
    } elseif (!filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
      $this->errors['email'] = Language::trans('contact.validation.email_invalid');
    }

    // Message validation
    if (empty($this->data['message']) || trim($this->data['message']) === '') {
      $this->errors['message'] = Language::trans('contact.validation.message_required');
    }

    return empty($this->errors);
  }

  public function getErrors(): array
  {
    return $this->errors;
  }

  public function getData(): array
  {
    return [
      'name' => $this->sanitize($this->data['name'] ?? ''),
      'email' => $this->sanitize($this->data['email'] ?? ''),
      'phone' => $this->sanitize($this->data['phone'] ?? ''),
      'message' => $this->sanitize($this->data['message'] ?? ''),
    ];
  }

  private function sanitize(string $value): string
  {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
  }
}
