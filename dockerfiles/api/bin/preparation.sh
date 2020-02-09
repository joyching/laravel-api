#!/bin/bash

composer install --no-interaction

php artisan key:generate

php artisan migrate --seed --no-interaction

if [ ! -f ./storage/oauth-public.key ]; then
    php artisan passport:install
fi
