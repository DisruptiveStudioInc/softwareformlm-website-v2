<?php

use App\Models\Language;
$csLang = Language::getCurrentLanguage();
$sKey = "talent_recruitment.{$csLang}";

return [
  'hero' => Language::trans("{$sKey}.hero.title"),
  'hero_text' => Language::trans("{$sKey}.hero.text"),
  'hero_images' => [
    'big' => 'talent_1_big.webp',
    'small' => 'talent_1_small.webp'
  ],
  'about1_title' => Language::trans("{$sKey}.about1"),
  'about1_images' => [
    'front' => 'talent_2_front.webp',
    'back' => 'talent_2_back.webp'
  ],
  'about2_title' => Language::trans("{$sKey}.about2"),
  'about2_text' => Language::trans("{$sKey}.about2_text"),
  'about2_images' => [
    'big' => 'talent_3_big.webp',
    'mid' => 'talent_3_mid.webp',
    'small' => 'talent_3_small.webp'
  ],
  'benefits' => [
    [
      'image' => 'talent-selection',
      'title' => Language::trans("{$sKey}.benefits.item1.title"),
      'text' => Language::trans("{$sKey}.benefits.item1.text"),
    ],
    [
      'image' => 'talent-processes',
      'title' => Language::trans("{$sKey}.benefits.item2.title"),
      'text' => Language::trans("{$sKey}.benefits.item2.text"),
    ],
    [
      'image' => 'talent-evaluation',
      'title' => Language::trans("{$sKey}.benefits.item3.title"),
      'text' => Language::trans("{$sKey}.benefits.item3.text"),
    ],
    [
      'image' => 'talent-database',
      'title' => Language::trans("{$sKey}.benefits.item4.title"),
      'text' => Language::trans("{$sKey}.benefits.item4.text"),
    ],
    [
      'image' => 'talent-savings',
      'title' => Language::trans("{$sKey}.benefits.item5.title"),
      'text' => Language::trans("{$sKey}.benefits.item5.text"),
    ],
    [
      'image' => 'talent-scale',
      'title' => Language::trans("{$sKey}.benefits.item6.title"),
      'text' => Language::trans("{$sKey}.benefits.item6.text"),
    ],
  ],
  'process_title' => Language::trans("{$sKey}.process.title"),
  'processes' => [
    [
      'image' => 'talent_s1.webp',
      'title' => Language::trans("{$sKey}.process.item1.title"),
      'text' => Language::trans("{$sKey}.process.item1.text")
    ],
    [
      'image' => 'talent_s2.webp',
      'title' => Language::trans("{$sKey}.process.item2.title"),
      'text' => Language::trans("{$sKey}.process.item2.text")
    ],
    [
      'image' => 'talent_s3.webp',
      'title' => Language::trans("{$sKey}.process.item3.title"),
      'text' => Language::trans("{$sKey}.process.item3.text")
    ],
    [
      'image' => 'talent_s4.webp',
      'title' => Language::trans("{$sKey}.process.item4.title"),
      'text' => Language::trans("{$sKey}.process.item4.text")
    ],
    [
      'image' => 'talent_s5.webp',
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
    'big' => 'talent_7_big.webp',
    'small' => 'talent_7_small.webp'
  ]
];
