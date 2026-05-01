<?php

namespace App\Controllers;

use App\Request;
use App\Response;
use App\Models\ExitIntentLead;
use App\Models\Language;
use App\Recaptcha;
use App\Services\HighLevelClient;
use Throwable;

class ExitIntentController extends BaseController
{
  public function submit(Request $request): Response
  {
    if (!$request->isPost()) {
      return $this->json(['success' => false, 'error' => 'Invalid request'], 405);
    }

    $recaptchaToken = $request->getPost('recaptcha_token');
    if (empty($recaptchaToken)) {
      return $this->json([
        'success' => false,
        'error' => Language::trans('contact.validation.recaptcha_failed'),
      ], 400);
    }

    $recaptcha = new Recaptcha($this->config['recaptcha']);
    $recaptchaResult = $recaptcha->verify($recaptchaToken, 'exit_intent');

    if (!$recaptchaResult['success']) {
      return $this->json([
        'success' => false,
        'error' => Language::trans('contact.validation.recaptcha_failed'),
      ], 400);
    }

    $leadData = $request->getPost();
    $leadData['country'] = $this->resolveCountry($request);

    $lead = new ExitIntentLead($leadData);

    if (!$lead->validate()) {
      return $this->json([
        'success' => false,
        'errors' => $lead->getErrors(),
      ], 400);
    }

    try {
      $client = new HighLevelClient($this->config['gohighlevel']);
      $client->upsertExitIntentLead($lead->toHighLevelPayload());
    } catch (Throwable $error) {
      error_log('Exit intent submit error: ' . $error->getMessage());

      return $this->json([
        'success' => false,
        'error' => Language::trans('exit_popup.error'),
      ], 500);
    }

    return $this->json([
      'success' => true,
      'message' => Language::trans('exit_popup.success'),
    ]);
  }

  private function resolveCountry(Request $request): string
  {
    $countryCode = strtoupper(trim((string) $request->getHeader('CF-IPCountry', '')));

    if ($countryCode !== '' && $countryCode !== 'XX' && $countryCode !== 'T1') {
      return $countryCode;
    }

    $appEnv = strtolower((string) ($this->config['app']['env'] ?? 'production'));
    if (in_array($appEnv, ['local', 'development', 'dev', 'test', 'testing'], true)) {
      return 'Local';
    }

    return '';
  }
}
