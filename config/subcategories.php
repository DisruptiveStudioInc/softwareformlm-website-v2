<?php

/**
 * Service subcategories with translations
 * Used for megamenu labels
 */

use App\Models\Language;

return [
  'blockchain' => [
    'es' => 'Blockchain',
    'en' => 'Blockchain',
    'description' => Language::trans('servsub.blockchain')
  ],
  'custom-software' => [
    'es' => 'Servicios personalizados',
    'en' => 'Custom services',
    'description' => Language::trans('servsub.custom_software')
  ],
  'payment-processing' => [
    'es' => 'Procesamiento de pagos',
    'en' => 'Payment processing',
    'description' => Language::trans('servsub.payment_processing')
  ],
  'referral-marketing' => [
    'es' => 'Marketing de referidos',
    'en' => 'Referral marketing',
    'description' => Language::trans('servsub.referral_marketing')
  ],
  'creative-services' => [
    'es' => 'Servicios creativos',
    'en' => 'Creative services',
    'description' => Language::trans('servsub.creative_services')
  ],
  'hr' => [
    'es' => 'RR. HH.',
    'en' => 'HR',
    'description' => Language::trans('servsub.hr')
  ],
  'manufacturing' => [
    'es' => 'Servicios de manufactura',
    'en' => 'Manufacturing services',
    'description' => Language::trans('servsub.manufacturing')
  ],
  'customer-support' => [
    'es' => 'Servicios de CS',
    'en' => 'CS Services',
    'description' => Language::trans('servsub.cs')
  ],
  'legal-services' => [
    'es' => 'Servicios legales',
    'en' => 'Legal and compliance services',
    'description' => Language::trans('servsub.legal_services')
  ],
  'logistics' => [
    'es' => 'Servicios de logística',
    'en' => 'Logistic services',
    'description' => Language::trans('servsub.logistic_services')
  ],
  'finance' => [
    'es' => 'Servicios financieros',
    'en' => 'Financial services',
    'description' => Language::trans('servsub.finance_services')
  ]
];
