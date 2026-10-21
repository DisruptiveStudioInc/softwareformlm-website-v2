# Disruptive Studio Website

A multilingual corporate website for Disruptive Studio, showcasing their services, work processes, and company information. Built with PHP 8.3, Tailwind CSS, and GSAP animations.

## Table of Contents

- [Project Overview](#project-overview)
- [Technology Stack](#technology-stack)
- [Getting Started](#getting-started)
- [Project Structure](#project-structure)
- [Internationalization (i18n)](#internationalization-i18n)
- [Routing System](#routing-system)
- [Services Management](#services-management)
- [Static Pages](#static-pages)
- [Markdown Blog](#markdown-blog)
- [Contact Form & Email](#contact-form--email)
- [Frontend Development](#frontend-development)
- [Configuration](#configuration)
- [GoHighLevel Exit-Intent Integration](#gohighlevel-exit-intent-integration)
- [Deployment](#deployment)

---

## Project Overview

This is a professional corporate website for Disruptive Studio that features:

- **Multilingual support** (Spanish and English)
- **Dynamic service pages** with different templates
- **Git-managed Markdown blog** with bilingual content
- **Contact form** with reCAPTCHA v3 validation
- **Responsive design** using Tailwind CSS 4
- **Smooth animations** with GSAP
- **SEO-optimized** pages with custom meta tags per language

---

## Technology Stack

### Backend

- **PHP 8.3+**
- **Composer** for dependency management
- **PHPMailer** for email functionality
- **phpdotenv** for environment configuration
- **Guzzle HTTP Client** for external API communication

### Frontend

- **Tailwind CSS 4** for styling
- **GSAP 3** for animations
- **Vanilla JavaScript** for interactivity

### Development

- **Docker** for containerization
- **pnpm** for Node.js package management
- **Nginx** as web server

---

## Getting Started

### Prerequisites

- Docker & Docker Compose
- pnpm (or npm)
- Composer (optional, handled by Docker)

### Installation

1. **Clone the repository**

```bash
git clone <repository-url>
cd disruptivestudio-website
```

2. **Create environment file**

```bash
cp .env.example .env
```

Edit `.env` with your configuration:

```env
APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost:8080

MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@disruptivestudio.com
MAIL_FROM_NAME="Disruptive Studio"
MAIL_TO_ADDRESS=contact@disruptivestudio.com

RECAPTCHA_SITE_KEY=your-site-key
RECAPTCHA_SECRET_KEY=your-secret-key
RECAPTCHA_SCORE_THRESHOLD=0.5

```

3. **Install PHP dependencies**

```bash
docker-compose run --rm composer install
```

4. **Install Node.js dependencies**

```bash
pnpm install
```

5. **Build CSS**

```bash
# For development (with watch mode)
pnpm run dev

# For production (minified)
pnpm run build
```

6. **Start Docker containers**

```bash
docker-compose up -d
```

7. **Access the website**
   Open your browser and navigate to: `http://localhost:8080`

---

## Project Structure

```
disruptivestudio-website/
├── app/
│   ├── Controllers/        # Request handlers
│   │   ├── BaseController.php
│   │   ├── HomeController.php
│   │   ├── ContactController.php
│   │   ├── ServiceController.php
│   │   └── ErrorController.php
│   ├── Models/            # Data models
│   │   ├── Contact.php
│   │   ├── Language.php
│   │   └── Service.php
│   └── Views/             # View templates
│       ├── components/    # Reusable components
│       ├── layouts/       # Layout templates
│       ├── sections/      # Page sections
│       └── templates/     # Page templates
├── config/
│   ├── config.php         # Main configuration
│   ├── routes.php         # Route definitions
│   ├── route-translations.php  # Route name translations
│   ├── services.php       # Service definitions
│   ├── subcategories.php  # Service subcategories
│   └── constants.php      # Application constants
├── content/
│   ├── pages/            # Static page content
│   │   ├── home.php
│   │   └── contact.php
│   └── services/         # Service page content
│       ├── aplicaciones-web3.php
│       ├── contratos-inteligentes.php
│       └── ...
├── lang/
│   ├── en.php            # English translations
│   ├── es.php            # Spanish translations
│   └── services/         # Service-specific translations
│       ├── web3_app.php
│       └── ...
├── public/
│   ├── assets/
│   │   ├── css/          # Compiled CSS
│   │   └── js/           # JavaScript files
│   └── images/           # Image assets
├── src/
│   ├── Router.php        # Custom router
│   ├── Request.php       # HTTP request handler
│   ├── Response.php      # HTTP response handler
│   ├── Mailer.php        # Email service
│   ├── Recaptcha.php     # reCAPTCHA validation
│   └── helpers.php       # Helper functions
├── vendor/               # Composer dependencies
├── .env                  # Environment variables
├── composer.json         # PHP dependencies
├── package.json          # Node.js dependencies
├── docker-compose.yml    # Docker configuration
├── Dockerfile           # Docker image definition
└── index.php            # Application entry point
```

---

## Internationalization (i18n)

The website supports multiple languages with a custom translation system.

### Current Languages

- **Spanish (es)** - Default URL without prefix
- **English (en)**

### How It Works

1. **First-Visit Language Detection**: The router negotiates language only when the `site_language` cookie does not exist yet

- First explicit English entry: `https://domain.com/en/...` selects English immediately and saves it
- First unprefixed entry with `Accept-Language: es` or `es-*`: serves the Spanish canonical URL
- First unprefixed entry with `Accept-Language: en` or any other language: redirects to the English canonical URL under `/en/...`
- After that first visit, the router uses the saved `site_language` cookie and does not negotiate from browser headers again

2. **Canonical URL Scheme**:

- Spanish canonical URLs are unprefixed: `https://domain.com/`, `https://domain.com/politica-de-privacidad`
- English canonical URLs live under `/en`: `https://domain.com/en/`, `https://domain.com/en/privacy-policy`
- If a saved language and requested URL do not match, the router redirects to the equivalent canonical URL
- Manual language changes from the switcher append `?set_lang=...`, persist the cookie, and immediately redirect to the clean translated URL

3. **Translation Files**: Located in `/lang/` directory

- `lang/es.php` - Spanish translations
- `lang/en.php` - English translations
- `lang/services/` - Service-specific translations

4. **Using Translations in Code**:

```php
use App\Models\Language;

// Get a translation
$text = Language::trans('nav.home');

// Get current language
$currentLang = Language::getCurrentLanguage();
```

### Adding a New Language

1. **Update configuration** in `config/config.php`:

```php
'languages' => [
  'default' => 'en',
  'available' => ['es', 'en', 'fr'], // Add new language code
  'names' => [
    'es' => 'Esp',
    'en' => 'Eng',
    'fr' => 'Fra'  // Add language name
  ]
],
```

2. **Create translation file** at `lang/fr.php`:

```php
<?php

$servicesTranslations = loadLangServices();

return [
  'nav' => [
    'home' => 'Accueil',
    'about' => 'À propos',
    // ... more translations
  ],
  // ... copy structure from es.php or en.php
];
```

3. **Add service translations** in `lang/services/` directory:

```php
// lang/services/web3_app.php
return [
  'fr' => [
    'hero' => [
      'title' => 'Applications Web3',
      // ... more translations
    ]
  ]
];
```

4. **Update route translations** in `config/route-translations.php`:

```php
return [
  'contact' => [
    'es' => 'contacto',
    'en' => 'contact',
    'fr' => 'contacter'  // Add French route
  ],
];
```

5. **Add service slugs** in `config/services.php`:

```php
'aplicaciones-web3' => [
  'es' => ['slug' => 'aplicaciones-web3', ...],
  'en' => ['slug' => 'web3-applications', ...],
  'fr' => ['slug' => 'applications-web3', ...],  // Add French slug
],
```

### Translation Helper Functions

Available in `src/helpers.php`:

```php
// Escape and translate
Language::trans('key.path');

// Load service-specific translations
loadLangServices();

// Get translated route
route('privacy', 'en'); // Returns /en/privacy-policy
```

---

## Routing System

The website uses a custom router with canonical language URLs, first-visit language detection, and persistent language cookies.

### How Routes Work

Routes are defined in `config/routes.php`:

```php
<?php

use App\Router;

return function(Router $router) {
  // Static pages
  $router->get('/', 'App\\Controllers\\HomeController', 'index');
  $router->get('/contact', 'App\\Controllers\\ContactController', 'index');

  // POST routes
  $router->post('/contact', 'App\\Controllers\\ContactController', 'submit');

  // Dynamic routes with parameters
  $router->get('/{slug}', 'App\\Controllers\\ServiceController', 'show');
};
```

### Language Resolution

The router resolves language in this order:

1. Manual language change through `?set_lang=es` or `?set_lang=en`
2. Saved `site_language` cookie
3. First-visit URL detection
4. First-visit `Accept-Language` fallback

This means browser language detection runs only on the first visit, then the saved cookie is used on later requests.

### Canonical URL Behavior

- Spanish routes are canonical without a prefix
- English routes are canonical under `/en/...`
- The router redirects to the equivalent translated URL when the saved language and requested URL do not match
- Static routes use `config/route-translations.php`
- Blog routes translate `/blog` and, when possible, individual blog post slugs between languages before redirecting

Examples:

- `/privacy-policy` can redirect to `/en/privacy-policy` for a first-time English visitor
- `/en/terms-and-conditions` can redirect to `/terminos-y-condiciones` for a user with a saved Spanish cookie
- Clicking the language switcher persists the new language and redirects to the clean translated URL

### Adding New Routes

1. **Define route** in `config/routes.php`:

```php
$router->get('/about', 'App\\Controllers\\AboutController', 'index');
```

2. **Create controller** in `app/Controllers/AboutController.php`:

```php
<?php

namespace App\Controllers;

use App\Request;
use App\Response;

class AboutController extends BaseController
{
  public function index(Request $request): Response
  {
    return $this->view('about', [
      'title' => 'About Us'
    ]);
  }
}
```

3. **Add route translations** in `config/route-translations.php`:

```php
'about' => [
  'es' => 'nosotros',
  'en' => 'about',
],
```

4. **Create view template** in `app/Views/templates/about.php`

### Route Parameters

Use curly braces for dynamic segments:

```php
// Match: /blog/my-post-slug
$router->get('/blog/{slug}', 'BlogController', 'show');

// Match: /user/123
$router->get('/user/{id}', 'UserController', 'show');

// Access in controller:
$slug = $request->getRouteParam('slug');
```

---

## Services Management

Services are the main dynamic content of the website. Each service is configured in `config/services.php` and can have different templates.

### Service Configuration Structure

```php
// config/services.php
'service-key' => [
  'isActive' => true,                    // Enable/disable service
  'category' => 'services',              // Category type
  'subcategory' => 'blockchain',         // Subcategory (for grouping)
  'icon' => 'service-icon-name',         // Icon identifier
  'template' => 'service-type-1',        // Template to use
  'content_file' => 'service-content',   // Content file name
  'es' => [
    'slug' => 'servicio-ejemplo',
    'meta_title' => 'Título SEO',
    'meta_description' => 'Descripción SEO',
  ],
  'en' => [
    'slug' => 'example-service',
    'meta_title' => 'SEO Title',
    'meta_description' => 'SEO Description',
  ],
],
```

### Adding a New Service

#### Step 1: Add Service Configuration

Edit `config/services.php` and add:

```php
'nuevo-servicio' => [
  'isActive' => true,
  'category' => 'services',
  'subcategory' => 'custom_software',  // See config/subcategories.php
  'icon' => 'new-service-icon',
  'template' => 'service-type-1',      // or 'service-type-2', 'service-type-3'
  'content_file' => 'nuevo-servicio',
  'es' => [
    'slug' => 'nuevo-servicio',
    'meta_title' => 'Nuevo Servicio | Disruptive Studio',
    'meta_description' => 'Descripción del nuevo servicio para SEO',
  ],
  'en' => [
    'slug' => 'new-service',
    'meta_title' => 'New Service | Disruptive Studio',
    'meta_description' => 'New service description for SEO',
  ],
],
```

#### Step 2: Create Content File

Create `content/services/nuevo-servicio.php`:

```php
<?php

use App\Models\Language;
$csLang = Language::getCurrentLanguage();
$sKey = "new_service.{$csLang}";

return [
  // Hero section
  'hero' => Language::trans("{$sKey}.hero.title"),
  'hero_text' => Language::trans("{$sKey}.hero.text"),
  'hero_images' => [
    'big' => 'new_service_1_big.webp',
    'small' => 'new_service_1_small.webp'
  ],

  // About sections
  'about1_title' => Language::trans("{$sKey}.about1"),
  'about1_images' => [
    'front' => 'new_service_2_front.webp',
    'back' => 'new_service_2_back.webp'
  ],

  'about2_title' => Language::trans("{$sKey}.about2"),
  'about2_text' => Language::trans("{$sKey}.about2_text"),
  'about2_images' => [
    'big' => 'new_service_3_big.webp',
    'mid' => 'new_service_3_mid.webp',
    'small' => 'new_service_3_small.webp'
  ],

  // Benefits list
  'benefits' => [
    [
      'image' => 'icon-name',
      'title' => Language::trans("{$sKey}.benefits.item1.title"),
      'text' => Language::trans("{$sKey}.benefits.item1.text"),
    ],
    // ... more benefits
  ],

  // Use cases
  'use_cases' => [
    [
      'title' => Language::trans("{$sKey}.use_cases.item1.title"),
      'text' => Language::trans("{$sKey}.use_cases.item1.text"),
    ],
    // ... more use cases
  ],
];
```

#### Step 3: Add Translations

Create `lang/services/new_service.php`:

```php
<?php

return [
  'es' => [
    'hero' => [
      'title' => 'Título del Servicio',
      'text' => 'Descripción del servicio',
    ],
    'about1' => 'Sección Acerca de 1',
    'about2' => 'Sección Acerca de 2',
    'about2_text' => 'Texto descriptivo',
    'benefits' => [
      'item1' => [
        'title' => 'Beneficio 1',
        'text' => 'Descripción del beneficio',
      ],
      // ... more items
    ],
    'use_cases' => [
      'item1' => [
        'title' => 'Caso de uso 1',
        'text' => 'Descripción',
      ],
      // ... more items
    ],
  ],
  'en' => [
    'hero' => [
      'title' => 'Service Title',
      'text' => 'Service description',
    ],
    // ... English translations
  ],
];
```

Then load it in both `lang/es.php` and `lang/en.php`:

```php
// Add at the top of the file
$servicesTranslations = loadLangServices();

return [
  // ... existing translations

  // Add service translations
  'new_service' => $servicesTranslations['new_service'][Language::getCurrentLanguage()],
];
```

#### Step 4: Add Images

Place images in `public/images/services/` directory with the names specified in your content file.

### Service Templates

Three template types are available:

1. **service-type-1**: Standard service template with hero, benefits, and use cases
2. **service-type-2**: Alternative layout with different section arrangements
3. **service-type-3**: Specialized template with custom sections

Templates are located in `app/Views/templates/`

### Modifying a Service

1. Update configuration in `config/services.php`
2. Update content in `content/services/{service-name}.php`
3. Update translations in `lang/services/{service-name}.php`
4. Replace images in `public/images/services/`

### Disabling a Service

Set `isActive` to `false` in `config/services.php`:

```php
'service-key' => [
  'isActive' => false,  // Service won't be accessible
  // ... rest of config
],
```

### Service Subcategories

Subcategories are defined in `config/subcategories.php` and used to group services. Update this file to add new subcategories.

---

## Static Pages

Static pages like Home and Contact are configured differently from services.

### Home Page

**Location**: `content/pages/home.php`

Structure:

```php
<?php

use App\Models\Language;
use App\Models\Service;

return [
  'seoDescription' => Language::trans('home.description'),

  // Hero slider
  'hero' => [
    [
      'title' => Language::trans('home.hero.slide1.title'),
      'text' => Language::trans('home.hero.slide1.text')
    ],
    // ... more slides
  ],

  // Discover section
  'discover' => [
    [
      'title' => Language::trans('home.discover_list.item1.title'),
      'text' => Language::trans('home.discover_list.item1.text'),
      'icon' => 'grow',
      'animation' => 'up'
    ],
    // ... more items
  ],

  // Other sections...
];
```

**Controller**: `app/Controllers/HomeController.php`

**View**: `app/Views/templates/home.php`

### Contact Page

**Location**: `content/pages/contact.php`

Structure:

```php
<?php

use App\Models\Language;

return [
  'seoDescription' => Language::trans('contact.description'),

  'hero' => Language::trans('contact.hero'),
  'hero_text' => Language::trans('contact.hero_text'),

  // Form fields configuration
  'form' => [
    'name' => Language::trans('contact.form.name'),
    'email' => Language::trans('contact.form.email'),
    // ... more fields
  ],
];
```

**Controller**: `app/Controllers/ContactController.php`

**View**: `app/Views/templates/contact.php`

### Creating a New Static Page

1. **Create content file** at `content/pages/new-page.php`:

```php
<?php

use App\Models\Language;

return [
  'seoDescription' => Language::trans('new_page.description'),
  'title' => Language::trans('new_page.title'),
  'content' => Language::trans('new_page.content'),
  // ... your page data
];
```

2. **Create controller** at `app/Controllers/NewPageController.php`:

```php
<?php

namespace App\Controllers;

use App\Request;
use App\Response;

class NewPageController extends BaseController
{
  public function index(Request $request): Response
  {
    $pageContent = $this->loadPageContent('new-page');

    return $this->view('new-page', [
      'content' => $pageContent,
      'metaDescription' => $pageContent['seoDescription'] ?? null
    ]);
  }
}
```

3. **Create view template** at `app/Views/templates/new-page.php`:

```php
<?php
$this->layout('layouts/main', [
  'title' => $content['title'],
  'description' => $meta['description'] ?? null,
]);
?>

<section class="page-section">
  <h1><?= esc($content['title']) ?></h1>
  <p><?= esc($content['content']) ?></p>
  <!-- Your page HTML -->
</section>
```

4. **Add route** in `config/routes.php`:

```php
$router->get('/new-page', 'App\\Controllers\\NewPageController', 'index');
```

5. **Add translations** in `lang/es.php` and `lang/en.php`:

```php
'new_page' => [
    'description' => 'Page description for SEO',
    'title' => 'Page Title',
    'content' => 'Page content...',
],
```

6. **Add route translation** in `config/route-translations.php`:

```php
'new-page' => [
  'es' => 'nueva-pagina',
  'en' => 'new-page',
],
```

---

## Markdown Blog

The bilingual blog is stored in Git and does not require WordPress or another runtime CMS.

### Content layout

- `content/blog/en/{slug}.md` contains English articles.
- `content/blog/es/{slug}.md` contains Spanish articles.
- `content/blog/categories.yaml` defines canonical categories, translated labels, and localized query slugs.
- `public/images/blog/` contains committed cover images.
- `content/blog/README.md` is the concise authoring reference.

Each article uses YAML front matter followed by Markdown:

```yaml
---
name: Article title
cover: article-cover.webp
cover_alt: Descriptive alternative text
url: article-slug
seo_description: Search and social description.
language: en
translation: translated-article-slug
date: 2026-08-31
updated: 2026-08-31
published: false
categories:
  - multilevel
author: Disruptive Studio
---
```

Required fields are `name`, `cover`, `cover_alt`, `url`, `seo_description`, `language`, `date`, `published`, and `categories`. The filename must match `url`, the language must match its directory, and every category and cover must exist. Set `published: true` to publish; drafts and future dates remain hidden.

Raw HTML is stripped and unsafe URL schemes are rejected. Use standard Markdown headings, emphasis, links, lists, quotes, code, and tables.

### Routes and pagination

```text
GET /blog
GET /blog?page=2
GET /blog?category=multinivel
GET /blog/{spanish-slug}
GET /en/blog
GET /en/blog?page=2
GET /en/blog?category=multilevel
GET /en/blog/{english-slug}
```

Listings show eight posts per page. Invalid pages are clamped to the available range, obsolete `after` cursor parameters are ignored, and language switching uses the `translation` slug when the corresponding published article exists.

### Validation

```bash
composer validate
vendor/bin/phpunit
vendor/bin/phpstan analyse --level=9
```

Invalid article files are skipped and their validation error is written to the PHP error log.

---

## Contact Form & Email

The contact form includes validation, reCAPTCHA v3 protection, and email sending.

### How It Works

1. **Frontend** (`public/assets/js/contact.js`):

- Validates form fields
- Executes reCAPTCHA v3
- Sends AJAX request to backend

2. **Backend** (`app/Controllers/ContactController.php`):

- Validates reCAPTCHA score
- Validates form data
- Sends email via PHPMailer
- Returns JSON response

3. **Email Service** (`src/Mailer.php`):

- Configures SMTP connection
- Formats email content
- Sends email to configured address

### Contact Form Configuration

#### Environment Variables

```env
# SMTP Configuration
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls

# Sender information
MAIL_FROM_ADDRESS=noreply@disruptivestudio.com
MAIL_FROM_NAME="Disruptive Studio"

# Recipient email
MAIL_TO_ADDRESS=contact@disruptivestudio.com

# reCAPTCHA v3
RECAPTCHA_SITE_KEY=your-site-key
RECAPTCHA_SECRET_KEY=your-secret-key
RECAPTCHA_SCORE_THRESHOLD=0.5
```

#### Gmail Configuration

For Gmail, you need to:

1. Enable 2-factor authentication
2. Generate an App Password
3. Use the App Password in `MAIL_PASSWORD`

#### Form Validation Rules

Defined in `app/Models/Contact.php`:

```php
private array $rules = [
  'name' => ['required', 'min:2', 'max:100'],
  'email' => ['required', 'email'],
  'phone' => ['required', 'min:10', 'max:20'],
  'company' => ['required', 'max:100'],
  'message' => ['required', 'min:10', 'max:1000'],
];
```

#### Customizing Email Template

Edit `src/Mailer.php` method `sendContactForm()`:

```php
public function sendContactForm(array $data): bool
{
  $subject = "New Contact Form Submission - {$data['company']}";

  $body = "
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> {$data['name']}</p>
    <p><strong>Email:</strong> {$data['email']}</p>
    <p><strong>Phone:</strong> {$data['phone']}</p>
    <p><strong>Company:</strong> {$data['company']}</p>
    <p><strong>Message:</strong></p>
    <p>{$data['message']}</p>
  ";

  return $this->send($subject, $body);
}
```

### Testing Email Functionality

For development, you can use:

- **Mailtrap** (recommended for testing)
- **Gmail** with App Password
- **SendGrid**
- **Local mail server**

Example Mailtrap configuration:

```env
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

### reCAPTCHA v3 Setup

1. Get keys from [Google reCAPTCHA Admin](https://www.google.com/recaptcha/admin)
2. Add keys to `.env` file
3. Adjust score threshold if needed (0.0 to 1.0, default 0.5)

Lower threshold = more permissive
Higher threshold = more strict

---

## Frontend Development

### CSS with Tailwind CSS 4

The project uses Tailwind CSS 4 with custom configuration.

**Main files**:

- `public/assets/css/tailwind-config.css` - Tailwind configuration
- `public/assets/css/styles.css` - Compiled output

**Build commands**:

```bash
# Development mode (with file watching)
pnpm run dev

# Production build (minified)
pnpm run build
```

**Custom Tailwind Configuration**:

Edit `public/assets/css/tailwind-config.css`:

```css
@import "tailwindcss";

@theme {
  --color-primary: #your-color;
  --font-sans: "Your Font", sans-serif;
}

/* Custom utilities */
@layer utilities {
  .custom-class {
    /* Your styles */
  }
}
```

### JavaScript & GSAP Animations

**Location**: `public/assets/js/`

**Main files**:

- `base.js` - Core UI interactions and dialog handling
- `home-animations.js` - Deferred GSAP loader for animation-heavy pages
- `home-sliders.js` - Deferred Swiper loader for slider-heavy pages
- `contact-form.js` - Contact form handling

**Adding animations**:

```javascript
// Example GSAP animation
gsap.from(".element", {
  opacity: 0,
  y: 50,
  duration: 1,
  scrollTrigger: {
    trigger: ".element",
    start: "top 80%",
  },
});
```

### Image Assets

**Location**: `public/images/`

**Structure**:

```
public/images/
├── services/          # Service page images
├── home/             # Home page images
├── icons/            # Icon files
└── common/           # Shared images
```

**Naming convention**:

- Use descriptive names: `web3_hero_big.webp`
- Use WebP format for better performance
- Provide multiple sizes when needed

### SVG Icons

SVG symbols are defined in `temp/svg-symbols.php` and can be used inline:

```html
<svg>
  <use href="#icon-name"></use>
</svg>
```

---

## Configuration

### Environment Variables

Copy `.env.example` to `.env` and configure:

```env
# Application
APP_ENV=production              # development, staging, production
APP_DEBUG=false                 # true for development
APP_URL=https://disruptivestudio.com

# Mail Configuration
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your-email@example.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@disruptivestudio.com
MAIL_FROM_NAME="Disruptive Studio"
MAIL_TO_ADDRESS=contact@disruptivestudio.com

# reCAPTCHA v3
RECAPTCHA_SITE_KEY=your-site-key
RECAPTCHA_SECRET_KEY=your-secret-key
RECAPTCHA_SCORE_THRESHOLD=0.5
```

### Main Configuration

**File**: `config/config.php`

Contains:

- Application settings
- Mail configuration
- reCAPTCHA settings
- Language settings

## GoHighLevel Exit-Intent Integration

The exit-intent popup submits leads to GoHighLevel through the Contacts API using `POST /contacts/upsert`.
If the contact does not exist yet, HighLevel creates a new contact. If the email or phone already exists in the location, HighLevel updates the existing contact.

### Required `.env` Variables

```env
GHL_BASE_URL=https://services.leadconnectorhq.com
GHL_API_VERSION=2021-07-28
GHL_API_TOKEN=your-private-integration-token
GHL_LOCATION_ID=your-location-id
GHL_EXIT_INTENT_SOURCE=softwareformlm_exit_popup
GHL_EXIT_INTENT_TAGS=website,exit_popup

GHL_EXIT_INTENT_CF_CAMPAIGN_MEDIUM=
GHL_EXIT_INTENT_CF_CAMPAIGN_NAME=
GHL_EXIT_INTENT_CF_CAMPAIGN_SOURCE=
GHL_EXIT_INTENT_CF_AD_ID=
GHL_EXIT_INTENT_CF_CAMPAIGN_CONTENT=
GHL_EXIT_INTENT_CF_COUNTRY=

GHL_EXIT_INTENT_VALUE_CAMPAIGN_MEDIUM=sfmlm-website
GHL_EXIT_INTENT_VALUE_CAMPAIGN_NAME=sfmlm-prevent-exit
GHL_EXIT_INTENT_VALUE_CAMPAIGN_SOURCE=website
GHL_EXIT_INTENT_VALUE_AD_ID=sfmlm_exit_popup
GHL_EXIT_INTENT_VALUE_CAMPAIGN_CONTENT=Website_prevent_user_from_leaving
```

### What Each Variable Does

- `GHL_BASE_URL`: HighLevel API base URL. Keep `https://services.leadconnectorhq.com`.
- `GHL_API_VERSION`: API version header required by this integration. Keep `2021-07-28`.
- `GHL_API_TOKEN`: Private Integration token with contacts access.
- `GHL_LOCATION_ID`: Sub-account / location where the contact will be created or updated.
- `GHL_EXIT_INTENT_SOURCE`: Value sent as the top-level HighLevel contact `source`.
- `GHL_EXIT_INTENT_TAGS`: Comma-separated tags applied to the contact.
- `GHL_EXIT_INTENT_CF_*`: Mapping for the target contact custom fields in HighLevel. Each value can be either a real custom field ID or a field key.
- `GHL_EXIT_INTENT_VALUE_*`: Fixed values written into the campaign-related custom fields.

### Custom Field Mapping Used by This Project

The integration writes these values into these HighLevel contact custom fields:

- Campaign medium: `sfmlm-website`
- Campaign name: `sfmlm-prevent-exit`
- Campaign source: `website`
- Ad ID: `sfmlm_exit_popup`
- Campaign content: `Website_prevent_user_from_leaving`
- Country: dynamic value from Cloudflare in production, `Local` in development

The `country` custom field keeps its dynamic behavior:

- Production: uses the `CF-IPCountry` header from Cloudflare
- Local or development environments: falls back to `Local`

### How to Get the HighLevel Token

1. Open HighLevel.
2. Go to `Settings`.
3. Open `Private Integrations`.
4. Create a new integration.
5. Enable the scopes required for contacts.
6. Copy the generated token and store it in `.env` as `GHL_API_TOKEN`.

### How to Get the Location ID

Use either of these:

1. Open the target sub-account and go to `Settings > Business Profile`.
2. Copy the `Location ID`.

Or:

1. Open the sub-account in your browser.
2. Copy the value after `/location/` or from `locationId=...` in the URL.

### How to Get the Contact Custom Field IDs or Keys

This integration uses contact custom fields, not opportunity custom fields.

1. Open the correct HighLevel sub-account.
2. Go to `Settings > Custom Fields`.
3. Find the contact fields for:
   `Campaign medium`, `Campaign name`, `Campaign source`, `Ad ID`, `Campaign content`, and `Country`.
4. Copy the field ID from the UI or network request, or use the field key if you already have it.

Important:

- Do not put field values such as `website`, `sfmlm_exit_popup`, or `Local` into `GHL_EXIT_INTENT_CF_*`.
- Put those fixed values into the `GHL_EXIT_INTENT_VALUE_*` variables instead.

### Files Involved

- View: `app/Views/components/exitPopup.php`
- Controller: `app/Controllers/ExitIntentController.php`
- Model: `app/Models/ExitIntentLead.php`
- HighLevel client: `app/Services/HighLevelClient.php`
- App config: `config/config.php`

### Retesting the Integration

1. Update `.env`.
2. Restart PHP or the Docker containers if needed.
3. Clear these browser `localStorage` keys:
   `exit-intent-first-touch` and `exit-intent-form-submitted`.
4. Open the site and submit the exit-intent popup again.
5. Confirm the contact and custom fields in GoHighLevel.

### Constants

**File**: `config/constants.php`

Define global constants used throughout the application.

---

## Deployment

### Production Deployment

1. **Set environment to production**:

```env
APP_ENV=production
APP_DEBUG=false
```

2. **Build assets**:

```bash
pnpm run build
```

3. **Install PHP dependencies**:

```bash
composer install --no-dev --optimize-autoloader
```

4. **Configure web server** (Nginx example):

```nginx
server {
  listen 80;
  server_name disruptivestudio.com;
  root /var/www/html/public;
  index index.php;

  location / {
    try_files $uri $uri/ /index.php?$query_string;
  }

  location ~ \.php$ {
    fastcgi_pass php:9000;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
  }
}
```

5. **Set proper permissions**:

```bash
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
```

### Docker Production

Use the provided Docker configuration:

```bash
docker-compose up -d
```

For production, consider:

- Using a reverse proxy (Traefik, Nginx Proxy Manager)
- Setting up SSL/TLS certificates
- Configuring proper logging
- Setting up monitoring

### PHP security updates (Docker)

PHP is supplied by the container, not by Composer or the host's PHP installation.
Compose builds `Dockerfile` from `trafex/php-nginx:latest`, refreshes the Alpine
packages, and checks the installed PHP version. The build fails unless PHP is
8.3.36+, 8.4.27+, or 8.5.12+ within those branches, which contain the fixes for
CVE-2026-109618 and CVE-2026-109619. A new PHP branch requires reviewing and
updating `scripts/check-php-version.php`.

On each Docker host, including production, run from the repository directory:

```bash
docker compose build --pull --no-cache sfmlm-website
docker compose run --rm --no-deps sfmlm-website php /usr/local/lib/check-php-version.php
docker compose up -d --force-recreate sfmlm-website
docker compose exec -T sfmlm-website php /usr/local/lib/check-php-version.php
```

After recreation, verify the home page, blog pages in both languages, and form
handling. Recreating the single container briefly interrupts requests. If the
build fails because patched packages are unavailable, obtain an updated upstream
image/package repository and rebuild; do not bypass the version check.

A Git pull or container restart alone does not replace the PHP runtime. The
current Azure pipeline only pulls repository changes; the commands above must
also run on the deployment host. If production uses a separately managed Docker
configuration, it must build this Dockerfile (or deploy an image built from it)
and recreate its containers. Updating the host's PHP does not update containers.

Security advisory: [PHP, 21 October 2026](https://www.php.net/archive/2026.php#2026-10-21-5).


---

## Development Guidelines

### Code Style

- Follow PSR-12 coding standards for PHP
- Use meaningful variable and function names
- Comment complex logic
- Keep functions small and focused

### File Naming

- Controllers: `PascalCase` (e.g., `HomeController.php`)
- Views: `kebab-case` (e.g., `service-type-1.php`)
- Content files: `kebab-case` (e.g., `aplicaciones-web3.php`)
- Translation files: `snake_case` (e.g., `web3_app.php`)

### Adding Features

1. Plan the feature and its impact
2. Update configuration files
3. Create necessary controllers/models
4. Add translations for all languages
5. Create/update view templates
6. Test thoroughly
7. Document changes

### Best Practices

- Always sanitize user input with `esc()` or `e()` in views
- Use language constants instead of hardcoded text
- Keep translations organized and consistent
- Optimize images before adding them
- Test on multiple browsers and devices
- Keep dependencies updated

---

## Troubleshooting

### Common Issues

**Issue**: CSS not updating

- Solution: Run `pnpm run build` or restart `pnpm run dev`

**Issue**: Services not showing

- Solution: Check `isActive` is `true` in `config/services.php`

**Issue**: Emails not sending

- Solution: Check `.env` mail configuration and test SMTP connection

**Issue**: Language switching not working

- Solution: Clear browser cache and check language configuration

**Issue**: 404 errors

- Solution: Check Nginx/Apache rewrite rules are configured correctly

### Debug Mode

Enable debug mode in `.env`:

```env
APP_DEBUG=true
```

This will show detailed error messages.

---

## Additional Resources

- [PHP Documentation](https://www.php.net/docs.php)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [GSAP Documentation](https://greensock.com/docs/)
- [PHPMailer Documentation](https://github.com/PHPMailer/PHPMailer)

---

## Support

For questions or issues:

- Contact the development team
- Review the code documentation
- Check the configuration files

---

## License

Proprietary - Disruptive Studio © 2025
