<?php

use App\Models\Language;
$csLang = Language::getCurrentLanguage();
$sKey = "client_support.{$csLang}";

return [
  'hero' => Language::trans("{$sKey}.hero.title"),
  'hero_text' => Language::trans("{$sKey}.hero.text"),
  'hero_images' => [
    'big' => 'support_1_big.webp',
    'small' => 'support_1_small.webp'
  ],
  'about1_title' => Language::trans("{$sKey}.about1"),
  'about1_images' => [
    'front' => 'support_2_front.webp',
    'back' => 'support_2_back.webp'
  ],
  'about2_title' => Language::trans("{$sKey}.about2"),
  'about2_text' => Language::trans("{$sKey}.about2_text"),
  'about2_images' => [
    'big' => 'support_3_big.webp',
    'mid' => 'support_3_mid.webp',
    'small' => 'support_3_small.webp'
  ],
  'benefits' => [
    [
      'image' => 'support-multichannel',
      'title' => Language::trans("{$sKey}.benefits.item1.title"),
      'text' => Language::trans("{$sKey}.benefits.item1.text"),
    ],
    [
      'image' => 'support-resolution',
      'title' => Language::trans("{$sKey}.benefits.item2.title"),
      'text' => Language::trans("{$sKey}.benefits.item2.text"),
    ],
    [
      'image' => 'support-continuous',
      'title' => Language::trans("{$sKey}.benefits.item3.title"),
      'text' => Language::trans("{$sKey}.benefits.item3.text"),
    ],
    [
      'image' => 'support-scale',
      'title' => Language::trans("{$sKey}.benefits.item4.title"),
      'text' => Language::trans("{$sKey}.benefits.item4.text"),
    ],
    [
      'image' => 'support-experience',
      'title' => Language::trans("{$sKey}.benefits.item5.title"),
      'text' => Language::trans("{$sKey}.benefits.item5.text"),
    ],
    [
      'image' => 'support-reporting',
      'title' => Language::trans("{$sKey}.benefits.item6.title"),
      'text' => Language::trans("{$sKey}.benefits.item6.text"),
    ],
  ],
  'process_title' => Language::trans("{$sKey}.development.title"),
  'processes' => [
    [
      'image' => 'support_s1.webp',
      'title' => Language::trans("{$sKey}.development.item1.title"),
      'text' => Language::trans("{$sKey}.development.item1.text")
    ],
    [
      'image' => 'support_s2.webp',
      'title' => Language::trans("{$sKey}.development.item2.title"),
      'text' => Language::trans("{$sKey}.development.item2.text")
    ],
    [
      'image' => 'support_s3.webp',
      'title' => Language::trans("{$sKey}.development.item3.title"),
      'text' => Language::trans("{$sKey}.development.item3.text")
    ],
    [
      'image' => 'support_s4.webp',
      'title' => Language::trans("{$sKey}.development.item4.title"),
      'text' => Language::trans("{$sKey}.development.item4.text")
    ],
    [
      'image' => 'support_s5.webp',
      'title' => Language::trans("{$sKey}.development.item5.title"),
      'text' => Language::trans("{$sKey}.development.item5.text")
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
    'big' => 'support_7_big.webp',
    'small' => 'support_7_small.webp'
  ]
];
