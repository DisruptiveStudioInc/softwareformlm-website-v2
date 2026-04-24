<?php

use App\Models\Language;
$csLang = Language::getCurrentLanguage();
$sKey = "payment_processing.{$csLang}";

return [
  'hero' => Language::trans("{$sKey}.hero.title"),
  'hero_text' => Language::trans("{$sKey}.hero.text"),
  'hero_tag' => [
    'text' => Language::trans("{$sKey}.hero.tag"),
    'images' => [
      'sec_client.svg',
      'sec_client.svg',
      'sec_client.svg'
    ]
  ],
  'hero_image' => 'sec_hero.svg',
  'hero_cta_main' => [
    'text' => Language::trans("common.demo"),
    'link' => "https://wa.me/"
  ],
  'hero_cta_secondary' => [
    'text' => Language::trans("{$sKey}.hero.cta"),
    'link' => '#benefits'
  ],
  'benefits_title' => Language::trans("{$sKey}.benefits.title"),
  'benefits_text' => Language::trans("{$sKey}.benefits.text"),
  'benefits' => [
    [
      'image' => 'sec_slide.svg',
      'title' => Language::trans("{$sKey}.benefits.item1.title"),
      'text' => Language::trans("{$sKey}.benefits.item1.text")
    ],
    [
      'image' => 'sec_slide.svg',
      'title' => Language::trans("{$sKey}.benefits.item2.title"),
      'text' => Language::trans("{$sKey}.benefits.item2.text")
    ],
    [
      'image' => 'sec_slide.svg',
      'title' => Language::trans("{$sKey}.benefits.item3.title"),
      'text' => Language::trans("{$sKey}.benefits.item3.text")
    ],
    [
      'image' => 'sec_slide.svg',
      'title' => Language::trans("{$sKey}.benefits.item4.title"),
      'text' => Language::trans("{$sKey}.benefits.item4.text")
    ],
    [
      'image' => 'sec_slide.svg',
      'title' => Language::trans("{$sKey}.benefits.item5.title"),
      'text' => Language::trans("{$sKey}.benefits.item5.text")
    ],
    [
      'image' => 'sec_slide.svg',
      'title' => Language::trans("{$sKey}.benefits.item6.title"),
      'text' => Language::trans("{$sKey}.benefits.item6.text")
    ]
  ],
  'how_works_title' => Language::trans("{$sKey}.how_works.title"),
  'how_works_text' => Language::trans("{$sKey}.how_works.text"),
  'how_works_list' => [
    [
      'image' => 'sec_slide.svg',
      'title' => Language::trans("{$sKey}.how_works.item1.title"),
      'text' => Language::trans("{$sKey}.how_works.item1.text")
    ],
    [
      'image' => 'sec_slide.svg',
      'title' => Language::trans("{$sKey}.how_works.item2.title"),
      'text' => Language::trans("{$sKey}.how_works.item2.text")
    ],
    [
      'image' => 'sec_slide.svg',
      'title' => Language::trans("{$sKey}.how_works.item3.title"),
      'text' => Language::trans("{$sKey}.how_works.item3.text")
    ],
    [
      'image' => 'sec_slide.svg',
      'title' => Language::trans("{$sKey}.how_works.item4.title"),
      'text' => Language::trans("{$sKey}.how_works.item4.text")
    ]
  ],
  'faqs' => [
    [
      'title' => Language::trans("{$sKey}.faqs.question1"),
      'text' => Language::trans("{$sKey}.faqs.answer1")
    ],
    [
      'title' => Language::trans("{$sKey}.faqs.question2"),
      'text' => Language::trans("{$sKey}.faqs.answer2")
    ],
    [
      'title' => Language::trans("{$sKey}.faqs.question3"),
      'text' => Language::trans("{$sKey}.faqs.answer3")
    ],
    [
      'title' => Language::trans("{$sKey}.faqs.question4"),
      'text' => Language::trans("{$sKey}.faqs.answer4")
    ],
    [
      'title' => Language::trans("{$sKey}.faqs.question5"),
      'text' => Language::trans("{$sKey}.faqs.answer5")
    ]
  ],
  'banner_image' => 'sec_slide.svg',
  'banner_title' => Language::trans("{$sKey}.cta.title"),
  'banner_text' => Language::trans("{$sKey}.cta.text"),
  'banner_cta_main' => [
    'text' => Language::trans("common.demo"),
    'link' => 'https://wa.me/'
  ],
  'banner_cta_secondary' => [
    'text' => Language::trans("{$sKey}.cta.button"),
    'link' => 'contact'
  ]
];
