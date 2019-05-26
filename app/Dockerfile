FROM php:apache
RUN docker-php-ext-install mysqli
COPY src/index.php /var/www/html
EXPOSE 80