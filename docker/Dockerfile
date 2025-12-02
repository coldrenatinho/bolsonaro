FROM php:8.2-fpm

# Instalar extensões PHP necessárias (sem GD por enquanto para simplificar)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Configurações do PHP para upload
RUN { \
    echo 'upload_max_filesize = 10M'; \
    echo 'post_max_size = 10M'; \
    echo 'memory_limit = 256M'; \
    echo 'max_execution_time = 300'; \
} > /usr/local/etc/php/conf.d/uploads.ini

# Definir diretório de trabalho
WORKDIR /var/www/html

# Criar diretório de uploads (será criado via volume mount)
RUN mkdir -p /var/www/html/uploads/galeria \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html