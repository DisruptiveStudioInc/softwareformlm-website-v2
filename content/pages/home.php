<?php

use App\Models\Language;

$getPlanModal = static function (
  string $planKey,
  int $introCount,
  int $featureCount,
  int $idealForCount
): array {
  $intro = [];
  $features = [];
  $idealFor = [];

  for ($i = 1; $i <= $introCount; $i++) {
    $intro[] = Language::trans("home.plans.{$planKey}.modal.intro{$i}");
  }

  for ($i = 1; $i <= $featureCount; $i++) {
    $features[] = Language::trans("home.plans.{$planKey}.modal.feature{$i}");
  }

  for ($i = 1; $i <= $idealForCount; $i++) {
    $idealFor[] = Language::trans("home.plans.{$planKey}.modal.ideal_for{$i}");
  }

  return [
    'intro' => $intro,
    'features_title' => Language::trans("home.plans.{$planKey}.modal.features_title"),
    'features' => $features,
    'ideal_for_title' => Language::trans("home.plans.{$planKey}.modal.ideal_for_title"),
    'ideal_for' => $idealFor,
    'closing' => Language::trans("home.plans.{$planKey}.modal.closing"),
  ];
};

return[
  'seoDescription' => Language::trans('home.description'),
  'operate' => [
    [
      'icon' => 'gear',
      'title' => Language::trans('home.operate.item1.title'),
      'text' => Language::trans('home.operate.item1.text')
    ],
    [
      'icon' => 'gear',
      'title' => Language::trans('home.operate.item2.title'),
      'text' => Language::trans('home.operate.item2.text')
    ],
    [
      'icon' => 'gear',
      'title' => Language::trans('home.operate.item3.title'),
      'text' => Language::trans('home.operate.item3.text')
    ],
    [
      'icon' => 'gear',
      'title' => Language::trans('home.operate.item4.title'),
      'text' => Language::trans('home.operate.item4.text')
    ]
  ],
  'steps' => [
    [
      'number' => Language::trans('home.steps.item1.title'),
      'title' => Language::trans('home.steps.item1.subtitle'),
      'text' => Language::trans('home.steps.item1.text')
    ],
    [
      'number' => Language::trans('home.steps.item2.title'),
      'title' => Language::trans('home.steps.item2.subtitle'),
      'text' => Language::trans('home.steps.item2.text')
    ],
    [
      'number' => Language::trans('home.steps.item3.title'),
      'title' => Language::trans('home.steps.item3.subtitle'),
      'text' => Language::trans('home.steps.item3.text')
    ],
    [
      'number' => Language::trans('home.steps.item4.title'),
      'title' => Language::trans('home.steps.item4.subtitle'),
      'text' => Language::trans('home.steps.item4.text')
    ]
  ],
  'network' => [
    [
      'title' => Language::trans('home.network.item1.title'),
      'text' => Language::trans('home.network.item1.text1'),
      'text2' => Language::trans('home.network.item1.text2')
    ],
    [
      'title' => Language::trans('home.network.item2.title'),
      'text' => Language::trans('home.network.item2.text1'),
      'text2' => Language::trans('home.network.item2.text2')
    ],
    [
      'title' => Language::trans('home.network.item3.title'),
      'text' => Language::trans('home.network.item3.text1'),
      'text2' => Language::trans('home.network.item3.text2')
    ],
    [
      'title' => Language::trans('home.network.item4.title'),
      'text' => Language::trans('home.network.item4.text1'),
      'text2' => Language::trans('home.network.item4.text2')
    ]
  ],
  'stats' => [
    [
      'number' => '+250',
      'name' => Language::trans('home.scale.stats.business1'),
      'text' => Language::trans('home.scale.stats.business2')
    ],
    [
      'number' => '+35M',
      'name' => Language::trans('home.scale.stats.people1'),
      'text' => Language::trans('home.scale.stats.people2')
    ],
    [
      'number' => '+400M',
      'name' => Language::trans('home.scale.stats.money1'),
      'text' => Language::trans('home.scale.stats.money2')
    ]
  ],
  'plans' => [
    [
      'title' => Language::trans('home.plans.plan1.title'),
      'modal' => $getPlanModal('plan1', 3, 5, 3),
      'users' => 500,
      'support' => Language::trans('home.plans.plan1.support'),
      'price' => 197,
      'slug' => "product/starter",
      'items' => [
        'user_limit' => true,
        'traffic' => true,
        'encrypted_data' => true,
        'availability' => true,
        'access_24_7' => true,
        'unilevel' => true,
        'events' => true,
        'bonuses' => true,
        'stripe' => true,
        'crypto' => true,
        'user_control' => true,
        'roles' => true,
        'notifications' => true,
        'languages' => true,
        'cashout' => true,
        'referrals' => true
      ]
    ],
    [
      'title' => Language::trans('home.plans.plan2.title'),
      'modal' => $getPlanModal('plan2', 3, 6, 4),
      'users' => 10000,
      'support' => Language::trans('home.plans.plan2.support'),
      'price' => 397,
      'slug' => "product/growth",
      'items' => [
        'includes' => Language::trans('home.plans.plan1.title'),
        'user_limit' => true,
        'binary_tree' => true,
        'compression' => true,
        'monthly_membership' => true,
        'repurchase' => true,
        'upgrades' => true,
        'wallets' => true,
        'ranks' => true,
        'brokers_module' => true,
        'kyc_aml' => true
      ]
    ],
    [
      'recommended' => true,
      'title' => Language::trans('home.plans.plan3.title'),
      'modal' => $getPlanModal('plan3', 3, 6, 4),
      'users' => 100000,
      'support' => Language::trans('home.plans.plan3.support'),
      'price' => 597,
      'slug' => "product/scale",
      'items' => [
        'includes' => Language::trans('home.plans.plan2.title'),
        'user_limit' => true,
        'ecommerce' => true,
        'education_plans' => true,
        'suscriptions' => true,
        'inventory_management' => true,
        'ipayout' => true,
        'multicountry' => true,
        'payment_processors' => true
      ]
    ],
    [
      'title' => Language::trans('home.plans.plan4.title'),
      'modal' => $getPlanModal('plan4', 4, 7, 4),
      'users' => Language::trans('home.plans.unlimited'),
      'support' => Language::trans('home.plans.plan4.support'),
      'price' => 997,
      'slug' => "product/dominate",
      'items' => [
        'includes' => Language::trans('home.plans.plan3.title'),
        'user_limit' => true,
        'whatsapp_group' => true,
        'wallet_connect' => true,
        'signed_contract' => true,
        'token_sale' => true,
        'p2p_token' => true,
        'global_api' => true,
        'nft_marketplace' => true,
        'elearning' => true
      ]
    ]
  ],
  'control_list' => [
    [
      'image' => 'operation-1.webp',
      'title' => Language::trans('home.control.item1.title'),
      'text' => Language::trans('home.control.item1.text1'),
      'text2' => Language::trans('home.control.item1.text2')
    ],
    [
      'image' => 'operation-2.webp',
      'title' => Language::trans('home.control.item2.title'),
      'text' => Language::trans('home.control.item2.text1'),
      'text2' => Language::trans('home.control.item2.text2')
    ],
    [
      'image' => 'operation-3.webp',
      'title' => Language::trans('home.control.item3.title'),
      'text' => Language::trans('home.control.item3.text1'),
      'text2' => Language::trans('home.control.item3.text2')
    ]
  ]
];
