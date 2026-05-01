<?php

$legalTranslations = loadLangDynamic(__DIR__ . '/../lang/legal');
$servicesTranslations = loadLangDynamic();

return [
  // Navigation
  'nav' => [
    'home' => 'Home',
    'sfmlm' => 'Software4MLM',
    'plans' => 'Pricing',
    'team' => 'Team',
    'solutions' => 'Solutions',
    'services' => 'Services',
    'ecosystem' => 'Ecosystem',
    'disruptive_ip' => 'Our IP',
    'case_studies' => 'Case Studies',
    'certifications' => 'Certifications',
    'contact' => 'Contact Us',
    'blog' => 'Blog',
    'buy' => 'Subscribe Now',
  ],

  // Footer
  'footer' => [
    'contact' => 'Contact',
    'about' => 'About Us',
    'legal' => 'Legal',
    'compliance' => 'Compliance',
    'platform' => 'Platform',
    'technology' => 'Technology',
    'privacy' => 'Privacy Policy',
    'terms' => 'Terms and Conditions',
    'cookies' => 'Cookies Policy',
    'refunds' => 'Refund Policy',
    'use' => 'Acceptable Use Policy',
    'compliance_policy' => 'Compliance Policy',
    'risk_disclosure' => 'Risk Disclosure',
    'security' => 'Security Policy',
    'sla' => 'SLA',
    'ip' => 'IP Policy',
    'copyright' => 'Copyright',
    'architecture' => 'Security Architecture',
    'use_terms' => 'Terms Of Use',
    'legal_small' => 'All trademarks, logos, and brand names are the property of their respective owners. Their use on this site is for identification and reference purposes only and does not imply any affiliation, sponsorship, or endorsement.',
    'affiliate_brand' => 'Software for MLM',
    'affiliate_text' => 'is verified as',
    'affiliate_name' => 'Software for MLM in Mexico',
  ],

  // Home page
  'home' => [
    'title' => 'Software for MLM',
    'description' => 'Comprehensive solution for companies and multilevel networks.',
    'hero' => [
      'title' => 'Launch your own MLM business in less than 24 hours',
      'text' => 'Access a live demo now and see how the system works from the inside.'
    ],
    'operate' => [
      'title' => "Your own MLM system, ready to operate",
      'text' => 'Launch, control and scale your multilevel business with a complete infrastructure, without developing technology from scratch.',
      'item1' => [
        'title' => 'Backoffice',
        'text' => 'Control your network, commissions and operations from a single place with real-time data.'
      ],
      'item2' => [
        'title' => 'Compensation plans',
        'text' => 'Activate and automate your business model with bonus and commission calculations ready to scale from day one.'
      ],
      'item3' => [
        'title' => 'Wallet and payments',
        'text' => 'Manage income, payments and withdrawals within the system with total control, transparency and traceability.'
      ],
      'item4' => [
        'title' => 'User management',
        'text' => 'Manage your network, structure and growth without depending on third parties or manual processes.'
      ],
      'footnote' => 'Access the live system now'
    ],
    'steps' => [
      'item1' => [
        'title' => 'Design and scale',
        'subtitle' => 'Design your business model from scratch',
        'text' => 'Create smart compensation plans, configure bonuses, and structure your network without technical limits. All in one place, ready to scale.'
      ],
      'item2' => [
        'title' => 'Connect and strengthen',
        'subtitle' => 'Build a strong and active network',
        'text' => 'Centralize communication with your team, automate processes, and keep every member connected, informed, and in motion.'
      ],
      'item3' => [
        'title' => 'Launch and manage',
        'subtitle' => 'Operate your business without relying on third parties',
        'text' => 'Manage users, products, ranks, and operations in real-time from a back office designed to grow with you.'
      ],
      'item4' => [
        'title' => 'Collect and decide',
        'subtitle' => 'Control your money and make smart decisions',
        'text' => 'Receive payments, monitor key metrics, and access real-time reports to constantly optimize your business.'
      ]
    ],
    'network' => [
      'title' => 'Turn your project into a profitable, automated, and scalable network',
      'item1' => [
        'title' => 'Flexible compensation models',
        'text1' => 'Implement structures like unilevel, binary, matrix, or custom hybrids according to your strategy.',
        'text2' => 'Adapt your business to any market and evolve your network without technical limitations.'
      ],
      'item2' => [
        'title' => 'Total automation of your operation',
        'text1' => 'Bonuses, commissions, payments, ranks, and processes running automatically.',
        'text2' => 'Reduce errors, eliminate operational load, and focus on growing your network.'
      ],
      'item3' => [
        'title' => 'Real-time control and visibility',
        'text1' => 'Access metrics, reports, and network behavior from a single location.',
        'text2' => 'Make strategic decisions with clear, updated, and actionable information.'
      ],
      'item4' => [
        'title' => 'Scalable infrastructure ready to use',
        'text1' => 'System prepared to support massive growth from day one.',
        'text2' => 'Thousands of users, multiple markets, and continuous operation without friction.'
      ]
    ],
    'scale' => [
      'title' => 'MLM technology that drives real networks and businesses that scale',
      'text' => 'You can do much more with SoftwareForMLM',
      'accent' => 'Ready to take your company to dominate the market?',
      'stats' => [
        'business1' => 'companies',
        'business2' => 'use our system',
        'people1' => 'people',
        'people2' => 'use our platform',
        'money1' => 'of dollars',
        'money2' => 'processed by clients'
      ]
    ],
    'customize' => [
      'title' => "Customize your business and scale it without limits",
      'text' => "Adapt every part of your operation: compensation, products, users, rules, and structure. Your system evolves with you, without technical restrictions or dependence on developers.",
      'text2' => "Designed to operate in multiple markets, currencies, and growth structures.",
      'footnote' => 'Explore the live system and discover its flexibility'
    ],
    'plans' => [
      'title' => "Choose the operating level for your business",
      'subtitle' => "From an initial structure to a fully automated global operation. Scale at your own pace with infrastructure that grows with you.",
      'circle' => 'Plans',
      'plan1' => [
        'title' => "Starter",
        'support' => "Tickets",
        'modal' => [
          'intro1' => "The Starter plan is designed for leaders who are already inside a network but want to begin taking control of their own structure.",
          'intro2' => "This isn't about changing industries.",
          'intro3' => "It's about starting to build something of your own.",
          'features_title' => "With this plan, you can:",
          'feature1' => "Create your own back office",
          'feature2' => "Centralize your network in a database that belongs to you",
          'feature3' => "Manage your community independently",
          'feature4' => "Organize events and provide access to your team",
          'feature5' => "Sell courses or content directly",
          'ideal_for_title' => "Ideal if:",
          'ideal_for1' => "You already have a team or community",
          'ideal_for2' => "You want control over your network",
          'ideal_for3' => "You want to start building something of your own without leaving your current operation",
          'closing' => "Start building something that already belongs to you",
        ],
      ],
      'plan2' => [
        'title' => "Growth",
        'support' => "Tickets, Chat",
        'modal' => [
          'intro1' => "The Growth plan is designed for leaders who are ready to take the next step: becoming owners of their own Network Marketing organization.",
          'intro2' => "At this stage, it's no longer about participating.",
          'intro3' => "It's about building and leading your own structure.",
          'features_title' => "With this plan, you can:",
          'feature1' => "Launch your own MLM company",
          'feature2' => "Build and manage a structured network from scratch",
          'feature3' => "Configure more complete compensation plans",
          'feature4' => "Manage commissions, bonuses, and the growth of your network",
          'feature5' => "Have full control over your operation",
          'feature6' => "Scale your business with a solid structure",
          'ideal_for_title' => "Ideal if:",
          'ideal_for1' => "You already understand how MLM works",
          'ideal_for2' => "You're ready to lead your own company",
          'ideal_for3' => "You want to scale with control and a long-term vision",
          'ideal_for4' => "You're looking for a real structure to grow seriously",
          'closing' => "From leader to owner. Build your own network and scale without limits",
        ],
      ],
      'plan3' => [
        'title' => "Scale",
        'support' => "Tickets, Chat, WhatsApp",
        'modal' => [
          'intro1' => "The Scale plan is designed for those who want to take their company to thousands of people through a complete digital structure.",
          'intro2' => "Here, you're not just building a network.",
          'intro3' => "You're building a platform that distributes.",
          'features_title' => "With this plan, you can:",
          'feature1' => "Launch your own MLM company",
          'feature2' => "Build and manage a structured network",
          'feature3' => "Have your own integrated e-commerce platform",
          'feature4' => "Sell your products digitally at scale",
          'feature5' => "Take your business into multiple countries",
          'feature6' => "Manage commissions, bonuses, and growth from a single system",
          'ideal_for_title' => "Ideal if:",
          'ideal_for1' => "You have or want to sell physical products",
          'ideal_for2' => "You're looking to scale your company digitally",
          'ideal_for3' => "You want to reach thousands of people without friction",
          'ideal_for4' => "You're ready to operate with a complete structure",
          'closing' => "Take your company to thousands of people with your own digital sales platform",
        ],
      ],
      'plan4' => [
        'title' => "Dominate",
        'support' => "Tickets, Chat",
        'modal' => [
          'intro1' => "The Dominate plan is designed for leaders who are not here to participate in the market.",
          'intro2' => "They're here to dominate it.",
          'intro3' => "You're not building just another network here.",
          'intro4' => "You're building a structure designed to lead at scale.",
          'features_title' => "With this plan, you can:",
          'feature1' => "Launch and operate an MLM company without limits",
          'feature2' => "Build a network with unlimited users",
          'feature3' => "Scale your operation globally",
          'feature4' => "Configure complete compensation structures",
          'feature5' => "Control commissions, bonuses, and growth without restrictions",
          'feature6' => "Integrate e-commerce and digital distribution into a single system",
          'feature7' => "Manage your entire operation from a robust platform",
          'ideal_for_title' => "Ideal if:",
          'ideal_for1' => "You already have a solid network or community",
          'ideal_for2' => "You're ready to lead at scale",
          'ideal_for3' => "You want to dominate your market, not compete in it",
          'ideal_for4' => "You need a structure without limits to grow",
          'closing' => "You're not here to play.<br/>You're here to dominate",
        ],
      ],
      'user_limit' => 'Users limit',
      'support' => 'Support channels',
      'unlimited' => 'Unlimited',
      'per_month' => 'month',
      'everything_in' => 'Everything in',
      'non_binding_subscription' => 'Non-binding monthly subscription. Cancel anytime.',
      'items' => [
        'traffic' => 'Unlimited traffic',
        'encrypted_data' => 'Encrypted data',
        'availability' => 'High availability',
        'access_24_7' => '24/7/365 access',
        'unilevel' => 'Unilevel tree',
        'binary_tree' => 'Binary tree',
        'bonuses' => 'Bonuses',
        'compression' => 'Dynamic compression',
        'monthly_membership' => 'Monthly membership',
        'investment_plans' => 'Investment plans',
        'education_plans' => 'Educational plans',
        'repurchase' => 'Repurchases',
        'upgrades' => 'Upgrades',
        'wallets' => 'Internal wallets',
        'ranks' => 'Ranks',
        'brokers_module' => 'Brokers module',
        'stripe' => 'Stripe',
        'crypto' => 'Crypto',
        'user_control' => 'User control',
        'roles' => 'Roles',
        'notifications' => 'Notifications module',
        'languages' => 'Multi-language',
        'cashout' => 'Automatic and manual cash out',
        'ecommerce' => 'E-Commerce',
        'suscriptions' => 'Subscriptions',
        'inventory_management' => 'Inventory management',
        'referrals' => 'Referral link',
        'events' => 'Events module',
        'ipayout' => 'Ipayout',
        'multicountry' => 'Multi-country (stores have extra cost)',
        'kyc_aml' => 'KYC - AML module',
        'wallet_connect' => 'Wallet Connect (Web3)',
        'signed_contract' => 'Contract signing upon purchase',
        'payment_processors' => 'Multiple payment processors',
        'token_sale' => 'Token sale (setup required)',
        'p2p_token' => 'P2P token exchange (setup required)',
        'module_otc' => 'OTC module (setup required)',
        'global_api' => 'Global API',
        'nft_marketplace' => 'NFT Marketplace (Setup required)',
        'whatsapp_group' => 'Dedicated WhatsApp group for support'
      ]
    ],
    'control' => [
      'title' => "Your operation under absolute control, from day one",
      'subtitle' => "Everything you need to launch, operate, and scale your network in a single system, without friction and with total visibility.",
      'item1' => [
        'title' => "High performance",
        'text1' => "Infrastructure designed to support real growth: thousands of users, high transaction volume, and continuous operation without failures.",
        'text2' => "Your business ready to scale from the first moment.",
      ],
      'item2' => [
        'title' => "Immediate deployment",
        'text1' => "Launch your operation in record time with ready configurations, specialized support, and a system prepared to operate from day one.",
        'text2' => "Less time implementing, more time growing.",
      ],
      'item3' => [
        'title' => "Enterprise-level security",
        'text1' => "Advanced data protection, operational stability, and technological backup to ensure confidence in every transaction.",
        'text2' => "Your business protected while it grows.",
      ],
    ],
    'ready' => [
      'title1' => "Everything is ready.",
      'title2' => "Now it's your turn to scale.",
      'text1' => "Access the system, explore how it works in real time, and discover how you can launch or transform your network starting today.",
      'text2' => "No commitment. No friction. With live guidance.",
    ],
    'clients' => 'Results that back our technology'
  ],

  // Errors
  'error' => [
    '404' => [
      'title' => 'Page not found',
      'message' => 'Sorry, the page you are looking for does not exist.',
      'back_home' => 'Back to home',
    ],
  ],

  // Common
  'common' => [
    'read_more' => 'Read more',
    'view_more' => 'View more',
    'learn_more' => 'Learn more',
    'know_more' => 'Know more',
    'back' => 'Back',
    'next' => 'Next',
    'previous' => 'Previous',
    'sales' => 'Sales',
    'demo' => 'Start Live Demo',
    'login' => 'Login',
    'register' => 'Register',
    'recommended' => 'Most popular',
    'get_info' => 'Get information',
    'subscribe' => 'Subscribe',
    'wame_message' => 'I%20want%20more%20information',
  ],

  'contact' => [
    'title' => 'Contact',
    'success' => 'Thanks. Your message was sent successfully.',
    'error' => 'We could not send your message right now. Please try again.',
    'form' => [
      'name' => 'Name',
      'email' => 'Email',
      'phone' => 'Phone',
      'message' => 'Message',
      'submit' => 'Send message',
    ],
    'validation' => [
      'name_required' => 'Name is required.',
      'email_required' => 'Email is required.',
      'email_invalid' => 'Enter a valid email address.',
      'message_required' => 'Message is required.',
      'recaptcha_failed' => 'reCAPTCHA verification failed. Please try again.',
    ],
  ],

  'exit_popup' => [
    'title' => 'You are one click away from having your own network',
    'text' => 'Fill in your details and we will give you more information',
    'submit' => 'Get information',
    'success' => 'Thanks. We received your information.',
    'error' => 'We could not save your information right now. Please try again.',
  ],

  // Common titles
  'common_titles' => [
    'benefits' => 'Benefits',
    'faqs' => 'FAQs',
    'how_works' => 'How it works'
  ],

  // Services Content
  'hybrid_app' => $servicesTranslations['aplicaciones-hibridas'],
  'inventory_control_storage' => $servicesTranslations['almacenaje-control-inventario'],
  'mobile_app' => $servicesTranslations['aplicaciones-moviles'],
  'multitenant_app' => $servicesTranslations['aplicaciones-multitenant'],
  'web_app' => $servicesTranslations['aplicaciones-web'],
  'web3_app' => $servicesTranslations['aplicaciones-web3'],
  'secure_db' => $servicesTranslations['bases-datos-seguras'],
  'smart_contracts' => $servicesTranslations['contratos-inteligentes'],
  'crypto_fiat' => $servicesTranslations['cripto-fiat'],
  'graphic_design' => $servicesTranslations['diseno-grafico'],
  'web_design' => $servicesTranslations['diseno-web'],
  'ecommerce' => $servicesTranslations['ecommerce'],
  'elearning' => $servicesTranslations['elearning'],
  'financial' => $servicesTranslations['financial'],
  'training' => $servicesTranslations['formacion-desarrollo'],
  'talent_management' => $servicesTranslations['gestion-talento'],
  'mlm_software' => $servicesTranslations['mlm-software'],
  'multimedia' => $servicesTranslations['multimedia'],
  'massive_payments' => $servicesTranslations['pagos-masivos'],
  'crypto_processing' => $servicesTranslations['procesamiento-criptomonedas'],
  'recruitment' => $servicesTranslations['reclutamiento'],
  'talent_recruitment' => $servicesTranslations['talento-captacion'],
  'tokenization_projects' => $servicesTranslations['tokenizacion-proyectos'],
  'ui_ux' => $servicesTranslations['ui-ux'],
  'supplements' => $servicesTranslations['suplementos'],
  'package_design' => $servicesTranslations['diseno-empaque'],
  'client_support' => $servicesTranslations['client-support'],
  'ticket_management' => $servicesTranslations['ticket-management'],
  'support_training' => $servicesTranslations['support-training'],
  'legal_financial' => $servicesTranslations['legal-financial-corporative'],
  'legal_realestate' => $servicesTranslations['legal-real-estate'],
  'intellectual_property' => $servicesTranslations['intellectual-property'],
  'litigation' => $servicesTranslations['litigio'],
  'storage_inventory' => $servicesTranslations['storage-inventory'],
  'package_fulfillment' => $servicesTranslations['package-fulfillment'],
  'shipment_distribution' => $servicesTranslations['shipment-distribution'],
  'logistic_optimization' => $servicesTranslations['logistic-optimization'],
  'operation_consulting' => $servicesTranslations['operation-consulting'],
  'financial_management' => $servicesTranslations['financial-management'],
  'corporate_financial' => $servicesTranslations['corporate-financial'],
  'accounting_reporting' => $servicesTranslations['accounting-reporting'],
  'taxes_compliance' => $servicesTranslations['taxes-compliance'],

  // Legal pages
  'cookies' => $legalTranslations['cookies'],
  'refunds' => $legalTranslations['refunds'],
  'compliance-use' => $legalTranslations['compliance-use'],
  'compliance-policy' => $legalTranslations['compliance-policy'],
  'compliance-risk' => $legalTranslations['compliance-risk'],
  'compliance-security' => $legalTranslations['compliance-security'],
  'platform-sla' => $legalTranslations['platform-sla'],
  'platform-ip' => $legalTranslations['platform-ip'],
  'platform-copyright' => $legalTranslations['platform-copyright'],
  'technology-architecture' => $legalTranslations['technology-architecture'],
  'privacy' => $legalTranslations['privacy'],
  'terms' => $legalTranslations['terms'],

  // Blog
  'blog' => [
    'title' => 'Blog',
    'description' => 'Discover the latest insights, news, and articles from our team',
    'all_posts' => 'All Posts',
    'categories' => 'Categories',
    'tags' => 'Tags',
    'no_posts' => 'No posts found',
    'error_loading' => 'There was an error loading the blog posts. Please try again later.',
    'previous' => 'Previous',
    'next' => 'Next',
    'page' => 'Page',
    'pagination' => 'Blog pagination',
    'post' => 'Post',
    'min_read' => 'min read',
    'available_in' => 'This post is also available in',
    'share' => 'Share',
    'related_posts' => 'Related Posts',
    'read_more' => 'Read more',
  ]
];
