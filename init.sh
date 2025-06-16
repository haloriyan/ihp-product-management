composer install &&
cp .env.example .env &&
php artisan migrate &&
php artisan db:seed --class AdminSeeder &&
php artisan db:seed --class CategorySeeder &&
php artisan storage:link &&
composer dump-autoload