FROM php:8.2-apache

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    nano \
    libpq-dev && \
    docker-php-ext-install pdo pdo_mysql

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Настраиваем DocumentRoot
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot ${APACHE_DOCUMENT_ROOT}|' /etc/apache2/sites-available/000-default.conf

# Включаем mod_rewrite и AllowOverride All
RUN sed -i 's|AllowOverride None|AllowOverride All|g' /etc/apache2/apache2.conf && \
    a2enmod rewrite

# Копируем Laravel-проект внутрь контейнера
COPY ./src /var/www/html

# Копируем entrypoint-скрипт и делаем его исполняемым (ВСТАВЛЯЕШЬ СЮДА)
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

# Устанавливаем зависимости
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Указываем скрипт запуска
CMD ["/usr/local/bin/entrypoint.sh"]