<?php

use App\Models\Language;

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
  'plans' => [
    [
      'title' => Language::trans('home.plans.plan1.title'),
      'subtitle' => Language::trans('home.plans.plan1.subtitle'),
      'text' => Language::trans('home.plans.plan1.text'),
      'users' => 500,
      'support' => Language::trans('home.plans.plan1.support'),
      'price' => 197,
      'items' => [
        'encrypted_data' => true,
        'availability' => true,
        'access_24_7' => true,
        'unilevel' => true,
        'binary_tree' => true,
        'bonuses' => true,
        'compression' => true,
        'monthly_membership' => true,
        'investment_plans' => true,
        'education_plans' => true,
        'repurchase' => true,
        'upgrades' => true,
        'wallets' => true,
        'ranks' => true,
        'brokers_module' => true,
        'stripe' => true,
        'crypto' => true,
        'user_control' => true,
        'roles' => true,
        'notifications' => true,
        'languages' => true,
        'cashout' => true,
        'ecommerce' => false,
        'suscriptions' => false,
        'inventory_management' => false,
        'referrals' => false,
        'events' => false,
        'ipayout' => false,
        'multicountry' => false,
        'kyc' => false,
        'wallet_connect' => false,
        'aml' => false,
        'signed_contract' => false,
        'payment_processors' => false
      ]
    ],
    [
      'title' => Language::trans('home.plans.plan2.title'),
      'subtitle' => Language::trans('home.plans.plan2.subtitle'),
      'text' => Language::trans('home.plans.plan2.text'),
      'users' => 5000,
      'support' => Language::trans('home.plans.plan2.support'),
      'price' => 397,
      'items' => [
        'encrypted_data' => true,
        'availability' => true,
        'access_24_7' => true,
        'unilevel' => true,
        'binary_tree' => true,
        'bonuses' => true,
        'compression' => true,
        'monthly_membership' => true,
        'investment_plans' => true,
        'education_plans' => true,
        'repurchase' => true,
        'upgrades' => true,
        'wallets' => true,
        'ranks' => true,
        'brokers_module' => true,
        'stripe' => true,
        'crypto' => true,
        'user_control' => true,
        'roles' => true,
        'notifications' => true,
        'languages' => true,
        'cashout' => true,
        'ecommerce' => true,
        'suscriptions' => true,
        'inventory_management' => true,
        'referrals' => true,
        'events' => true,
        'ipayout' => true,
        'multicountry' => true,
        'kyc' => false,
        'wallet_connect' => false,
        'aml' => false,
        'signed_contract' => false,
        'payment_processors' => false
      ]
    ],
    [
      'title' => Language::trans('home.plans.plan3.title'),
      'subtitle' => Language::trans('home.plans.plan3.subtitle'),
      'text' => Language::trans('home.plans.plan3.text'),
      'users' => Language::trans('home.plans.unlimited'),
      'support' => Language::trans('home.plans.plan3.support'),
      'price' => 997,
      'items' => [
        'encrypted_data' => true,
        'availability' => true,
        'access_24_7' => true,
        'unilevel' => true,
        'binary_tree' => true,
        'bonuses' => true,
        'compression' => true,
        'monthly_membership' => true,
        'investment_plans' => true,
        'education_plans' => true,
        'repurchase' => true,
        'upgrades' => true,
        'wallets' => true,
        'ranks' => true,
        'brokers_module' => true,
        'stripe' => true,
        'crypto' => true,
        'user_control' => true,
        'roles' => true,
        'notifications' => true,
        'languages' => true,
        'cashout' => true,
        'ecommerce' => true,
        'suscriptions' => true,
        'inventory_management' => true,
        'referrals' => true,
        'events' => true,
        'ipayout' => true,
        'multicountry' => true,
        'kyc' => true,
        'wallet_connect' => true,
        'aml' => true,
        'signed_contract' => true,
        'payment_processors' => true
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
