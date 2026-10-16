#!/bin/sh
set -eu

cd /var/www/html

if [ ! -f app/config/config.php ]; then
    cp /opt/legendarystore/config.php app/config/config.php
fi

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --no-dev --prefer-dist
fi

exec docker-php-entrypoint "$@"
