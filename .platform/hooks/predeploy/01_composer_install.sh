#!/bin/bash
set -e
# Run composer install in the staging directory so vendor/ is populated before the app is deployed
STAGING_DIR="/var/app/staging"
if [ -d "$STAGING_DIR" ]; then
  cd "$STAGING_DIR"
  if [ -f composer.json ]; then
    echo "Found composer.json — installing dependencies"
    if command -v composer >/dev/null 2>&1; then
      composer install --no-dev --optimize-autoloader --no-interaction
    else
      # Fallback to installer if composer binary is not present
      php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
      && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
      && rm composer-setup.php
      composer install --no-dev --optimize-autoloader --no-interaction
    fi
  else
    echo "No composer.json found in $STAGING_DIR — skipping composer install"
  fi
else
  echo "$STAGING_DIR not found — skipping composer install"
fi
