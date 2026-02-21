#!/bin/bash
set -e
WEBROOT=/var/www/html
for d in upload storage cache tmp; do
  if [ -d "$WEBROOT/$d" ]; then
    chown -R webapp:webapp "$WEBROOT/$d" || true
    chmod -R 775 "$WEBROOT/$d" || true
  fi
done
# ensure php error log exists
if [ ! -f /var/log/php_errors.log ]; then
  touch /var/log/php_errors.log || true
fi
chown webapp:webapp /var/log/php_errors.log || true
chmod 664 /var/log/php_errors.log || true
