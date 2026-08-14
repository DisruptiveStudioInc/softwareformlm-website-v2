<?php

use App\Models\Language;

return [
  // SERVICES CATEGORY - Blockchain subcategory
  'contratos-inteligentes' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'blockchain',
    'icon' => 'contracts-service-main',
    'template' => 'service-type-1',
    'content_file' => 'contratos-inteligentes',
    'es' => [
      'slug' => 'contratos-inteligentes',
      'meta_title' => 'Contratos inteligentes',
      'meta_description' => 'Desarrollamos contratos inteligentes seguros para automatizar acuerdos, pagos y procesos empresariales con trazabilidad en blockchain.',
    ],
    'en' => [
      'slug' => 'smart-contracts',
      'meta_title' => 'Smart Contracts',
      'meta_description' => 'We develop secure smart contracts to automate agreements, payments, and business processes with blockchain traceability.',
    ],
  ],

  'aplicaciones-web3' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'blockchain',
    'icon' => 'web3-service-main',
    'template' => 'service-type-1',
    'content_file' => 'aplicaciones-web3',
    'es' => [
      'slug' => 'aplicaciones-web3',
      'meta_title' => 'Aplicaciones web3',
      'meta_description' => 'Creamos aplicaciones Web3 descentralizadas, seguras y escalables para transformar operaciones y experiencias digitales.',
    ],
    'en' => [
      'slug' => 'web3-applications',
      'meta_title' => 'Web3 Applications',
      'meta_description' => 'We build decentralized, secure, and scalable Web3 applications that transform digital operations and experiences.',
    ],
  ],

  'bases-datos-seguras' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'blockchain',
    'icon' => 'dbsecure-service-main',
    'template' => 'service-type-1',
    'content_file' => 'bases-datos-seguras',
    'es' => [
      'slug' => 'bases-de-datos-seguras',
      'meta_title' => 'Bases de datos seguras',
      'meta_description' => 'Implementamos bases de datos seguras que protegen la integridad, disponibilidad y trazabilidad de la información de tu negocio.',
    ],
    'en' => [
      'slug' => 'secure-databases',
      'meta_title' => 'Secure Databases',
      'meta_description' => 'We implement secure databases that protect the integrity, availability, and traceability of your business information.',
    ],
  ],

  'tokenizacion-proyectos' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'blockchain',
    'icon' => 'tokenization-service-main',
    'template' => 'service-type-1',
    'content_file' => 'tokenizacion-proyectos',
    'es' => [
      'slug' => 'tokenizacion-de-proyectos',
      'meta_title' => 'Tokenización de proyectos',
      'meta_description' => 'Tokenizamos proyectos y activos con respaldo legal, integración blockchain y acceso a liquidez global.',
    ],
    'en' => [
      'slug' => 'projects-tokenization',
      'meta_title' => 'Projects Tokenization',
      'meta_description' => 'We tokenize projects and assets with legal backing, blockchain integration, and access to global liquidity.',
    ],
  ],

  // SERVICES CATEGORY - Custom Software subcategory
  'aplicaciones-moviles' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'custom-software',
    'icon' => 'mobile-service-main',
    'template' => 'service-type-1',
    'content_file' => 'aplicaciones-moviles',
    'es' => [
      'slug' => 'aplicaciones-moviles',
      'meta_title' => 'Aplicaciones móviles',
      'meta_description' => 'Desarrollamos aplicaciones móviles personalizadas, inteligentes y escalables para impulsar la conexión y el crecimiento de tu negocio.',
    ],
    'en' => [
      'slug' => 'mobile-applications',
      'meta_title' => 'Mobile Applications',
      'meta_description' => 'We develop customized, intelligent, and scalable mobile applications to boost your business growth and engagement.',
    ],
  ],

  'aplicaciones-web' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'custom-software',
    'icon' => 'appweb-service-main',
    'template' => 'service-type-1',
    'content_file' => 'aplicaciones-web',
    'es' => [
      'slug' => 'aplicaciones-web',
      'meta_title' => 'Aplicaciones web',
      'meta_description' => 'Creamos aplicaciones web seguras y a medida para optimizar la gestión, comunicación y crecimiento empresarial.',
    ],
    'en' => [
      'slug' => 'web-applications',
      'meta_title' => 'Web Applications',
      'meta_description' => 'We create secure, custom web applications that optimize business management, communication, and growth.',
    ],
  ],

  // 'aplicaciones-hibridas' => [
  //   'category' => 'services',
  //   'subcategory' => 'custom-software',
  //   'template' => 'service-type-1',
  //   'content_file' => 'aplicaciones-hibridas',
  //   'es' => [
  //     'slug' => 'aplicaciones-hibridas',
  //     'meta_title' => 'Aplicaciones híbridas',
  //     'meta_description' => 'Desarrollamos aplicaciones híbridas que unifican experiencias web y móviles con rendimiento y escalabilidad.',
  //   ],
  //   'en' => [
  //     'slug' => 'hybrid-applications',
  //     'meta_title' => 'Hybrid Applications',
  //     'meta_description' => 'We develop hybrid applications that unify web and mobile experiences with performance and scalability.',
  //   ],
  // ],

  'aplicaciones-multitenant' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'custom-software',
    'icon' => 'multitenant-service-main',
    'template' => 'service-type-1',
    'content_file' => 'aplicaciones-multitenant',
    'es' => [
      'slug' => 'aplicaciones-multitenant',
      'meta_title' => 'Aplicaciones Multi-tenant',
      'meta_description' => 'Diseñamos plataformas multi-tenant para gestionar múltiples marcas, usuarios y operaciones desde un solo sistema.',
    ],
    'en' => [
      'slug' => 'multitenant-applications',
      'meta_title' => 'Multitenant Applications',
      'meta_description' => 'We design multitenant platforms to manage multiple brands, users, and operations from one system.',
    ],
  ],

  // SERVICES CATEGORY - Payment Processing subcategory
  'procesamiento-criptomonedas' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'payment-processing',
    'icon' => 'cryptoprocess-service-main',
    'template' => 'service-type-1',
    'content_file' => 'procesamiento-criptomonedas',
    'es' => [
      'slug' => 'procesamiento-criptomonedas',
      'meta_title' => 'Procesamiento de criptomonedas',
      'meta_description' => 'Integramos procesamiento de criptomonedas seguro para recibir, administrar y automatizar pagos digitales.',
    ],
    'en' => [
      'slug' => 'cryptocurrency-processing',
      'meta_title' => 'Cryptocurrency Processing',
      'meta_description' => 'We integrate secure cryptocurrency processing to receive, manage, and automate digital payments.',
    ],
  ],

  'pagos-masivos' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'payment-processing',
    'icon' => 'payment-service-main',
    'template' => 'service-type-1',
    'content_file' => 'pagos-masivos',
    'es' => [
      'slug' => 'pagos-masivos',
      'meta_title' => 'Pagos masivos',
      'meta_description' => 'Automatizamos pagos masivos seguros y precisos para simplificar la gestión financiera de tu operación.',
    ],
    'en' => [
      'slug' => 'massive-payments',
      'meta_title' => 'Massive payments',
      'meta_description' => 'We automate secure, precise mass payouts to simplify your operation’s financial management.',
    ],
  ],

  'cripto-fiat' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'payment-processing',
    'icon' => 'crypto-service-main',
    'template' => 'service-type-1',
    'content_file' => 'cripto-fiat',
    'es' => [
      'slug' => 'cripto-fiat',
      'meta_title' => 'Cripto/Fiat',
      'meta_description' => 'Conectamos operaciones cripto y fiat para gestionar pagos y transacciones sin límites entre ambos ecosistemas.',
    ],
    'en' => [
      'slug' => 'crypto-fiat',
      'meta_title' => 'Crypto/Fiat',
      'meta_description' => 'We connect crypto and fiat operations to manage payments and transactions across both ecosystems.',
    ],
  ],

  // SERVICES CATEGORY - Referral Marketing subcategory
  'mlm-software' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'referral-marketing',
    'icon' => 'mlm-service-main',
    'template' => 'service-type-1',
    'content_file' => 'mlm-software',
    'es' => [
      'slug' => 'mlm-software',
      'meta_title' => 'MLM Software',
      'meta_description' => 'Impulsa tu red multinivel con software MLM seguro, profesional y diseñado para escalar.',
    ],
    'en' => [
      'slug' => 'mlm-software',
      'meta_title' => 'MLM Software',
      'meta_description' => 'Grow your multilevel network with secure, professional MLM software built to scale.',
    ],
  ],

  'ecommerce' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'referral-marketing',
    'icon' => 'ecommerce-service-main',
    'template' => 'service-type-1',
    'content_file' => 'ecommerce',
    'es' => [
      'slug' => 'ecommerce',
      'meta_title' => 'E-Commerce',
      'meta_description' => 'Creamos plataformas e-commerce seguras y personalizadas para vender más y hacer crecer tu negocio.',
    ],
    'en' => [
      'slug' => 'ecommerce',
      'meta_title' => 'E-Commerce',
      'meta_description' => 'We create secure, customized e-commerce platforms designed to sell more and grow your business.',
    ],
  ],

  'elearning' => [
    'isActive' => false,
    'category' => 'services',
    'subcategory' => 'referral-marketing',
    'icon' => 'elearning-service-main',
    'template' => 'service-type-1',
    'content_file' => 'elearning',
    'es' => [
      'slug' => 'elearning',
      'meta_title' => 'E-Learning',
      'meta_description' => 'Desarrollamos plataformas e-learning que transforman el aprendizaje con experiencias digitales innovadoras.',
    ],
    'en' => [
      'slug' => 'elearning',
      'meta_title' => 'E-Learning',
      'meta_description' => 'We develop e-learning platforms that transform learning through innovative digital experiences.',
    ],
  ],

  'financial' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'referral-marketing',
    'icon' => 'financial-service-main',
    'template' => 'service-type-1',
    'content_file' => 'financial',
    'es' => [
      'slug' => 'financial',
      'meta_title' => 'Financial',
      'meta_description' => 'Ofrecemos soluciones financieras digitales para administrar tus finanzas con precisión, agilidad y control.',
    ],
    'en' => [
      'slug' => 'financial',
      'meta_title' => 'Financial',
      'meta_description' => 'We provide digital financial solutions to manage your finances with precision, agility, and control.',
    ],
  ],

  // SERVICES CATEGORY - Creative Services subcategory
  'ui-ux' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'creative-services',
    'icon' => 'ux-service-main',
    'template' => 'service-type-1',
    'content_file' => 'ui-ux',
    'es' => [
      'slug' => 'ui-ux',
      'meta_title' => 'UI/UX',
      'meta_description' => 'Diseñamos interfaces UI/UX funcionales y atractivas que mejoran la experiencia, conversión y retención de usuarios.',
    ],
    'en' => [
      'slug' => 'ui-ux',
      'meta_title' => 'UI/UX',
      'meta_description' => 'We design functional, appealing UI/UX interfaces that improve user experience, conversion, and retention.',
    ],
  ],

  'graphic-design' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'creative-services',
    'icon' => 'graphic-service-main',
    'template' => 'service-type-1',
    'content_file' => 'graphic-design',
    'es' => [
      'slug' => 'diseno-grafico',
      'meta_title' => 'Diseño gráfico',
      'meta_description' => 'Creamos identidades visuales y piezas gráficas memorables que hacen destacar a tu marca.',
    ],
    'en' => [
      'slug' => 'graphic-design',
      'meta_title' => 'Graphic Design',
      'meta_description' => 'We create memorable visual identities and graphic assets that make your brand stand out.',
    ],
  ],

  'web-design' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'creative-services',
    'icon' => 'web-service-main',
    'template' => 'service-type-1',
    'content_file' => 'web-design',
    'es' => [
      'slug' => 'diseno-web',
      'meta_title' => 'Diseño web',
      'meta_description' => 'Diseñamos sitios web estratégicos y funcionales que conectan con tu audiencia e impulsan el crecimiento.',
    ],
    'en' => [
      'slug' => 'web-design',
      'meta_title' => 'Web Design',
      'meta_description' => 'We design strategic, high-performing websites that connect with your audience and drive growth.',
    ],
  ],

  'multimedia' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'creative-services',
    'icon' => 'multimedia-service-main',
    'template' => 'service-type-1',
    'content_file' => 'multimedia',
    'es' => [
      'slug' => 'multimedia',
      'meta_title' => 'Multimedia',
      'meta_description' => 'Producimos contenido audiovisual impactante para dar vida a tu marca y conectar con tu audiencia.',
    ],
    'en' => [
      'slug' => 'multimedia',
      'meta_title' => 'Multimedia',
      'meta_description' => 'We produce impactful audiovisual content to bring your brand to life and engage your audience.',
    ],
  ],

  // SERVICES CATEGORY - HR subcategory
  'talento-captacion' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'hr',
    'icon' => 'talent-service-main',
    'template' => 'service-type-1',
    'content_file' => 'talento-captacion',
    'es' => [
      'slug' => 'talento-y-captacion',
      'meta_title' => 'Talento y captación',
      'meta_description' => 'Conectamos empresas con talento estratégico para formar equipos que impulsen su crecimiento.',
    ],
    'en' => [
      'slug' => 'talent-acquisition',
      'meta_title' => 'Talent Acquisition',
      'meta_description' => 'We connect companies with strategic talent to build teams that drive growth.',
    ],
  ],

  'formacion-desarrollo' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'hr',
    'icon' => 'formacion-service-main',
    'template' => 'service-type-1',
    'content_file' => 'formacion-desarrollo',
    'es' => [
      'slug' => 'formacion-y-desarrollo',
      'meta_title' => 'Formación y desarrollo',
      'meta_description' => 'Creamos programas de formación estratégica para desarrollar liderazgo y potenciar el desempeño de tu equipo.',
    ],
    'en' => [
      'slug' => 'training-and-development',
      'meta_title' => 'Training and Development',
      'meta_description' => 'We create strategic training programs that develop leadership and strengthen team performance.',
    ],
  ],

  'gestion-talento' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'hr',
    'icon' => 'gestion-service-main',
    'template' => 'service-type-1',
    'content_file' => 'gestion-talento',
    'es' => [
      'slug' => 'gestion-del-talento',
      'meta_title' => 'Gestión del talento',
      'meta_description' => 'Gestionamos talento y cultura organizacional para construir equipos comprometidos y orientados a resultados.',
    ],
    'en' => [
      'slug' => 'talent-management',
      'meta_title' => 'Talent Management',
      'meta_description' => 'We manage talent and organizational culture to build engaged, results-driven teams.',
    ],
  ],

  'recruitment' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'hr',
    'icon' => 'reclutamiento-service-main',
    'template' => 'service-type-1',
    'content_file' => 'recruitment',
    'es' => [
      'slug' => 'reclutamiento',
      'meta_title' => 'Reclutamiento',
      'meta_description' => 'Conectamos talento y oportunidades para convertir cada contratación en un impulso estratégico para tu empresa.',
    ],
    'en' => [
      'slug' => 'recruitment',
      'meta_title' => 'Recruitment',
      'meta_description' => 'We connect talent and opportunities to turn every hire into a strategic boost for your company.',
    ],
  ],

  // SERVICES CATEGORY - Manufacturing subcategory
  'supplements' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'manufacturing',
    'icon' => 'supplements-service-main',
    'template' => 'service-type-1',
    'content_file' => 'supplements',
    'es' => [
      'slug' => 'servicios-integrales-en-suplementos',
      'meta_title' => 'Servicios integrales en suplementos',
      'meta_description' => 'Desarrollamos y regulamos suplementos seguros con soluciones integrales para llevar tu producto al mercado.',
    ],
    'en' => [
      'slug' => 'integral-services-in-supplements',
      'meta_title' => 'Integral Services in Supplements',
      'meta_description' => 'We develop and regulate safe supplements with end-to-end solutions to bring your product to market.',
    ],
  ],

  'package-design' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'manufacturing',
    'icon' => 'package-service-main',
    'template' => 'service-type-1',
    'content_file' => 'package-design',
    'es' => [
      'slug' => 'diseno-de-empaque',
      'meta_title' => 'Diseño de empaque',
      'meta_description' => 'Creamos empaques atractivos y funcionales que fortalecen tu producto y lo preparan para competir.',
    ],
    'en' => [
      'slug' => 'package-design',
      'meta_title' => 'Package Design',
      'meta_description' => 'We create attractive, functional packaging that strengthens your product and prepares it to compete.',
    ],
  ],

  // SERVICES CATEGORY - Customer support subcategory
  'client-support' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'customer-support',
    'icon' => 'support-service-main',
    'template' => 'service-type-1',
    'content_file' => 'client-support',
    'es' => [
      'slug' => 'atencion-y-soporte-al-cliente',
      'meta_title' => 'Atención y soporte al cliente',
      'meta_description' => 'Ofrecemos atención y soporte multicanal confiable para acompañar a tus clientes y operaciones.',
    ],
    'en' => [
      'slug' => 'client-support',
      'meta_title' => 'Client Support',
      'meta_description' => 'We provide reliable multichannel customer service and support for your clients and operations.',
    ],
  ],

  'case-management' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'customer-support',
    'icon' => 'cases-service-main',
    'template' => 'service-type-1',
    'content_file' => 'case-management',
    'es' => [
      'slug' => 'gestion-de-casos-y-solicitudes',
      'meta_title' => 'Gestión de casos y solicitudes',
      'meta_description' => 'Centralizamos tickets y solicitudes para priorizar, resolver y dar trazabilidad a cada caso.',
    ],
    'en' => [
      'slug' => 'case-and-request-management',
      'meta_title' => 'Case and Request Management',
      'meta_description' => 'We centralize tickets and requests to prioritize, resolve, and track every case.',
    ],
  ],

  'support-training' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'customer-support',
    'icon' => 'training-service-main',
    'template' => 'service-type-1',
    'content_file' => 'support-training',
    'es' => [
      'slug' => 'implementacion-y-capacitacion-de-equipos',
      'meta_title' => 'Implementación y capacitación de equipos',
      'meta_description' => 'Capacitamos equipos en procesos, herramientas y comunicación para resolver problemas con mayor efectividad.',
    ],
    'en' => [
      'slug' => 'support-training',
      'meta_title' => 'Support Training',
      'meta_description' => 'We train teams in processes, tools, and communication for more effective problem-solving.',
    ],
  ],

  // SERVICES CATEGORY - legal subcategory
  'legal-financial' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'legal-services',
    'icon' => 'corporate-service-main',
    'template' => 'service-type-1',
    'content_file' => 'legal-financial',
    'es' => [
      'slug' => 'derecho-corporativo-y-financiero',
      'meta_title' => 'Derecho corporativo y financiero',
      'meta_description' => 'Brindamos asesoría en derecho corporativo y financiero para operaciones empresariales seguras y transparentes.',
    ],
    'en' => [
      'slug' => 'corporate-and-financial-law',
      'meta_title' => 'Corporate and Financial Law',
      'meta_description' => 'We provide corporate and financial legal counsel for secure, transparent business operations.',
    ],
  ],

  'legal-realestate' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'legal-services',
    'icon' => 'realestate-service-main',
    'template' => 'service-type-1',
    'content_file' => 'legal-realestate',
    'es' => [
      'slug' => 'derecho-inmobiliario-y-construccion',
      'meta_title' => 'Derecho inmobiliario y construcción',
      'meta_description' => 'Ofrecemos gestión jurídica especializada para proyectos, operaciones inmobiliarias y construcción.',
    ],
    'en' => [
      'slug' => 'real-estate-and-construction-law',
      'meta_title' => 'Real Estate and Construction Law',
      'meta_description' => 'We provide specialized legal management for real estate projects, transactions, and construction.',
    ],
  ],

  'intellectual-property' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'legal-services',
    'icon' => 'intellectual-service-main',
    'template' => 'service-type-1',
    'content_file' => 'intellectual-property',
    'es' => [
      'slug' => 'propiedad-intelectual-y-tecnologia',
      'meta_title' => 'Propiedad intelectual y tecnología',
      'meta_description' => 'Protegemos legalmente software, ideas y activos de propiedad intelectual para impulsar tu innovación.',
    ],
    'en' => [
      'slug' => 'intellectual-property-and-technology',
      'meta_title' => 'Intellectual Property and Technology',
      'meta_description' => 'We legally protect software, ideas, and intellectual property assets to support your innovation.',
    ],
  ],

  'litigation' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'legal-services',
    'icon' => 'litigation-service-main',
    'template' => 'service-type-1',
    'content_file' => 'litigation',
    'es' => [
      'slug' => 'litigio',
      'meta_title' => 'Litigio',
      'meta_description' => 'Defendemos tus intereses con litigio estratégico y resolución efectiva de conflictos y contingencias.',
    ],
    'en' => [
      'slug' => 'litigation',
      'meta_title' => 'Litigation',
      'meta_description' => 'We defend your interests through strategic litigation and effective dispute resolution.',
    ],
  ],

  // SERVICES CATEGORY - logistics subcategory
  'storage-inventory' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'logistics',
    'icon' => 'storage-service-main',
    'template' => 'service-type-1',
    'content_file' => 'storage-inventory',
    'es' => [
      'slug' => 'almacenaje-e-inventarios',
      'meta_title' => 'Almacenaje e inventarios',
      'meta_description' => 'Organizamos almacenes e inventarios con control, precisión y trazabilidad para optimizar tu operación.',
    ],
    'en' => [
      'slug' => 'storage-and-inventory',
      'meta_title' => 'Storage and Inventory',
      'meta_description' => 'We organize storage and inventory with control, accuracy, and traceability to optimize your operation.',
    ],
  ],

  'package-fulfillment' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'logistics',
    'icon' => 'fulfillment-service-main',
    'template' => 'service-type-1',
    'content_file' => 'package-fulfillment',
    'es' => [
      'slug' => 'empaque-y-fulfillment',
      'meta_title' => 'Empaque y fulfillment',
      'meta_description' => 'Preparamos y verificamos cada pedido con procesos ágiles para garantizar envíos precisos y eficientes.',
    ],
    'en' => [
      'slug' => 'package-fulfillment',
      'meta_title' => 'Package Fulfillment',
      'meta_description' => 'We prepare and verify every order through agile processes for precise, efficient fulfillment.',
    ],
  ],

  'shipment-distribution' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'logistics',
    'icon' => 'shipment-service-main',
    'template' => 'service-type-1',
    'content_file' => 'shipment-distribution',
    'es' => [
      'slug' => 'envio-y-distribucion',
      'meta_title' => 'Envío y distribución',
      'meta_description' => 'Gestionamos envíos y distribución nacional e internacional con logística segura y puntual.',
    ],
    'en' => [
      'slug' => 'shipment-and-distribution',
      'meta_title' => 'Shipment and Distribution',
      'meta_description' => 'We manage national and international shipping and distribution with secure, timely logistics.',
    ],
  ],

  'logistic-optimization' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'logistics',
    'icon' => 'logistic-service-main',
    'template' => 'service-type-1',
    'content_file' => 'logistic-optimization',
    'es' => [
      'slug' => 'optimizacion-logistica',
      'meta_title' => 'Optimización logística',
      'meta_description' => 'Optimizamos tu logística con soluciones a medida para una operación más ágil, precisa y rentable.',
    ],
    'en' => [
      'slug' => 'logistic-optimization',
      'meta_title' => 'Logistic Optimization',
      'meta_description' => 'We optimize logistics with tailored solutions for more agile, accurate, and profitable operations.',
    ],
  ],

  'operation-consulting' => [
    'isActive' => true,
    'category' => 'services',
    'subcategory' => 'logistics',
    'icon' => 'operation-service-main',
    'template' => 'service-type-1',
    'content_file' => 'operation-consulting',
    'es' => [
      'slug' => 'consultoria-operativa',
      'meta_title' => 'Consultoría operativa',
      'meta_description' => 'Evaluamos y mejoramos tu operación logística para aumentar eficiencia, control y resultados.',
    ],
    'en' => [
      'slug' => 'operation-consulting',
      'meta_title' => 'Operation Consulting',
      'meta_description' => 'We assess and improve logistics operations to increase efficiency, control, and results.',
    ],
  ],

  // SERVICES CATEGORY - financial subcategory
  'financial-management' => [
    'isActive' => false,
    'category' => 'services',
    'subcategory' => 'finance',
    'icon' => 'finmanagement-service-main',
    'template' => 'service-type-1',
    'content_file' => 'financial-management',
    'es' => [
      'slug' => 'administracion-financiera-operativa',
      'meta_title' => 'Administración financiera operativa',
      'meta_description' => 'Administramos finanzas operativas con control y visibilidad para sostener el crecimiento de tu negocio.',
    ],
    'en' => [
      'slug' => 'operational-financial-management',
      'meta_title' => 'Operational Financial Management',
      'meta_description' => 'We manage operational finances with control and visibility to support business growth.',
    ],
  ],

  'corporate-financial' => [
    'isActive' => false,
    'category' => 'services',
    'subcategory' => 'finance',
    'icon' => 'corpconsulting-service-main',
    'template' => 'service-type-1',
    'content_file' => 'corporate-financial',
    'es' => [
      'slug' => 'consultoria-financiera-y-corporativa',
      'meta_title' => 'Consultoría financiera y corporativa',
      'meta_description' => 'Brindamos consultoría financiera y corporativa para tomar decisiones estratégicas con confianza.',
    ],
    'en' => [
      'slug' => 'corporate-financial-consulting',
      'meta_title' => 'Corporate Financial Consulting',
      'meta_description' => 'We provide corporate and financial consulting for confident strategic decision-making.',
    ],
  ],

  'accounting-reporting' => [
    'isActive' => false,
    'category' => 'services',
    'subcategory' => 'finance',
    'icon' => 'accounting-service-main',
    'template' => 'service-type-1',
    'content_file' => 'accounting-reporting',
    'es' => [
      'slug' => 'contabilidad-y-reportes-financieros',
      'meta_title' => 'Contabilidad y reportes financieros',
      'meta_description' => 'Llevamos tu contabilidad y reportes financieros con control, claridad y visión para tu operación.',
    ],
    'en' => [
      'slug' => 'accounting-and-financial-reporting',
      'meta_title' => 'Accounting and Financial Reporting',
      'meta_description' => 'We handle accounting and financial reporting with control, clarity, and operational insight.',
    ],
  ],

  'taxes-compliance' => [
    'isActive' => false,
    'category' => 'services',
    'subcategory' => 'finance',
    'icon' => 'taxes-service-main',
    'template' => 'service-type-1',
    'content_file' => 'taxes-compliance',
    'es' => [
      'slug' => 'impuestos-y-cumplimiento-fiscal',
      'meta_title' => 'Impuestos y cumplimiento fiscal',
      'meta_description' => 'Gestionamos impuestos y cumplimiento fiscal para mantener tu operación clara, ordenada y al día.',
    ],
    'en' => [
      'slug' => 'taxes-and-fiscal-compliance',
      'meta_title' => 'Taxes and Fiscal Compliance',
      'meta_description' => 'We manage taxes and fiscal compliance to keep your operation clear, organized, and current.',
    ],
  ],

  // ECOSYSTEM CATEGORY (no subcategories)
  'crea' => [
    'isActive' => true,
    'category' => 'ecosystem',
    'template' => 'service-type-1',
    'content_file' => 'crea',
    'es' => [
      'slug' => 'crea',
      'meta_title' => 'CREA',
      'meta_description' => 'Descripción SEO del ecosistema 1',
    ],
    'en' => [
      'slug' => 'crea',
      'meta_title' => 'CREA',
      'meta_description' => 'SEO description of ecosystem 1',
    ],
  ],

  'exchange' => [
    'isActive' => true,
    'category' => 'ecosystem',
    'template' => 'service-type-1',
    'content_file' => 'exchange',
    'es' => [
      'slug' => 'exchange',
      'meta_title' => 'Exchange',
      'meta_description' => 'Descripción SEO del ecosistema 2',
    ],
    'en' => [
      'slug' => 'exchange',
      'meta_title' => 'Exchange',
      'meta_description' => 'SEO description of ecosystem 2',
    ],
  ],

  'law' => [
    'isActive' => true,
    'category' => 'ecosystem',
    'template' => 'service-type-1',
    'content_file' => 'law',
    'es' => [
      'slug' => 'law',
      'meta_title' => 'Law',
      'meta_description' => 'Descripción SEO del ecosistema 3',
    ],
    'en' => [
      'slug' => 'law',
      'meta_title' => 'Law',
      'meta_description' => 'SEO description of ecosystem 3',
    ],
  ],

  'payments' => [
    'isActive' => true,
    'category' => 'ecosystem',
    'template' => 'service-type-1',
    'content_file' => 'payments',
    'es' => [
      'slug' => 'payments',
      'meta_title' => 'Payments',
      'meta_description' => 'Descripción SEO del ecosistema 4',
    ],
    'en' => [
      'slug' => 'payments',
      'meta_title' => 'Payments',
      'meta_description' => 'SEO description of ecosystem 4',
    ],
  ],

  'talent' => [
    'isActive' => true,
    'category' => 'ecosystem',
    'template' => 'service-type-1',
    'content_file' => 'talent',
    'es' => [
      'slug' => 'talent',
      'meta_title' => 'Talent',
      'meta_description' => 'Descripción SEO del ecosistema 5',
    ],
    'en' => [
      'slug' => 'talent',
      'meta_title' => 'Talent',
      'meta_description' => 'SEO description of ecosystem 5',
    ],
  ],

  'corpsyte' => [
    'isActive' => true,
    'category' => 'ecosystem',
    'template' => 'service-type-1',
    'content_file' => 'corpsyte',
    'es' => [
      'slug' => 'corpsyte',
      'meta_title' => 'Corpsyte',
      'meta_description' => 'Descripción SEO del ecosistema 6',
    ],
    'en' => [
      'slug' => 'corpsyte',
      'meta_title' => 'Corpsyte',
      'meta_description' => 'SEO description of ecosystem 6',
    ],
  ],

  'logistics' => [
    'isActive' => true,
    'category' => 'ecosystem',
    'template' => 'service-type-1',
    'content_file' => 'logistics',
    'es' => [
      'slug' => 'logistics',
      'meta_title' => 'Logistics',
      'meta_description' => 'Descripción SEO del ecosistema 6',
    ],
    'en' => [
      'slug' => 'logistics',
      'meta_title' => 'Logistics',
      'meta_description' => 'SEO description of ecosystem 6',
    ],
  ],

  // IPs CATEGORY (no subcategories)
    'backoffice' => [
    'isActive' => false,
    'inNav' => false,
    'category' => 'ips',
    'template' => 'service-type-2',
    'content_file' => 'backoffice',
    'es' => [
      'slug' => 'backoffice',
      'meta_title' => 'Backoffice',
      'meta_description' =>  Language::trans('ips.backoffice'),
    ],
    'en' => [
      'slug' => 'backoffice',
      'meta_title' => 'Backoffice',
      'meta_description' =>  Language::trans('ips.backoffice'),
    ],
  ],

  'blockchain' => [
    'isActive' => true,
    'inNav' => false,
    'category' => 'ips',
    'template' => 'service-type-2',
    'content_file' => 'blockchain',
    'es' => [
      'slug' => 'blockchain',
      'meta_title' => 'Blockchain',
      'meta_description' => Language::trans('ips.blockchain'),
    ],
    'en' => [
      'slug' => 'blockchain',
      'meta_title' => 'Blockchain',
      'meta_description' => Language::trans('ips.blockchain'),
    ],
  ],

  'tokenization' => [
    'isActive' => true,
    'inNav' => false,
    'category' => 'ips',
    'template' => 'service-type-2',
    'content_file' => 'tokenization',
    'es' => [
      'slug' => 'tokenization',
      'meta_title' => 'Tokenization',
      'meta_description' => Language::trans('ips.tokenization'),
    ],
    'en' => [
      'slug' => 'tokenization',
      'meta_title' => 'Tokenization',
      'meta_description' => Language::trans('ips.tokenization'),
    ],
  ],

  'otc' => [
    'isActive' => true,
    'inNav' => false,
    'category' => 'ips',
    'template' => 'service-type-2',
    'content_file' => 'otc',
    'es' => [
      'slug' => 'exchange-otc',
      'meta_title' => 'Exchange OTC',
      'meta_description' => Language::trans('ips.exchange'),
    ],
    'en' => [
      'slug' => 'exchange-otc',
      'meta_title' => 'Exchange OTC',
      'meta_description' => Language::trans('ips.exchange'),
    ],
  ],

  'processing' => [
    'isActive' => true,
    'inNav' => false,
    'category' => 'ips',
    'template' => 'service-type-2',
    'content_file' => 'processing',
    'es' => [
      'slug' => 'payment-processing',
      'meta_title' => 'Payment Processing',
      'meta_description' => Language::trans('ips.processing'),
    ],
    'en' => [
      'slug' => 'payment-processing',
      'meta_title' => 'Payment Processing',
      'meta_description' => Language::trans('ips.processing'),
    ],
  ],

  'wallet' => [
    'isActive' => true,
    'inNav' => false,
    'category' => 'ips',
    'template' => 'service-type-2',
    'content_file' => 'wallet',
    'es' => [
      'slug' => 'wallet',
      'meta_title' => 'Wallet',
      'meta_description' => Language::trans('ips.wallet'),
    ],
    'en' => [
      'slug' => 'wallet',
      'meta_title' => 'Wallet',
      'meta_description' => Language::trans('ips.wallet'),
    ],
  ],

  'metaverse' => [
    'isActive' => false,
    'inNav' => true,
    'category' => 'ips',
    'template' => 'service-type-2',
    'content_file' => 'metaverse',
    'es' => [
      'slug' => 'metaverso',
      'meta_title' => 'Metaverso, VR y XR',
      'meta_description' => Language::trans('ips.metaverse'),
    ],
    'en' => [
      'slug' => 'metaverse',
      'meta_title' => 'Metaverse, VR and XR',
      'meta_description' => Language::trans('ips.metaverse'),
    ],
  ],
];
