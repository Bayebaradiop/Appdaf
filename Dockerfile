# Dockerfile pour AppDAF (PHP)
FROM php:8.2-fpm

# Installe nginx, supervisor et extensions nécessaires
RUN apt-get update && \
    apt-get install -y nginx supervisor libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

WORKDIR /var/www/html

COPY . .
COPY nginx.conf /etc/nginx/sites-available/default
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN rm /etc/nginx/sites-enabled/default && \
    ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Installe Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    php -r "unlink('composer-setup.php');"

RUN composer install
RUN composer database:migrate

EXPOSE 80
CMD ["/usr/bin/supervisord"]
