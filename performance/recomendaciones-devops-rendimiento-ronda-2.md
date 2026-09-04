# Recomendaciones DevOps — segunda ronda de rendimiento

Fecha: 4 de septiembre de 2026

## Objetivo y restricciones

Estas acciones complementan los cambios del código de la rama `second-performance-improvements`. La detección de idioma es funcionalmente obligatoria: una primera visita con navegador en español debe obtener español; cualquier otro idioma debe obtener inglés, también en enlaces profundos. La selección manual se conserva en la cookie `site_language`. Por eso **no se debe habilitar “Cache Everything” para HTML sin una clave de caché consciente del idioma y de las cookies**.

El chat de LeadConnector en inglés es crítico para ventas. El código inicia su descarga en el primer período ocioso, con un límite duro de 1 segundo desde que carga el módulo. El objetivo operativo es que sea visible antes de 5 segundos; Meta Pixel, Clarity y Metricool siguen separados y esperan interacción o 30 segundos. GTM comienza después de `window.load`.

## Cambios para aplicar en origen

1. Desplegar `nginx-conf/default.conf`. La regla de estáticos entrega CSS, JavaScript, fuentes, SVG e imágenes con `Cache-Control: public, max-age=31536000, immutable`, activa gzip como respaldo y evita que esos archivos pasen por PHP.
2. Ejecutar en el pipeline, antes de publicar:

   ```bash
   corepack pnpm install --frozen-lockfile
   corepack pnpm run build
   ```

   El build genera el sprite estático `public/assets/icons.svg`, las variantes AVIF/WebP y el CSS minificado. No omitir los archivos `*-w*.avif` y `*-w*.webp` del artefacto de despliegue.
3. Habilitar y verificar OPcache en PHP-FPM. Valores iniciales razonables para este sitio:

   ```ini
   opcache.enable=1
   opcache.memory_consumption=128
   opcache.interned_strings_buffer=16
   opcache.max_accelerated_files=10000
   opcache.validate_timestamps=1
   opcache.revalidate_freq=60
   ```

   Si los despliegues reinician PHP-FPM de forma atómica, se puede usar `opcache.validate_timestamps=0` y reiniciar FPM en cada release.
4. Retirar de futuras configuraciones el tratamiento especial de `public/assets/icons.svg.php`: las vistas ya usan el sprite estático con versión en la URL. Se puede conservar temporalmente el endpoint PHP por compatibilidad, pero no debe recibir tráfico normal.

## Cambios en Cloudflare

### Regla de caché para archivos estáticos

Crear una Cache Rule para rutas que empiecen por `/public/` y cuya extensión sea estática. Configurar:

- elegible para caché;
- Edge TTL: 1 año;
- Browser TTL: respetar el origen o 1 año;
- servir contenido obsoleto mientras se revalida, si el plan lo permite;
- conservar el query string en la cache key, porque `asset_url()` lo usa como versión;
- no ignorar los parámetros de consulta.

Purgar `/public/assets/icons.svg*`, `/public/assets/css/styles.css*`, `/public/assets/js/*` y `/public/images/home/bo-computer-*` durante el primer despliegue. En releases posteriores, el query string versionado evita purgas para CSS, JS, fuentes y sprite.

### HTML y detección de idioma

En esta ronda, dejar HTML/PHP en `Bypass cache` en Cloudflare. El origen ya marca documentos públicos con `s-maxage=300`, pero Cloudflare mostraba estado `DYNAMIC`; es preferible conservarlo así antes que servir el idioma equivocado.

Si se decide cachear HTML más adelante, hacerlo mediante Worker o una política equivalente que cumpla todo lo siguiente:

- excluir peticiones con `ref`, sesión PHP o cookies distintas de las estrictamente necesarias;
- incluir en la clave la ruta canónica y el idioma resuelto (`site_language`, y `Accept-Language` cuando no existe esa cookie);
- no almacenar respuestas con `Set-Cookie`;
- no mezclar redirecciones entre `/...` y `/en/...`;
- probar portada y enlaces profundos con navegadores `es`, `en`, `fr` y con selección manual previa.

No confiar únicamente en `Vary: Accept-Language, Cookie`: los CDN no siempre crean automáticamente una variante segura para cada cookie.

### Transporte y optimizadores automáticos

- Mantener Brotli, HTTP/2, HTTP/3 y Early Hints activos; ya estaban funcionando correctamente.
- Verificar que el Early Hint de portada apunte a `/public/images/home/bo-computer-w640.avif`, no al WebP original.
- Crear una regla para desactivar Rocket Loader y cualquier reescritura automática de JavaScript en este sitio. Los módulos ya controlan explícitamente el orden de chat, GTM y marketing; otra capa de aplazamiento podría romper el SLA de 5 segundos del chat.
- Mantener Polish/Image Resizing desactivado para las variantes generadas, o configurarlo sin volver a recomprimir AVIF/WebP. No se necesitan dos pipelines de transformación.

## Monitoreo y validación posterior al despliegue

Ejecutar estas comprobaciones desde fuera de la red del servidor:

```bash
curl -sI https://softwareformlm.com/public/assets/icons.svg
curl -sI https://softwareformlm.com/public/images/home/bo-computer-w640.avif
curl -sI -H 'Accept-Language: es-CO,es;q=0.9' https://softwareformlm.com/
curl -sI -H 'Accept-Language: en-US,en;q=0.9' https://softwareformlm.com/
curl -sI -H 'Cookie: site_language=en' https://softwareformlm.com/
```

Para estáticos se espera `CF-Cache-Status: HIT` después de la primera petición, `Age` creciente, Brotli cuando sea compatible y un TTL de un año. Para HTML se espera `DYNAMIC` o `BYPASS` en esta ronda.

En DevTools, con caché vacía y red Fast 3G, confirmar:

- la solicitud de `loader.js` de LeadConnector comienza antes de 1 segundo después de ejecutar `third-parties.js` y el chat aparece antes de 5 segundos en `/en`;
- el chat no se solicita en español;
- GTM se solicita después de `load`;
- Meta, Clarity y Metricool se solicitan en la primera interacción o, sin interacción, cerca de los 30 segundos;
- no hay doble carga de Meta, Clarity o Metricool desde GTM y desde el código. Si GTM ya publica uno de ellos, eliminar la etiqueta duplicada del contenedor de GTM, no reintroducirla en el HTML.

Registrar durante siete días Core Web Vitals de campo por plantilla e idioma. Comparar p75 de LCP, INP y CLS, además de errores del chat y conversiones. Hacer rollback de una regla de Cloudflare de inmediato si aparecen respuestas con idioma incorrecto, recursos obsoletos o pérdida de eventos.
