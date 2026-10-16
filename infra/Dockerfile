FROM composer:2 AS composer

FROM php:8.2-apache

RUN docker-php-ext-install pdo_mysql \
    && printf '%s\n' \
        '<Directory /var/www/html>' \
        '    AllowOverride All' \
        '    Options -Indexes' \
        '    Require all granted' \
        '</Directory>' \
        > /etc/apache2/conf-available/legendarystore.conf \
    && a2enconf legendarystore

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY config.php /opt/legendarystore/config.php
COPY entrypoint.sh /usr/local/bin/legendarystore-entrypoint
RUN sed -i 's/\r$//' /usr/local/bin/legendarystore-entrypoint \
    && chmod +x /usr/local/bin/legendarystore-entrypoint

WORKDIR /var/www/html
ENTRYPOINT ["legendarystore-entrypoint"]
CMD ["apache2-foreground"]
