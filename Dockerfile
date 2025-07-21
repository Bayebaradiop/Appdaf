# Dockerfile pour AppDAF (PHP)
FROM php:8.2-fpm
WORKDIR /var/www/html
COPY . .
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql
EXPOSE 9000
CMD ["php-fpm"]
