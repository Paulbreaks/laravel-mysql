#!/bin/bash

# Установка нужных папок и прав
mkdir -p storage/framework/{sessions,views,cache}
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Кешируем конфиг Laravel
cd /var/www/html
php artisan config:clear
php artisan config:cache

# Запускаем Apache
exec apache2-foreground
