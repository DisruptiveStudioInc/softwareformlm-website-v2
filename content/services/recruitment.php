<?php

use App\Models\Language;
$csLang = Language::getCurrentLanguage();
$sKey = "recruitment.{$csLang}";

return [
  'hero' => Language::trans("{$sKey}.hero.title"),
  'hero_text' => Language::trans("{$sKey}.hero.text"),
  'hero_images' => [
    'big' => 'reclutamiento_1_big.webp',
    'small' => 'reclutamiento_1_small.webp'
  ],
  'about1_title' => Language::trans("{$sKey}.about1"),
  'about1_images' => [
    'front' => 'reclutamiento_2_front.webp',
    'back' => 'reclutamiento_2_back.webp'
  ],
  'about2_title' => Language::trans("{$sKey}.about2"),
  'about2_text' => Language::trans("{$sKey}.about2_text"),
  'about2_images' => [
    'big' => 'reclutamiento_3_big.webp',
    'mid' => 'reclutamiento_3_mid.webp',
    'small' => 'reclutamiento_3_small.webp'
  ],
  'benefits' => [
    [
      'image' => 'reclutamiento-hiring',
      'title' => Language::trans("{$sKey}.benefits.item1.title"),
      'text' => Language::trans("{$sKey}.benefits.item1.text"),
    ],
    [
      'image' => 'reclutamiento-selection',
      'title' => Language::trans("{$sKey}.benefits.item2.title"),
      'text' => Language::trans("{$sKey}.benefits.item2.text"),
    ],
    [
      'image' => 'reclutamiento-turnover',
      'title' => Language::trans("{$sKey}.benefits.item3.title"),
      'text' => Language::trans("{$sKey}.benefits.item3.text"),
    ],
    [
      'image' => 'reclutamiento-talent',
      'title' => Language::trans("{$sKey}.benefits.item4.title"),
      'text' => Language::trans("{$sKey}.benefits.item4.text"),
    ],
    [
      'image' => 'reclutamiento-savings',
      'title' => Language::trans("{$sKey}.benefits.item5.title"),
      'text' => Language::trans("{$sKey}.benefits.item5.text"),
    ],
    [
      'image' => 'reclutamiento-recruitment',
      'title' => Language::trans("{$sKey}.benefits.item6.title"),
      'text' => Language::trans("{$sKey}.benefits.item6.text"),
    ],
  ],
  'process_title' => Language::trans("{$sKey}.process.title"),
  'processes' => [
    [
      'image' => 'reclutamiento_5-1.webp',
      'title' => Language::trans("{$sKey}.process.item1.title"),
      'text' => Language::trans("{$sKey}.process.item1.text")
    ],
    [
      'image' => 'reclutamiento_5-2.webp',
      'title' => Language::trans("{$sKey}.process.item2.title"),
      'text' => Language::trans("{$sKey}.process.item2.text")
    ],
    [
      'image' => 'reclutamiento_5-3.webp',
      'title' => Language::trans("{$sKey}.process.item3.title"),
      'text' => Language::trans("{$sKey}.process.item3.text")
    ],
    [
      'image' => 'reclutamiento_5-4.webp',
      'title' => Language::trans("{$sKey}.process.item4.title"),
      'text' => Language::trans("{$sKey}.process.item4.text")
    ],
    [
      'image' => 'reclutamiento_5-5.webp',
      'title' => Language::trans("{$sKey}.process.item5.title"),
      'text' => Language::trans("{$sKey}.process.item5.text")
    ]
  ],
  'faq' => [
    [
      'question' => Language::trans("{$sKey}.faq.question1"),
      'answer' => Language::trans("{$sKey}.faq.answer1")
    ],
    [
      'question' => Language::trans("{$sKey}.faq.question2"),
      'answer' => Language::trans("{$sKey}.faq.answer2")
    ],
    [
      'question' => Language::trans("{$sKey}.faq.question3"),
      'answer' => Language::trans("{$sKey}.faq.answer3")
    ],
    [
      'question' => Language::trans("{$sKey}.faq.question4"),
      'answer' => Language::trans("{$sKey}.faq.answer4")
    ],
    [
      'question' => Language::trans("{$sKey}.faq.question5"),
      'answer' => Language::trans("{$sKey}.faq.answer5")
    ],
    [
      'question' => Language::trans("{$sKey}.faq.question6"),
      'answer' => Language::trans("{$sKey}.faq.answer6")
    ]
  ],
  'sales' => [
    'title' => Language::trans("{$sKey}.sales.title"),
    'text' => Language::trans("{$sKey}.sales.text")
  ],
  'sales_images' => [
    'big' => 'reclutamiento_7_big.webp',
    'small' => 'reclutamiento_7_small.webp'
  ]
];
