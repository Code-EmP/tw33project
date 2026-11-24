#!/bin/sh
set -e

port="${PORT:-10000}"
sed -ri "s/^Listen 80$/Listen ${port}/" /etc/apache2/ports.conf
sed -ri "s#<VirtualHost \*:80>#<VirtualHost *:${port}>#" /etc/apache2/sites-available/000-default.conf

php artisan migrate --force
php artisan db:seed --class=AdminBootstrapSeeder --force
php artisan db:seed --class=DemoUserBootstrapSeeder --force
exec apache2-foreground
