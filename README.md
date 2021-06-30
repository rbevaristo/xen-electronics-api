# XenElectronics API

XenElectronics API is a simple REST API created using Laravel a PHP Framework.

# Getting Started

## Pre-requisites

* PHP >= 7.3
* Mysql
* [Composer](https://getcomposer.org/)

## Starting the app
* Download dependencies
```
composer install
```

* Create a `.env` file
```
cp .env.example .env
```

* Generate APP_KEY
```
php artisan key:generate
```

* Create a database and update `.env` configuration
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=xenelectronicsdb
DB_USERNAME=root
DB_PASSWORD=
```

* Run migration to create database tables
```
php artisan migrate
```

* Create Passport keys
```
php artisan passport:install
```

* Load Seeder Files, if seeder files did not work run `composer dump-autoload`
```
php artisan db:seed
```
* Run the API Server
```
php artisan serve
``` 

## Running Test

* Create a env for tests.
```
cp .env.example .env.testing
```

* Copy APP_KEY value on `.env` and paste it on `.env.testing` APP_KEY

* Change database configuration
```
DB_CONNECTION=sqlite
DB_DATABASE=./test.sqlite
```

* Create a sqlite file
```
touch test.sqlite
```

* Change config to test environment `--env=testing` will use configuration on `.env.testing`
```
php artisan config:cache --env=testing
``` 

* If want to go back to local environment
```
php artisan config:cache --env=local
```

* Execute tests
```
php artisan test
```
