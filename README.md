# Product Management System

This is project as required for my recruitment process at PT Imperium Happy Puppy as Web Developer.

Once you have cloned this repository, run :

```
./init.sh
php artisan serve
```

You don't have to run `composer install` or anything install because it has been included inside this shell executable file. If you are using windows and experiencing an issue when initiating this repository, you may need to run each command one by one that written inside `init.sh` file.

```
composer install &&
cp .env.example .env &&
php artisan key:generate &&
php artisan migrate &&
php artisan db:seed --class AdminSeeder &&
php artisan db:seed --class CategorySeeder &&
php artisan storage:link &&
composer dump-autoload
```

Login credentials :
```
username : admin
password : admin123
```