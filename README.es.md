# Sitio Web de Disruptive Studio

Un sitio web corporativo multilingüe para Disruptive Studio, mostrando sus servicios, procesos de trabajo e información de la empresa. Construido con PHP 8.3, Tailwind CSS y animaciones GSAP.

## Tabla de Contenidos

- [Descripción del Proyecto](#descripción-del-proyecto)
- [Stack Tecnológico](#stack-tecnológico)
- [Primeros Pasos](#primeros-pasos)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Internacionalización (i18n)](#internacionalización-i18n)
- [Sistema de Rutas](#sistema-de-rutas)
- [Gestión de Servicios](#gestión-de-servicios)
- [Páginas Estáticas](#páginas-estáticas)
- [Blog en Markdown](#blog-en-markdown)
- [Formulario de Contacto y Email](#formulario-de-contacto-y-email)
- [Desarrollo Frontend](#desarrollo-frontend)
- [Configuración](#configuración)
- [Integración GoHighLevel Exit-Intent](#integración-gohighlevel-exit-intent)
- [Despliegue](#despliegue)

---

## Descripción del Proyecto

Este es un sitio web corporativo profesional para Disruptive Studio que cuenta con:

- **Soporte multilingüe** (Español e Inglés)
- **Páginas de servicios dinámicas** con diferentes plantillas
- **Blog bilingüe en Markdown** gestionado en Git
- **Formulario de contacto** con validación reCAPTCHA v3
- **Diseño responsive** usando Tailwind CSS 4
- **Animaciones suaves** con GSAP
- **Páginas optimizadas para SEO** con meta tags personalizados por idioma

---

## Stack Tecnológico

### Backend

- **PHP 8.3+**
- **Composer** para gestión de dependencias
- **PHPMailer** para funcionalidad de email
- **phpdotenv** para configuración de entorno
- **Guzzle HTTP Client** para comunicación con APIs externas

### Frontend

- **Tailwind CSS 4** para estilos
- **GSAP 3** para animaciones
- **JavaScript Vanilla** para interactividad

### Desarrollo

- **Docker** para containerización
- **pnpm** para gestión de paquetes Node.js
- **Nginx** como servidor web

---

## Primeros Pasos

### Prerequisitos

- Docker & Docker Compose
- pnpm (o npm)
- Composer (opcional, manejado por Docker)

### Instalación

1. **Clonar el repositorio**

```bash
git clone <repository-url>
cd disruptivestudio-website
```

2. **Crear archivo de entorno**

```bash
cp .env.example .env
```

Editar `.env` con tu configuración:

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

3. **Instalar dependencias PHP**

```bash
docker-compose run --rm composer install
```

4. **Instalar dependencias Node.js**

```bash
pnpm install
```

5. **Compilar CSS**

```bash
# Para desarrollo (con modo watch)
pnpm run dev

# Para producción (minificado)
pnpm run build
```

6. **Iniciar contenedores Docker**

```bash
docker-compose up -d
```

7. **Acceder al sitio web**
   Abre tu navegador y navega a: `http://localhost:8080`

---

## Estructura del Proyecto

```
disruptivestudio-website/
├── app/
│   ├── Controllers/        # Manejadores de peticiones
│   │   ├── BaseController.php
│   │   ├── HomeController.php
│   │   ├── ContactController.php
│   │   ├── ServiceController.php
│   │   └── ErrorController.php
│   ├── Models/            # Modelos de datos
│   │   ├── Contact.php
│   │   ├── Language.php
│   │   └── Service.php
│   └── Views/             # Plantillas de vistas
│       ├── components/    # Componentes reutilizables
│       ├── layouts/       # Plantillas de layout
│       ├── sections/      # Secciones de página
│       └── templates/     # Plantillas de página
├── config/
│   ├── config.php         # Configuración principal
│   ├── routes.php         # Definiciones de rutas
│   ├── route-translations.php  # Traducciones de nombres de rutas
│   ├── services.php       # Definiciones de servicios
│   ├── subcategories.php  # Subcategorías de servicios
│   └── constants.php      # Constantes de aplicación
├── content/
│   ├── pages/            # Contenido de páginas estáticas
│   │   ├── home.php
│   │   └── contact.php
│   └── services/         # Contenido de páginas de servicios
│       ├── aplicaciones-web3.php
│       ├── contratos-inteligentes.php
│       └── ...
├── lang/
│   ├── en.php            # Traducciones en inglés
│   ├── es.php            # Traducciones en español
│   └── services/         # Traducciones específicas de servicios
│       ├── web3_app.php
│       └── ...
├── public/
│   ├── assets/
│   │   ├── css/          # CSS compilado
│   │   └── js/           # Archivos JavaScript
│   └── images/           # Recursos de imágenes
├── src/
│   ├── Router.php        # Router personalizado
│   ├── Request.php       # Manejador de peticiones HTTP
│   ├── Response.php      # Manejador de respuestas HTTP
│   ├── Mailer.php        # Servicio de email
│   ├── Recaptcha.php     # Validación reCAPTCHA
│   └── helpers.php       # Funciones auxiliares
├── vendor/               # Dependencias de Composer
├── .env                  # Variables de entorno
├── composer.json         # Dependencias PHP
├── package.json          # Dependencias Node.js
├── docker-compose.yml    # Configuración Docker
├── Dockerfile           # Definición de imagen Docker
└── index.php            # Punto de entrada de la aplicación
```

---

## Internacionalización (i18n)

El sitio web soporta múltiples idiomas con un sistema de traducción personalizado.

### Idiomas Actuales

- **Español (es)** - URL predeterminada sin prefijo
- **Inglés (en)**

### Cómo Funciona

1. **Detección de Idioma en la Primera Visita**: El router negocia el idioma solo cuando todavía no existe la cookie `site_language`

- Primera entrada explícita en inglés: `https://domain.com/en/...` selecciona inglés de inmediato y lo guarda
- Primera entrada sin prefijo con `Accept-Language: es` o `es-*`: sirve la URL canónica en español
- Primera entrada sin prefijo con `Accept-Language: en` o cualquier otro idioma: redirige a la URL canónica en inglés bajo `/en/...`
- Después de esa primera visita, el router usa la cookie `site_language` guardada y ya no vuelve a negociar con los headers del navegador

2. **Esquema de URLs Canónicas**:

- Las URLs canónicas en español no llevan prefijo: `https://domain.com/`, `https://domain.com/politica-de-privacidad`
- Las URLs canónicas en inglés viven bajo `/en`: `https://domain.com/en/`, `https://domain.com/en/privacy-policy`
- Si el idioma guardado y la URL solicitada no coinciden, el router redirige a la URL equivalente en el idioma correcto
- Los cambios manuales de idioma desde el switcher agregan `?set_lang=...`, guardan la cookie y redirigen de inmediato a la URL traducida limpia

3. **Archivos de Traducción**: Ubicados en el directorio `/lang/`

- `lang/es.php` - Traducciones en español
- `lang/en.php` - Traducciones en inglés
- `lang/services/` - Traducciones específicas de servicios

4. **Usando Traducciones en el Código**:

```php
use App\Models\Language;

// Obtener una traducción
$text = Language::trans('nav.home');

// Obtener el idioma actual
$currentLang = Language::getCurrentLanguage();
```

### Agregar un Nuevo Idioma

1. **Actualizar configuración** en `config/config.php`:

```php
'languages' => [
  'default' => 'en',
  'available' => ['es', 'en', 'fr'], // Agregar nuevo código de idioma
  'names' => [
    'es' => 'Esp',
    'en' => 'Eng',
    'fr' => 'Fra'  // Agregar nombre del idioma
  ]
],
```

2. **Crear archivo de traducción** en `lang/fr.php`:

```php
<?php

$servicesTranslations = loadLangServices();

return [
  'nav' => [
    'home' => 'Accueil',
    'about' => 'À propos',
    // ... más traducciones
  ],
  // ... copiar estructura de es.php o en.php
];
```

3. **Agregar traducciones de servicios** en el directorio `lang/services/`:

```php
// lang/services/web3_app.php
return [
  'fr' => [
    'hero' => [
      'title' => 'Applications Web3',
      // ... más traducciones
    ]
  ]
];
```

4. **Actualizar traducciones de rutas** en `config/route-translations.php`:

```php
return [
  'contact' => [
    'es' => 'contacto',
    'en' => 'contact',
    'fr' => 'contacter'  // Agregar ruta en francés
  ],
];
```

5. **Agregar slugs de servicios** en `config/services.php`:

```php
'aplicaciones-web3' => [
  'es' => ['slug' => 'aplicaciones-web3', ...],
  'en' => ['slug' => 'web3-applications', ...],
  'fr' => ['slug' => 'applications-web3', ...],  // Agregar slug en francés
],
```

### Funciones Auxiliares de Traducción

Disponibles en `src/helpers.php`:

```php
// Escapar y traducir
Language::trans('key.path');

// Cargar traducciones específicas de servicios
loadLangServices();

// Obtener ruta traducida
route('privacy', 'en'); // Retorna /en/privacy-policy
```

---

## Sistema de Rutas

El sitio web usa un router personalizado con URLs canónicas por idioma, detección de idioma en la primera visita y persistencia por cookie.

### Cómo Funcionan las Rutas

Las rutas se definen en `config/routes.php`:

```php
<?php

use App\Router;

return function(Router $router) {
  // Páginas estáticas
  $router->get('/', 'App\\Controllers\\HomeController', 'index');
  $router->get('/contact', 'App\\Controllers\\ContactController', 'index');

  // Rutas POST
  $router->post('/contact', 'App\\Controllers\\ContactController', 'submit');

  // Rutas dinámicas con parámetros
  $router->get('/{slug}', 'App\\Controllers\\ServiceController', 'show');
};
```

### Resolución de Idioma

El router resuelve el idioma en este orden:

1. Cambio manual de idioma mediante `?set_lang=es` o `?set_lang=en`
2. Cookie guardada `site_language`
3. Detección por URL en la primera visita
4. Fallback a `Accept-Language` en la primera visita

Eso significa que la detección por idioma del navegador solo corre en la primera visita. En las solicitudes siguientes se usa únicamente la cookie guardada.

### Comportamiento de URLs Canónicas

- Las rutas en español son canónicas sin prefijo
- Las rutas en inglés son canónicas bajo `/en/...`
- El router redirige a la URL traducida equivalente cuando el idioma guardado y la URL solicitada no coinciden
- Las rutas estáticas usan `config/route-translations.php`
- Las rutas del blog traducen `/blog` y, cuando es posible, también el slug de cada post antes de redirigir

Ejemplos:

- `/politica-de-privacidad` puede redirigir a `/en/privacy-policy` para un visitante nuevo con navegador en inglés
- `/en/terms-and-conditions` puede redirigir a `/terminos-y-condiciones` para un usuario con cookie guardada en español
- Al hacer clic en el switcher de idioma se guarda la nueva preferencia y se redirige a la URL traducida limpia

### Agregar Nuevas Rutas

1. **Definir ruta** en `config/routes.php`:

```php
$router->get('/about', 'App\\Controllers\\AboutController', 'index');
```

2. **Crear controlador** en `app/Controllers/AboutController.php`:

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
      'title' => 'Acerca de Nosotros'
    ]);
  }
}
```

3. **Agregar traducciones de ruta** en `config/route-translations.php`:

```php
'about' => [
  'es' => 'nosotros',
  'en' => 'about',
],
```

4. **Crear plantilla de vista** en `app/Views/templates/about.php`

### Parámetros de Ruta

Usa llaves para segmentos dinámicos:

```php
// Coincide con: /blog/mi-slug-de-post
$router->get('/blog/{slug}', 'BlogController', 'show');

// Coincide con: /user/123
$router->get('/user/{id}', 'UserController', 'show');

// Acceder en el controlador:
$slug = $request->getRouteParam('slug');
```

---

## Gestión de Servicios

Los servicios son el contenido dinámico principal del sitio web. Cada servicio se configura en `config/services.php` y puede tener diferentes plantillas.

### Estructura de Configuración de Servicios

```php
// config/services.php
'service-key' => [
  'isActive' => true,                    // Habilitar/deshabilitar servicio
  'category' => 'services',              // Tipo de categoría
  'subcategory' => 'blockchain',         // Subcategoría (para agrupar)
  'icon' => 'service-icon-name',         // Identificador de icono
  'template' => 'service-type-1',        // Plantilla a usar
  'content_file' => 'service-content',   // Nombre de archivo de contenido
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

### Agregar un Nuevo Servicio

#### Paso 1: Agregar Configuración del Servicio

Editar `config/services.php` y agregar:

```php
'nuevo-servicio' => [
  'isActive' => true,
  'category' => 'services',
  'subcategory' => 'custom_software',  // Ver config/subcategories.php
  'icon' => 'new-service-icon',
  'template' => 'service-type-1',      // o 'service-type-2', 'service-type-3'
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

#### Paso 2: Crear Archivo de Contenido

Crear `content/services/nuevo-servicio.php`:

```php
<?php

use App\Models\Language;
$csLang = Language::getCurrentLanguage();
$sKey = "new_service.{$csLang}";

return [
  // Sección hero
  'hero' => Language::trans("{$sKey}.hero.title"),
  'hero_text' => Language::trans("{$sKey}.hero.text"),
  'hero_images' => [
    'big' => 'new_service_1_big.webp',
    'small' => 'new_service_1_small.webp'
  ],

  // Secciones acerca de
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

  // Lista de beneficios
  'benefits' => [
    [
      'image' => 'icon-name',
      'title' => Language::trans("{$sKey}.benefits.item1.title"),
      'text' => Language::trans("{$sKey}.benefits.item1.text"),
    ],
    // ... más beneficios
  ],

  // Casos de uso
  'use_cases' => [
    [
      'title' => Language::trans("{$sKey}.use_cases.item1.title"),
      'text' => Language::trans("{$sKey}.use_cases.item1.text"),
    ],
    // ... más casos de uso
  ],
];
```

#### Paso 3: Agregar Traducciones

Crear `lang/services/new_service.php`:

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
      // ... más items
    ],
    'use_cases' => [
      'item1' => [
        'title' => 'Caso de uso 1',
        'text' => 'Descripción',
      ],
      // ... más items
    ],
  ],
  'en' => [
    'hero' => [
      'title' => 'Service Title',
      'text' => 'Service description',
    ],
    // ... Traducciones en inglés
  ],
];
```

Luego cargarlo en ambos `lang/es.php` y `lang/en.php`:

```php
// Agregar al inicio del archivo
$servicesTranslations = loadLangServices();

return [
  // ... traducciones existentes

  // Agregar traducciones del servicio
  'new_service' => $servicesTranslations['new_service'][Language::getCurrentLanguage()],
];
```

#### Paso 4: Agregar Imágenes

Colocar imágenes en el directorio `public/images/services/` con los nombres especificados en tu archivo de contenido.

### Plantillas de Servicios

Hay tres tipos de plantillas disponibles:

1. **service-type-1**: Plantilla estándar de servicio con hero, beneficios y casos de uso
2. **service-type-2**: Layout alternativo con diferentes arreglos de secciones
3. **service-type-3**: Plantilla especializada con secciones personalizadas

Las plantillas están ubicadas en `app/Views/templates/`

### Modificar un Servicio

1. Actualizar configuración en `config/services.php`
2. Actualizar contenido en `content/services/{service-name}.php`
3. Actualizar traducciones en `lang/services/{service-name}.php`
4. Reemplazar imágenes en `public/images/services/`

### Deshabilitar un Servicio

Establecer `isActive` a `false` en `config/services.php`:

```php
'service-key' => [
  'isActive' => false,  // El servicio no será accesible
  // ... resto de la configuración
],
```

### Subcategorías de Servicios

Las subcategorías están definidas en `config/subcategories.php` y se usan para agrupar servicios. Actualiza este archivo para agregar nuevas subcategorías.

---

## Páginas Estáticas

Las páginas estáticas como Inicio y Contacto están configuradas de manera diferente a los servicios.

### Página de Inicio

**Ubicación**: `content/pages/home.php`

Estructura:

```php
<?php

use App\Models\Language;
use App\Models\Service;

return [
  'seoDescription' => Language::trans('home.description'),

  // Slider hero
  'hero' => [
    [
      'title' => Language::trans('home.hero.slide1.title'),
      'text' => Language::trans('home.hero.slide1.text')
    ],
    // ... más slides
  ],

  // Sección discover
  'discover' => [
    [
      'title' => Language::trans('home.discover_list.item1.title'),
      'text' => Language::trans('home.discover_list.item1.text'),
      'icon' => 'grow',
      'animation' => 'up'
    ],
    // ... más items
  ],

  // Otras secciones...
];
```

**Controlador**: `app/Controllers/HomeController.php`

**Vista**: `app/Views/templates/home.php`

### Página de Contacto

**Ubicación**: `content/pages/contact.php`

Estructura:

```php
<?php

use App\Models\Language;

return [
  'seoDescription' => Language::trans('contact.description'),

  'hero' => Language::trans('contact.hero'),
  'hero_text' => Language::trans('contact.hero_text'),

  // Configuración de campos del formulario
  'form' => [
    'name' => Language::trans('contact.form.name'),
    'email' => Language::trans('contact.form.email'),
    // ... más campos
  ],
];
```

**Controlador**: `app/Controllers/ContactController.php`

**Vista**: `app/Views/templates/contact.php`

### Crear una Nueva Página Estática

1. **Crear archivo de contenido** en `content/pages/new-page.php`:

```php
<?php

use App\Models\Language;

return [
  'seoDescription' => Language::trans('new_page.description'),
  'title' => Language::trans('new_page.title'),
  'content' => Language::trans('new_page.content'),
  // ... tus datos de página
];
```

2. **Crear controlador** en `app/Controllers/NewPageController.php`:

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

3. **Crear plantilla de vista** en `app/Views/templates/new-page.php`:

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
  <!-- Tu HTML de página -->
</section>
```

4. **Agregar ruta** en `config/routes.php`:

```php
$router->get('/new-page', 'App\\Controllers\\NewPageController', 'index');
```

5. **Agregar traducciones** en `lang/es.php` y `lang/en.php`:

```php
'new_page' => [
  'description' => 'Descripción de página para SEO',
  'title' => 'Título de Página',
  'content' => 'Contenido de página...',
],
```

6. **Agregar traducción de ruta** en `config/route-translations.php`:

```php
'new-page' => [
  'es' => 'nueva-pagina',
  'en' => 'new-page',
],
```

---

## Blog en Markdown

El blog bilingüe se almacena en Git y no requiere WordPress ni otro CMS durante la ejecución.

### Estructura del contenido

- `content/blog/en/{slug}.md` contiene los artículos en inglés.
- `content/blog/es/{slug}.md` contiene los artículos en español.
- `content/blog/categories.yaml` define categorías canónicas, etiquetas traducidas y slugs localizados.
- `public/images/blog/` contiene las portadas versionadas.
- `content/blog/README.md` contiene la guía breve de publicación.

Cada artículo utiliza front matter YAML seguido de Markdown:

```yaml
---
name: Título del artículo
cover: portada.webp
cover_alt: Texto alternativo descriptivo
url: slug-del-articulo
seo_description: Descripción para buscadores y redes sociales.
language: es
translation: translated-article-slug
date: 2026-08-31
updated: 2026-08-31
published: false
categories:
  - multilevel
author: Disruptive Studio
---
```

Los campos obligatorios son `name`, `cover`, `cover_alt`, `url`, `seo_description`, `language`, `date`, `published` y `categories`. El nombre del archivo debe coincidir con `url`, el idioma debe coincidir con su directorio y cada categoría y portada debe existir. Usa `published: true` para publicar; los borradores y fechas futuras permanecen ocultos.

El HTML crudo se elimina y los esquemas de URL inseguros se rechazan. Usa Markdown estándar para encabezados, énfasis, enlaces, listas, citas, código y tablas.

### Rutas y paginación

```text
GET /blog
GET /blog?page=2
GET /blog?category=multinivel
GET /blog/{slug-en-espanol}
GET /en/blog
GET /en/blog?page=2
GET /en/blog?category=multilevel
GET /en/blog/{slug-en-ingles}
```

Los listados muestran ocho artículos por página. Las páginas inválidas se ajustan al rango disponible, los parámetros de cursor `after` obsoletos se ignoran y el selector de idioma utiliza el slug de `translation` cuando existe el artículo publicado correspondiente.

### Validación

```bash
composer validate
vendor/bin/phpunit
vendor/bin/phpstan analyse --level=9
```

Los archivos inválidos se omiten y su error de validación se escribe en el registro de PHP.

---

## Formulario de Contacto y Email

El formulario de contacto incluye validación, protección reCAPTCHA v3 y envío de email.

### Cómo Funciona

1. **Frontend** (`public/assets/js/contact.js`):

- Valida campos del formulario
- Ejecuta reCAPTCHA v3
- Envía petición AJAX al backend

2. **Backend** (`app/Controllers/ContactController.php`):

- Valida puntuación de reCAPTCHA
- Valida datos del formulario
- Envía email vía PHPMailer
- Retorna respuesta JSON

3. **Servicio de Email** (`src/Mailer.php`):

- Configura conexión SMTP
- Formatea contenido del email
- Envía email a la dirección configurada

### Configuración del Formulario de Contacto

#### Variables de Entorno

```env
# Configuración SMTP
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls

# Información del remitente
MAIL_FROM_ADDRESS=noreply@disruptivestudio.com
MAIL_FROM_NAME="Disruptive Studio"

# Email del destinatario
MAIL_TO_ADDRESS=contact@disruptivestudio.com

# reCAPTCHA v3
RECAPTCHA_SITE_KEY=your-site-key
RECAPTCHA_SECRET_KEY=your-secret-key
RECAPTCHA_SCORE_THRESHOLD=0.5
```

#### Configuración para Gmail

Para Gmail, necesitas:

1. Habilitar autenticación de 2 factores
2. Generar una Contraseña de Aplicación
3. Usar la Contraseña de Aplicación en `MAIL_PASSWORD`

#### Reglas de Validación del Formulario

Definidas en `app/Models/Contact.php`:

```php
private array $rules = [
  'name' => ['required', 'min:2', 'max:100'],
  'email' => ['required', 'email'],
  'phone' => ['required', 'min:10', 'max:20'],
  'company' => ['required', 'max:100'],
  'message' => ['required', 'min:10', 'max:1000'],
];
```

#### Personalizar Plantilla de Email

Editar el método `sendContactForm()` en `src/Mailer.php`:

```php
public function sendContactForm(array $data): bool
{
  $subject = "Nueva Solicitud de Contacto - {$data['company']}";

  $body = "
    <h2>Nueva Solicitud de Contacto</h2>
    <p><strong>Nombre:</strong> {$data['name']}</p>
    <p><strong>Email:</strong> {$data['email']}</p>
    <p><strong>Teléfono:</strong> {$data['phone']}</p>
    <p><strong>Empresa:</strong> {$data['company']}</p>
    <p><strong>Mensaje:</strong></p>
    <p>{$data['message']}</p>
  ";

  return $this->send($subject, $body);
}
```

### Probar Funcionalidad de Email

Para desarrollo, puedes usar:

- **Mailtrap** (recomendado para pruebas)
- **Gmail** con Contraseña de Aplicación
- **SendGrid**
- **Servidor de correo local**

Ejemplo de configuración de Mailtrap:

```env
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

### Configuración de reCAPTCHA v3

1. Obtener claves del [Admin de Google reCAPTCHA](https://www.google.com/recaptcha/admin)
2. Agregar claves al archivo `.env`
3. Ajustar umbral de puntuación si es necesario (0.0 a 1.0, predeterminado 0.5)

Umbral más bajo = más permisivo
Umbral más alto = más estricto

---

## Desarrollo Frontend

### CSS con Tailwind CSS 4

El proyecto usa Tailwind CSS 4 con configuración personalizada.

**Archivos principales**:

- `public/assets/css/tailwind-config.css` - Configuración de Tailwind
- `public/assets/css/styles.css` - Salida compilada

**Comandos de compilación**:

```bash
# Modo desarrollo (con observación de archivos)
pnpm run dev

# Compilación de producción (minificado)
pnpm run build
```

**Configuración Personalizada de Tailwind**:

Editar `public/assets/css/tailwind-config.css`:

```css
@import "tailwindcss";

@theme {
  --color-primary: #tu-color;
  --font-sans: "Tu Fuente", sans-serif;
}

/* Utilidades personalizadas */
@layer utilities {
  .custom-class {
    /* Tus estilos */
  }
}
```

### JavaScript y Animaciones GSAP

**Ubicación**: `public/assets/js/`

**Archivos principales**:

- `main.js` - Funcionalidad principal
- `animations.js` - Animaciones GSAP
- `contact.js` - Manejo del formulario de contacto

**Agregar animaciones**:

```javascript
// Ejemplo de animación GSAP
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

### Recursos de Imágenes

**Ubicación**: `public/images/`

**Estructura**:

```
public/images/
├── services/          # Imágenes de páginas de servicios
├── home/             # Imágenes de página de inicio
├── icons/            # Archivos de iconos
└── common/           # Imágenes compartidas
```

**Convención de nombres**:

- Usar nombres descriptivos: `web3_hero_big.webp`
- Usar formato WebP para mejor rendimiento
- Proporcionar múltiples tamaños cuando sea necesario

### Iconos SVG

Los símbolos SVG están definidos en `temp/svg-symbols.php` y pueden usarse en línea:

```html
<svg>
  <use href="#nombre-icono"></use>
</svg>
```

---

## Configuración

### Variables de Entorno

Copiar `.env.example` a `.env` y configurar:

```env
# Aplicación
APP_ENV=production              # development, staging, production
APP_DEBUG=false                 # true para desarrollo
APP_URL=https://disruptivestudio.com

# Configuración de Correo
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

### Configuración Principal

**Archivo**: `config/config.php`

Contiene:

- Configuración de aplicación
- Configuración de correo
- Configuración de reCAPTCHA
- Configuración de idiomas

## Integración GoHighLevel Exit-Intent

El popup de salida envía leads a GoHighLevel mediante la API de contactos usando `POST /contacts/upsert`.
Si el contacto todavía no existe, HighLevel crea uno nuevo. Si el email o el teléfono ya existen en la ubicación, HighLevel actualiza el contacto existente.

### Variables `.env` Requeridas

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

### Qué Hace Cada Variable

- `GHL_BASE_URL`: URL base de la API de HighLevel. Mantén `https://services.leadconnectorhq.com`.
- `GHL_API_VERSION`: Header de versión de API requerido por esta integración. Mantén `2021-07-28`.
- `GHL_API_TOKEN`: Token de Private Integration con acceso a contactos.
- `GHL_LOCATION_ID`: Subcuenta o ubicación donde se creará o actualizará el contacto.
- `GHL_EXIT_INTENT_SOURCE`: Valor enviado como `source` de nivel superior del contacto en HighLevel.
- `GHL_EXIT_INTENT_TAGS`: Etiquetas separadas por comas que se aplican al contacto.
- `GHL_EXIT_INTENT_CF_*`: Mapeo de los custom fields de contacto de destino en HighLevel. Cada valor puede ser un ID real del campo o una key del campo.
- `GHL_EXIT_INTENT_VALUE_*`: Valores fijos que se escriben en los custom fields relacionados con campaña.

### Mapeo de Custom Fields Usado por Este Proyecto

La integración escribe estos valores en estos custom fields de contacto de HighLevel:

- Campaign medium: `sfmlm-website`
- Campaign name: `sfmlm-prevent-exit`
- Campaign source: `website`
- Ad ID: `sfmlm_exit_popup`
- Campaign content: `Website_prevent_user_from_leaving`
- Country: valor dinámico desde Cloudflare en producción, `Local` en desarrollo

El custom field `country` mantiene su comportamiento dinámico:

- Producción: usa el header `CF-IPCountry` de Cloudflare
- Entornos locales o de desarrollo: usa el fallback `Local`

### Cómo Obtener el Token de HighLevel

1. Abre HighLevel.
2. Ve a `Settings`.
3. Abre `Private Integrations`.
4. Crea una nueva integración.
5. Habilita los scopes necesarios para contactos.
6. Copia el token generado y guárdalo en `.env` como `GHL_API_TOKEN`.

### Cómo Obtener el Location ID

Usa cualquiera de estas opciones:

1. Abre la subcuenta objetivo y ve a `Settings > Business Profile`.
2. Copia el `Location ID`.

O:

1. Abre la subcuenta en el navegador.
2. Copia el valor después de `/location/` o desde `locationId=...` en la URL.

### Cómo Obtener los IDs o Keys de los Contact Custom Fields

Esta integración usa contact custom fields, no opportunity custom fields.

1. Abre la subcuenta correcta en HighLevel.
2. Ve a `Settings > Custom Fields`.
3. Busca los campos de contacto para:
   `Campaign medium`, `Campaign name`, `Campaign source`, `Ad ID`, `Campaign content` y `Country`.
4. Copia el ID del campo desde la UI o desde la petición de red, o usa la key del campo si ya la tienes.

Importante:

- No pongas valores de campo como `website`, `sfmlm_exit_popup` o `Local` dentro de `GHL_EXIT_INTENT_CF_*`.
- Esos valores fijos van en las variables `GHL_EXIT_INTENT_VALUE_*`.

### Archivos Involucrados

- Vista: `app/Views/components/exitPopup.php`
- Controlador: `app/Controllers/ExitIntentController.php`
- Modelo: `app/Models/ExitIntentLead.php`
- Cliente HighLevel: `app/Services/HighLevelClient.php`
- Configuración de la app: `config/config.php`

### Cómo Probar la Integración de Nuevo

1. Actualiza `.env`.
2. Reinicia PHP o los contenedores Docker si hace falta.
3. Limpia estas keys de `localStorage` en el navegador:
   `exit-intent-first-touch` y `exit-intent-form-submitted`.
4. Abre el sitio y envía nuevamente el popup de salida.
5. Verifica el contacto y los custom fields en GoHighLevel.

### Constantes

**Archivo**: `config/constants.php`

Define constantes globales usadas en toda la aplicación.

---

## Despliegue

### Despliegue de Producción

1. **Establecer entorno a producción**:

```env
APP_ENV=production
APP_DEBUG=false
```

2. **Compilar recursos**:

```bash
pnpm run build
```

3. **Instalar dependencias PHP**:

```bash
composer install --no-dev --optimize-autoloader
```

4. **Configurar servidor web** (ejemplo Nginx):

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

5. **Establecer permisos apropiados**:

```bash
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
```

### Producción con Docker

Usar la configuración Docker proporcionada:

```bash
docker-compose up -d
```

Para producción, considera:

- Usar un proxy inverso (Traefik, Nginx Proxy Manager)
- Configurar certificados SSL/TLS
- Configurar registro apropiado
- Configurar monitoreo


### Actualizaciones de seguridad de PHP (Docker)

PHP proviene del contenedor, no de Composer ni de la instalación del servidor.
Compose construye `Dockerfile` desde `trafex/php-nginx:latest`, actualiza los
paquetes de Alpine y comprueba la versión instalada. La construcción exige PHP
8.3.36+, 8.4.27+ o 8.5.12+ dentro de esas ramas para corregir CVE-2026-109618 y
CVE-2026-109619. Una nueva rama requiere revisar `scripts/check-php-version.php`.

En cada servidor Docker, incluido producción, ejecutar desde el repositorio:

```bash
docker compose build --pull --no-cache sfmlm-website
docker compose run --rm --no-deps sfmlm-website php /usr/local/lib/check-php-version.php
docker compose up -d --force-recreate sfmlm-website
docker compose exec -T sfmlm-website php /usr/local/lib/check-php-version.php
```

Después de recrear el contenedor, verificar el inicio, el blog en ambos idiomas y
los formularios. Recrear el único contenedor interrumpe brevemente las solicitudes.
Si los paquetes corregidos aún no están disponibles, obtener una imagen o
repositorio actualizado y reconstruir; no omitir la comprobación de versión.

Un Git pull o reinicio del contenedor no reemplaza PHP. El pipeline actual de
Azure solo descarga cambios; también se deben ejecutar los comandos anteriores
en el servidor de despliegue. Si producción utiliza otra configuración Docker,
debe construir este Dockerfile (o desplegar una imagen construida desde él) y
recrear sus contenedores. Actualizar PHP en el anfitrión no actualiza contenedores.

Aviso: [PHP, 21 de octubre de 2026](https://www.php.net/archive/2026.php#2026-10-21-5).


---

## Guías de Desarrollo

### Estilo de Código

- Seguir estándares de codificación PSR-12 para PHP
- Usar nombres significativos para variables y funciones
- Comentar lógica compleja
- Mantener funciones pequeñas y enfocadas

### Nomenclatura de Archivos

- Controladores: `PascalCase` (ej., `HomeController.php`)
- Vistas: `kebab-case` (ej., `service-type-1.php`)
- Archivos de contenido: `kebab-case` (ej., `aplicaciones-web3.php`)
- Archivos de traducción: `snake_case` (ej., `web3_app.php`)

### Agregar Funcionalidades

1. Planificar la funcionalidad y su impacto
2. Actualizar archivos de configuración
3. Crear controladores/modelos necesarios
4. Agregar traducciones para todos los idiomas
5. Crear/actualizar plantillas de vista
6. Probar exhaustivamente
7. Documentar cambios

### Mejores Prácticas

- Siempre sanitizar entrada de usuario con `esc()` o `e()` en vistas
- Usar constantes de idioma en lugar de texto hardcodeado
- Mantener traducciones organizadas y consistentes
- Optimizar imágenes antes de agregarlas
- Probar en múltiples navegadores y dispositivos
- Mantener dependencias actualizadas

---

## Solución de Problemas

### Problemas Comunes

**Problema**: CSS no se actualiza

- Solución: Ejecutar `pnpm run build` o reiniciar `pnpm run dev`

**Problema**: Los servicios no se muestran

- Solución: Verificar que `isActive` sea `true` en `config/services.php`

**Problema**: Los emails no se envían

- Solución: Verificar configuración de correo en `.env` y probar conexión SMTP

**Problema**: El cambio de idioma no funciona

- Solución: Limpiar caché del navegador y verificar configuración de idiomas

**Problema**: Errores 404

- Solución: Verificar que las reglas de reescritura de Nginx/Apache estén configuradas correctamente

### Modo de Depuración

Habilitar modo de depuración en `.env`:

```env
APP_DEBUG=true
```

Esto mostrará mensajes de error detallados.

---

## Recursos Adicionales

- [Documentación de PHP](https://www.php.net/docs.php)
- [Documentación de Tailwind CSS](https://tailwindcss.com/docs)
- [Documentación de GSAP](https://greensock.com/docs/)
- [Documentación de PHPMailer](https://github.com/PHPMailer/PHPMailer)

---

## Soporte

Para preguntas o problemas:

- Contactar al equipo de desarrollo
- Revisar la documentación del código
- Verificar los archivos de configuración

---

## Licencia

Propietario - Disruptive Studio © 2025
