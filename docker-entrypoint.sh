#!/bin/bash
set -e

php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan storage:link
php artisan migrate --force

exec "$@"