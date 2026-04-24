<?php

use App\Models\Language;
$csLang = Language::getCurrentLanguage();
$sKey = "metaverse.{$csLang}";

return [
  'hero' => Language::trans("{$sKey}.hero.title"),
  'hero_text' => Language::trans("{$sKey}.hero.text"),
  'hero_tag' => [
    'text' => Language::trans("{$sKey}.hero.tag"),
    'images' => [
      'metaverse_logo_1.png',
      'metaverse_logo_2.png',
      'metaverse_logo_3.png'
    ]
  ],
  'hero_image' => 'metaverse_hero.webp',
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
      'image' => 'metaverse_presencia.webp',
      'title' => Language::trans("{$sKey}.benefits.item1.title"),
      'text' => Language::trans("{$sKey}.benefits.item1.text")
    ],
    [
      'image' => 'metaverse_interaccion.webp',
      'title' => Language::trans("{$sKey}.benefits.item2.title"),
      'text' => Language::trans("{$sKey}.benefits.item2.text")
    ],
    [
      'image' => 'metaverse_economias.webp',
      'title' => Language::trans("{$sKey}.benefits.item3.title"),
      'text' => Language::trans("{$sKey}.benefits.item3.text")
    ],
    [
      'image' => 'metaverse_compatibilidad.webp',
      'title' => Language::trans("{$sKey}.benefits.item4.title"),
      'text' => Language::trans("{$sKey}.benefits.item4.text")
    ],
    [
      'image' => 'metaverse_blockchain.webp',
      'title' => Language::trans("{$sKey}.benefits.item5.title"),
      'text' => Language::trans("{$sKey}.benefits.item5.text")
    ],
    [
      'image' => 'metaverse_escalabilidad.webp',
      'title' => Language::trans("{$sKey}.benefits.item6.title"),
      'text' => Language::trans("{$sKey}.benefits.item6.text")
    ]
  ],
  'how_works_title' => Language::trans("{$sKey}.how_works.title"),
  'how_works_text' => Language::trans("{$sKey}.how_works.text"),
  'how_works_list' => [
    [
      'image' => 'metaverse_conceptualizacion.webp',
      'title' => Language::trans("{$sKey}.how_works.item1.title"),
      'text' => Language::trans("{$sKey}.how_works.item1.text")
    ],
    [
      'image' => 'metaverse_diseno.webp',
      'title' => Language::trans("{$sKey}.how_works.item2.title"),
      'text' => Language::trans("{$sKey}.how_works.item2.text")
    ],
    [
      'image' => 'metaverse_integracion.webp',
      'title' => Language::trans("{$sKey}.how_works.item3.title"),
      'text' => Language::trans("{$sKey}.how_works.item3.text")
    ],
    [
      'image' => 'metaverse_despliegue.webp',
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
  'banner_image' => 'file.webp',
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
