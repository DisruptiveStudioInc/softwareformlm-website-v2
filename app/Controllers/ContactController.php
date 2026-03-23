<?php

namespace App\Controllers;

use App\Request;
use App\Response;
use App\Models\Contact;
use App\Models\Language;
use App\Mailer;
use App\Recaptcha;

class ContactController extends BaseController
{
  public function index(Request $request): Response
  {
    // Load page content
    $pageContent = $this->loadPageContent('contact');

    return $this->view('contact', [
      'includeRecaptcha' => true,
      'content' => $pageContent,
      'metaDescription' => $pageContent['seoDescription'] ?? null
    ]);
  }

  public function submit(Request $request): Response
  {
    if (!$request->isPost()) {
      return $this->json(['success' => false, 'error' => 'Invalid request'], 405);
    }

    // Validate reCAPTCHA
    $recaptchaToken = $request->getPost('recaptcha_token');
    if (empty($recaptchaToken)) {
      return $this->json([
        'success' => false,
        'error' => Language::trans('contact.validation.recaptcha_failed'),
      ], 400);
    }

    $recaptcha = new Recaptcha($this->config['recaptcha']);
    $recaptchaResult = $recaptcha->verify($recaptchaToken, 'contact');

    if (!$recaptchaResult['success']) {
      return $this->json([
        'success' => false,
        'error' => Language::trans('contact.validation.recaptcha_failed'),
      ], 400);
    }

    // Validate form data
    $contact = new Contact($request->getPost());

    if (!$contact->validate()) {
      return $this->json([
        'success' => false,
        'errors' => $contact->getErrors(),
      ], 400);
    }

    // Send email
    $mailer = new Mailer($this->config['mail']);
    $emailSent = $mailer->sendContactForm($contact->getData());

    if (!$emailSent) {
      return $this->json([
        'success' => false,
        'error' => Language::trans('contact.error'),
      ], 500);
    }

    return $this->json([
      'success' => true,
      'message' => Language::trans('contact.success'),
    ]);
  }
}
