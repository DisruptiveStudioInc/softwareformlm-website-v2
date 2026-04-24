<?php

use App\Models\Language;
$csLang = Language::getCurrentLanguage();
$sKey = "ui_ux.{$csLang}";

return [
  'hero' => Language::trans("{$sKey}.hero.title"),
  'hero_text' => Language::trans("{$sKey}.hero.text"),
  'hero_images' => [
    'big' => 'uiux_1_big.webp',
    'small' => 'uiux_1_small.webp'
  ],
  'about1_title' => Language::trans("{$sKey}.about1"),
  'about1_images' => [
    'front' => 'uiux_2_front.webp',
    'back' => 'uiux_2_back.webp'
  ],
  'about2_title' => Language::trans("{$sKey}.about2"),
  'about2_text' => Language::trans("{$sKey}.about2_text"),
  'about2_images' => [
    'big' => 'uiux_3_big.webp',
    'mid' => 'uiux_3_mid.webp',
    'small' => 'uiux_3_small.webp'
  ],
  'benefits' => [
    [
      'image' => 'ux-experience',
      'title' => Language::trans("{$sKey}.benefits.item1.title"),
      'text' => Language::trans("{$sKey}.benefits.item1.text"),
    ],
    [
      'image' => 'ux-functional',
      'title' => Language::trans("{$sKey}.benefits.item2.title"),
      'text' => Language::trans("{$sKey}.benefits.item2.text"),
    ],
    [
      'image' => 'ux-consistency',
      'title' => Language::trans("{$sKey}.benefits.item3.title"),
      'text' => Language::trans("{$sKey}.benefits.item3.text"),
    ],
    [
      'image' => 'ux-desicions',
      'title' => Language::trans("{$sKey}.benefits.item4.title"),
      'text' => Language::trans("{$sKey}.benefits.item4.text"),
    ],
    [
      'image' => 'ux-prototype',
      'title' => Language::trans("{$sKey}.benefits.item5.title"),
      'text' => Language::trans("{$sKey}.benefits.item5.text"),
    ],
    [
      'image' => 'ux-design',
      'title' => Language::trans("{$sKey}.benefits.item6.title"),
      'text' => Language::trans("{$sKey}.benefits.item6.text"),
    ],
  ],
  'process_title' => Language::trans("{$sKey}.process.title"),
  'processes' => [
    [
      'image' => 'uiux_s1.webp',
      'title' => Language::trans("{$sKey}.process.item1.title"),
      'text' => Language::trans("{$sKey}.process.item1.text")
    ],
    [
      'image' => 'uiux_s2.webp',
      'title' => Language::trans("{$sKey}.process.item2.title"),
      'text' => Language::trans("{$sKey}.process.item2.text")
    ],
    [
      'image' => 'uiux_s3.webp',
      'title' => Language::trans("{$sKey}.process.item3.title"),
      'text' => Language::trans("{$sKey}.process.item3.text")
    ],
    [
      'image' => 'uiux_s4.webp',
      'title' => Language::trans("{$sKey}.process.item4.title"),
      'text' => Language::trans("{$sKey}.process.item4.text")
    ],
    [
      'image' => 'uiux_s5.webp',
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
    'big' => 'uiux_7_big.webp',
    'small' => 'uiux_7_small.webp'
  ]
];
