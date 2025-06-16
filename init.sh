composer install &&
cp .env.example .env &&
php artisan migrate &&
php artisan db:seeder --class AdminSeeder &&
php artisan db:seeder --class CategorySeeder &&
php artisan storage:link &&
composer dump-autoload