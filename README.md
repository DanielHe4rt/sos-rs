## SOS-RS

Up and running
```
composer install
cp .env.example .env
php artisan key:generate
vendor/bin/sail up -d
# Expose the app behind a SSL certificate, to be able to use the browser API for Navigation
sail share
```
