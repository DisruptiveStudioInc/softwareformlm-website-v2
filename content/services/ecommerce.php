<?php

use App\Models\Language;
$csLang = Language::getCurrentLanguage();
$sKey = "ecommerce.{$csLang}";

return [
  'hero' => Language::trans("{$sKey}.hero.title"),
  'hero_text' => Language::trans("{$sKey}.hero.text"),
  'hero_images' => [
    'big' => 'ecommerce_1_big.webp',
    'small' => 'ecommerce_1_small.webp'
  ],
  'about1_title' => Language::trans("{$sKey}.about1"),
  'about1_images' => [
    'front' => 'ecommerce_2_front.webp',
    'back' => 'ecommerce_2_back.webp'
  ],
  'about2_title' => Language::trans("{$sKey}.about2"),
  'about2_text' => Language::trans("{$sKey}.about2_text"),
  'about2_images' => [
    'big' => 'ecommerce_3_big.webp',
    'mid' => 'ecommerce_3_mid.webp',
    'small' => 'ecommerce_3_small.webp'
  ],
  'benefits' => [
    [
      'image' => 'ecommerce-centralized',
      'title' => Language::trans("{$sKey}.benefits.item1.title"),
      'text' => Language::trans("{$sKey}.benefits.item1.text"),
    ],
    [
      'image' => 'ecommerce-optimization',
      'title' => Language::trans("{$sKey}.benefits.item2.title"),
      'text' => Language::trans("{$sKey}.benefits.item2.text"),
    ],
    [
      'image' => 'ecommerce-payments',
      'title' => Language::trans("{$sKey}.benefits.item3.title"),
      'text' => Language::trans("{$sKey}.benefits.item3.text"),
    ],
    [
      'image' => 'ecommerce-ux',
      'title' => Language::trans("{$sKey}.benefits.item4.title"),
      'text' => Language::trans("{$sKey}.benefits.item4.text"),
    ],
    [
      'image' => 'ecommerce-analysis',
      'title' => Language::trans("{$sKey}.benefits.item5.title"),
      'text' => Language::trans("{$sKey}.benefits.item5.text"),
    ],
    [
      'image' => 'ecommerce-escale',
      'title' => Language::trans("{$sKey}.benefits.item6.title"),
      'text' => Language::trans("{$sKey}.benefits.item6.text"),
    ],
  ],
  'process_title' => Language::trans("{$sKey}.development.title"),
  'processes' => [
    [
      'image' => 'ecommerce_s1.webp',
      'title' => Language::trans("{$sKey}.development.item1.title"),
      'text' => Language::trans("{$sKey}.development.item1.text")
    ],
    [
      'image' => 'ecommerce_s2.webp',
      'title' => Language::trans("{$sKey}.development.item2.title"),
      'text' => Language::trans("{$sKey}.development.item2.text")
    ],
    [
      'image' => 'ecommerce_s3.webp',
      'title' => Language::trans("{$sKey}.development.item3.title"),
      'text' => Language::trans("{$sKey}.development.item3.text")
    ],
    [
      'image' => 'ecommerce_s4.webp',
      'title' => Language::trans("{$sKey}.development.item4.title"),
      'text' => Language::trans("{$sKey}.development.item4.text")
    ],
    [
      'image' => 'ecommerce_s5.webp',
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
    'big' => 'ecommerce_7_big.webp',
    'small' => 'ecommerce_7_small.webp'
  ]
];
