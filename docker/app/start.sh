#!/usr/bin/env sh

_="$(dirname "$0")"

# Create .env
cp .env.example .env

$_/user_setup www-data
$_/composer

echo "==> Running migration"
php artisan migrate
php artisan jwt:secret -f

# Start php-fpm
echo "===> Initializing php-fpm"
php-fpm