# INSTALL

## Installation

1. clone project form [git](git@github.com:jcaicedo/cube-summation.git)
2. set up the virtual host with the document root `www/public`
3. run `composer install` (developent) or `composer install --no-dev` (production)
4. run `bower install`
5. rename `.env.example` to `.env` an configure the applcation settings
6. run `php artisan key:generate`
6. run `php artisan migrate`
7. (Optional) run `php artisan db:seed`
