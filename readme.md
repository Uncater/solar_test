Project Description
===================

A Laravel test project.

Created for Solar.

Prerequisites and versions
-------------
PHP7, MySQL, Laravel 5.4, Composer

Installation instructions
=========================

1. clone via SourceTree or `https://github.com/Uncater/solar_test.git`
2. `cd solar_test/`
3. `composer install`
4. Set DB name and user in env file (use your local user), set APP_URL
5. Migrate DB schema `php artisan migrate`
6. Set environment key `php artisan key:generate`
7. Run Tests

    7.1 vendor/bin/phpunit

    7.2 php artisan dusk


