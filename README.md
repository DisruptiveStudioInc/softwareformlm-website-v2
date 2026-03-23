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
- [Blog & WordPress Integration](#blog--wordpress-integration)
- [Contact Form & Email](#contact-form--email)
- [Frontend Development](#frontend-development)
- [Configuration](#configuration)
- [Deployment](#deployment)

---

## Project Overview

This is a professional corporate website for Disruptive Studio that features:

- **Multilingual support** (Spanish and English)
- **Dynamic service pages** with different templates
- **Headless WordPress blog** with GraphQL integration
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
- **Guzzle HTTP Client** for WordPress API communication

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

# WordPress Headless CMS
WP_API_URL=http://localhost:10008/graphql
WP_APP_USER=your-wordpress-username
WP_APP_PASSWORD=xxxx xxxx xxxx xxxx xxxx xxxx

# Cache Clear Token (for webhook)
CACHE_CLEAR_TOKEN=your-secret-token-here
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

- **Spanish (es)** - Default language
- **English (en)**

### How It Works

1. **Language Detection**: The router automatically detects the language from the URL

- Default language (Spanish): `https://domain.com/`
- Other languages: `https://domain.com/en/`

2. **Translation Files**: Located in `/lang/` directory

- `lang/es.php` - Spanish translations
- `lang/en.php` - English translations
- `lang/services/` - Service-specific translations

3. **Using Translations in Code**:

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
route('contact'); // Returns translated path for current language
```

---

## Routing System

The website uses a custom router with automatic language prefix handling.

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

### Language Prefixes

The router automatically handles language prefixes:

- Spanish (default): `/` or `/contacto`
- English: `/en/` or `/en/contact`

**No need to define routes for each language separately!**

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
$slug = $request->getUri(); // Parse manually
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

## Blog & WordPress Integration

The website features a headless WordPress blog integration using WPGraphQL. Blog posts are fetched from a WordPress backend via GraphQL API and cached locally for optimal performance.

### Architecture

**Headless WordPress Setup:**

- WordPress instance running with WPGraphQL plugin
- GraphQL endpoint exposed for querying posts, categories, and metadata
- Application Password authentication for secure API access
- File-based caching system to minimize API calls

**Components:**

- **Controller**: `app/Controllers/BlogController.php` - Handles all blog routes
- **Service**: `app/Services/WordPressClient.php` - WordPress API client with caching
- **Views**:
  - `app/Views/templates/blog/index.php` - Blog listing page
  - `app/Views/templates/blog/show.php` - Single post view
- **Cache**: `cache/wordpress/` - Cached API responses

### How It Works

1. **Request Flow:**
   - User requests a blog page
   - `BlogController` checks for cached data
   - If cache miss, `WordPressClient` queries WordPress GraphQL API
   - Response is cached and returned
   - View template renders the data

2. **Caching Strategy:**
   - File-based persistent caching (no automatic expiration)
   - Separate cache keys for different queries (posts list, single post, categories)
   - Cache invalidation via WordPress webhook when content is updated
   - Manual cache clearing available for development/testing

3. **Pagination:**
   - Cursor-based pagination using WordPress connection edges
   - Pre-calculated page cursors for direct page access
   - Lightweight queries to fetch only necessary data

### WordPress Configuration

#### Required WordPress Plugins

1. **WPGraphQL** (required)
   - Install and activate WPGraphQL plugin
   - Configure endpoint at `/graphql`

2. **WPGraphQL for Polylang** (optional, for multilingual support)
   - Enables language filtering in GraphQL queries
   - Adds language fields to posts

#### WordPress Setup Steps

1. **Install WordPress** (version 5.9 or higher recommended)

2. **Install WPGraphQL Plugin:**

   ```bash
   # Via WordPress admin
   Plugins > Add New > Search "WPGraphQL" > Install & Activate

   # Or via WP-CLI
   wp plugin install wp-graphql --activate
   ```

3. **Configure WPGraphQL Settings:**
   - Go to `GraphQL > Settings`
   - Enable "Public Introspection" for development
   - For production, enable "Restrict Endpoint to Authenticated Users"

4. **Create Application Password:**
   - Go to `Users > Your Profile`
   - Scroll to "Application Passwords"
   - Enter name (e.g., "Disruptive Studio Website")
   - Click "Add New Application Password"
   - Copy the generated password (format: `xxxx xxxx xxxx xxxx`)

5. **Configure Post Structure:**
   - Create categories for organizing posts
   - Add featured images to posts
   - Use proper post excerpts for better preview cards

6. **Optional - Polylang Setup:**
   - Install and activate Polylang plugin
   - Install WPGraphQL for Polylang plugin
   - Configure languages (ES, EN)
   - Assign language to each post

### Environment Configuration

Add these variables to your `.env` file:

```env
# WordPress Headless CMS
WP_API_URL=https://your-wordpress-site.com/graphql
WP_APP_USER=your-wordpress-username
WP_APP_PASSWORD=xxxx xxxx xxxx xxxx xxxx xxxx

# Cache Clear Token (for webhook)
CACHE_CLEAR_TOKEN=your-secret-random-token-here
```

**Configuration Notes:**

- `WP_API_URL`: Full URL to your WordPress GraphQL endpoint
- `WP_APP_USER`: WordPress admin username
- `WP_APP_PASSWORD`: Application Password (not regular password!)
- `CACHE_CLEAR_TOKEN`: Secret token for cache invalidation webhook

### Blog Routes

```php
// Blog index - shows all posts with pagination
GET /blog
GET /blog?page=2
GET /blog?category=technology

// Single post - shows full post content
GET /blog/{slug}

// Cache management (webhook endpoint)
POST /blog/cache/clear
```

### Features

#### Blog Index Page (`/blog`)

- **Post Listing**: Displays posts in a grid layout with featured images
- **Pagination**: Numbered pagination with direct page access
- **Category Filtering**: Sidebar with category list and post counts
- **Responsive Design**: Adapts to mobile, tablet, and desktop
- **Multilingual**: Automatically filters posts by current language

**Query Parameters:**

- `page`: Page number (e.g., `?page=2`)
- `category`: Category slug (e.g., `?category=technology`)

#### Single Post Page (`/blog/{slug}`)

- **Full Content**: Complete post content with rich media support
- **Featured Image Hero**: Large featured image with gradient overlay
- **Post Metadata**: Publication date, reading time, categories
- **Tags Display**: Visual tag list at bottom
- **Related Posts**: Shows 3 related posts from same category
- **SEO Optimization**: Structured data (JSON-LD) for search engines

### Cache Management

#### Manual Cache Clearing

Clear all blog cache:

```bash
# Via URL (requires CACHE_CLEAR_TOKEN)
curl -X POST https://your-site.com/blog/cache/clear \
  -H "Authorization: Bearer your-secret-token"
```

#### WordPress Webhook (Automatic)

Set up a webhook in WordPress to automatically clear cache when posts are published/updated:

1. **Install Webhook Plugin** (e.g., WP Webhooks)

2. **Configure Webhook:**
   - Trigger: `post_updated`, `post_published`
   - URL: `https://your-site.com/blog/cache/clear`
   - Method: `POST`
   - Headers: `Authorization: Bearer your-secret-token`

3. **Test the Webhook:**
   - Publish or update a post
   - Check your site's cache directory is cleared

#### Cache File Structure

```
cache/wordpress/
├── posts_EN_first_10.cache          # English posts, page 1
├── posts_ES_first_10.cache          # Spanish posts, page 1
├── post_{slug}_EN.cache             # Single post cache
├── categories_EN.cache              # Categories list
├── page_cursors_EN_10.cache         # Pagination cursors
└── total_pages_EN_10.cache          # Total page count
```

### Customization

#### Customize GraphQL Queries

The `WordPressClient` uses optimized GraphQL queries. To add/remove fields:

```php
// Example: Add author information to posts
$query = '
  query GetPosts($lang: LanguageCodeFilterEnum!, $after: String, $first: Int!) {
    posts(where: {language: $lang}, after: $after, first: $first) {
      edges {
        node {
          id
          title
          slug
          excerpt
          author {
            node {
              name
              avatar {
                url
              }
            }
          }
          ...
        }
      }
    }
  }
';
```

#### Customize Blog Templates

**Index Template** (`app/Views/templates/blog/index.php`):

- Modify grid layout
- Change post card design
- Customize sidebar
- Adjust pagination style

**Single Post Template** (`app/Views/templates/blog/show.php`):

- Modify content layout
- Customize featured image display
- Change related posts section
- Add social sharing buttons

### Troubleshooting

#### Common Issues

**1. "WordPress API URL not configured" Error**

- Check `.env` file has `WP_API_URL` set
- Verify the URL is correct and accessible
- Test GraphQL endpoint: `https://your-wp-site.com/graphql`

**2. Authentication Errors**

- Verify Application Password is correct (not regular password)
- Check username matches WordPress user
- Ensure WPGraphQL has authentication enabled

**3. Empty Blog Page**

- Check WordPress has published posts
- Verify posts have correct language assigned (if using Polylang)
- Clear cache: `rm -rf cache/wordpress/*`
- Check PHP error logs

**4. Images Not Displaying**

- Verify WordPress posts have featured images
- Check image URLs are accessible
- Ensure WordPress CORS settings allow external requests

**5. Slow Performance**

- Optimize GraphQL queries (remove unnecessary fields)
- Enable WordPress object caching (Redis/Memcached)
- Use CDN for WordPress media files
- Consider adding a reverse proxy cache (Varnish, Nginx)

#### Debug Mode

Enable debug mode in `WordPressClient`:

```php
// Add to constructor
private bool $debug = true;

// Add logging
if ($this->debug) {
    error_log("GraphQL Query: " . $query);
    error_log("GraphQL Response: " . print_r($result, true));
}
```

### Best Practices

1. **Cache Management:**
   - Set up automatic cache clearing webhook (recommended)
   - Cache is persistent until cleared by webhook or manually
   - Monitor cache file sizes regularly
   - Clear cache after bulk content updates

2. **Performance:**
   - Use optimized GraphQL queries
   - Implement lazy loading for images
   - Consider CDN for media files

3. **Security:**
   - Keep Application Password secure
   - Use strong CACHE_CLEAR_TOKEN
   - Restrict GraphQL endpoint in production
   - Enable HTTPS for API communication

4. **Content:**
   - Always add featured images to posts
   - Write meaningful excerpts
   - Use categories for organization
   - Optimize images before uploading

5. **Monitoring:**
   - Monitor API response times
   - Track error logs for API failures
   - Set up uptime monitoring for WordPress
   - Verify webhook is functioning correctly

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

- `main.js` - Core functionality
- `animations.js` - GSAP animations
- `contact.js` - Contact form handling

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
