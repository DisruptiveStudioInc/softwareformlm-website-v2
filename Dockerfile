FROM trafex/php-nginx:latest

USER root

# Refresh Alpine packages even when the upstream image predates a security release.
RUN apk upgrade --no-cache

COPY scripts/check-php-version.php /usr/local/lib/check-php-version.php
# Fail the build if the package repositories do not yet provide a patched PHP.
RUN php /usr/local/lib/check-php-version.php

USER nobody
