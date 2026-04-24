<?php

use App\Models\Language;
$csLang = Language::getCurrentLanguage();
$sKey = "web3_app.{$csLang}";

return [
  'hero' => Language::trans("{$sKey}.hero.title"),
  'hero_text' => Language::trans("{$sKey}.hero.text"),
  'hero_images' => [
    'big' => 'web3_1_big.webp',
    'small' => 'web3_1_small.webp'
  ],
  'about1_title' => Language::trans("{$sKey}.about1"),
  'about1_images' => [
    'front' => 'web3_2_front.webp',
    'back' => 'web3_2_back.webp'
  ],
  'about2_title' => Language::trans("{$sKey}.about2"),
  'about2_text' => Language::trans("{$sKey}.about2_text"),
  'about2_images' => [
    'big' => 'web3_3_big.webp',
    'mid' => 'web3_3_mid.webp',
    'small' => 'web3_3_small.webp'
  ],
  'benefits' => [
    [
      'image' => 'web3-decentralization',
      'title' => Language::trans("{$sKey}.benefits.item1.title"),
      'text' => Language::trans("{$sKey}.benefits.item1.text"),
    ],
    [
      'image' => 'web3-interoperatility',
      'title' => Language::trans("{$sKey}.benefits.item2.title"),
      'text' => Language::trans("{$sKey}.benefits.item2.text"),
    ],
    [
      'image' => 'web3-security',
      'title' => Language::trans("{$sKey}.benefits.item3.title"),
      'text' => Language::trans("{$sKey}.benefits.item3.text"),
    ],
    [
      'image' => 'web3-scalability',
      'title' => Language::trans("{$sKey}.benefits.item4.title"),
      'text' => Language::trans("{$sKey}.benefits.item4.text"),
    ],
    [
      'image' => 'web3-monetization',
      'title' => Language::trans("{$sKey}.benefits.item5.title"),
      'text' => Language::trans("{$sKey}.benefits.item5.text"),
    ],
    [
      'image' => 'web3-uxui',
      'title' => Language::trans("{$sKey}.benefits.item6.title"),
      'text' => Language::trans("{$sKey}.benefits.item6.text"),
    ],
  ],
  'process_title' => Language::trans("{$sKey}.development.title"),
  'processes' => [
    [
      'image' => 'web3_s1.webp',
      'title' => Language::trans("{$sKey}.development.item1.title"),
      'text' => Language::trans("{$sKey}.development.item1.text")
    ],
    [
      'image' => 'web3_s2.webp',
      'title' => Language::trans("{$sKey}.development.item2.title"),
      'text' => Language::trans("{$sKey}.development.item2.text")
    ],
    [
      'image' => 'web3_s3.webp',
      'title' => Language::trans("{$sKey}.development.item3.title"),
      'text' => Language::trans("{$sKey}.development.item3.text")
    ],
    [
      'image' => 'web3_s4.webp',
      'title' => Language::trans("{$sKey}.development.item4.title"),
      'text' => Language::trans("{$sKey}.development.item4.text")
    ],
    [
      'image' => 'web3_s5.webp',
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
    'big' => 'web3_7_big.webp',
    'small' => 'web3_7_small.webp'
  ]
];
