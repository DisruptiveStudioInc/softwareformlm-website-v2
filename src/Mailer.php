<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
  private PHPMailer $mailer;
  private array $config;

  public function __construct(array $config)
  {
    $this->config = $config;
    $this->mailer = new PHPMailer(true);
    $this->configure();
  }

  private function configure(): void
  {
    $this->mailer->isSMTP();
    $this->mailer->Host = $this->config['host'];
    $this->mailer->SMTPAuth = true;
    $this->mailer->Username = $this->config['username'];
    $this->mailer->Password = $this->config['password'];
    $this->mailer->SMTPSecure = $this->config['encryption'];
    $this->mailer->Port = $this->config['port'];
    $this->mailer->CharSet = 'UTF-8';

    $this->mailer->setFrom(
      $this->config['from']['address'],
      $this->config['from']['name']
    );
  }

  public function send(string $subject, string $body, ?string $recipientEmail = null, ?string $recipientName = null): bool
  {
    try {
      $this->mailer->clearAddresses();
      $this->mailer->clearAttachments();

      $email = $recipientEmail ?? $this->config['to'];
      $this->mailer->addAddress($email, $recipientName ?? '');

      $this->mailer->isHTML(true);
      $this->mailer->Subject = $subject;
      $this->mailer->Body = $body;
      $this->mailer->AltBody = strip_tags($body);

      return $this->mailer->send();
    } catch (Exception $e) {
      error_log("Mailer Error: {$this->mailer->ErrorInfo}");
      return false;
    }
  }

  public function sendContactForm(array $data): bool
  {
    $subject = "Nuevo mensaje de contacto - {$data['name']}";

    $body = "
      <h2>Nuevo mensaje de contacto</h2>
      <p><strong>Nombre:</strong> {$data['name']}</p>
      <p><strong>Email:</strong> {$data['email']}</p>
      <p><strong>Teléfono:</strong> " . ($data['phone'] ?? 'No proporcionado') . "</p>
      <p><strong>Mensaje:</strong></p>
      <p>{$data['message']}</p>
    ";

    return $this->send($subject, $body);
  }
}
