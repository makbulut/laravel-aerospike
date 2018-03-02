# Laravel Aerospike Cache Driver

[Aerospike](http://www.aerospike.com/) Cache driver for [Laravel 5](http://laravel.com/). This package makes it easy to store cached data in Aerospike.



## 📦 Installation

Make sure you have the Aerospike PHP client installed. You can find installation instructions at http://www.aerospike.com/docs/client/php/install


To install this package you will need:

* Laravel 5.0+
* PHP 5.5.9+

You must then modify your `composer.json` file and run `composer update` to include the latest version of the package in your project.

```json
"require": {
    "makbulut/laravel-aerospike": "1.2"
}
```

Or you can run the composer require command from your terminal.

```bash
composer require makbulut/laravel-aerospike:1.2
```

## 🔧 Configuration

#### Provider

Setup service provider in `config/app.php`

```php
Makbulut\Aerospike\AerospikeServiceProvider::class
```

#### Environment

Change the cache driver in .env to aerospike:

```
CACHE_DRIVER=aerospike
```

Add aerospike server informations to `.env` file.

```
AEROSPIKE_HOST=172.28.128.3
AEROSPIKE_PORT=3000
AEROSPIKE_NAMESPACE=test
```

## 📌 Usage

```php
Cache::store('aerospike')->get('key_1');
Cache::store('aerospike')->put('key_1', 1, 5 );
Cache::store('aerospike')->increment('rest_1', 1);
Cache::store('aerospike')->decrement('rest_1', 1);
Cache::store('aerospike')->forever('key_1', 1);
Cache::store('aerospike')->forget('key_1');
```

Or

```php
Cache::get('key_1');
Cache::put('key_1', 1, 5 );
Cache::increment('rest_1', 1);
Cache::decrement('rest_1', 1);
Cache::forever('key_1', 1);
Cache::forget('key_1');
```

For more information about Caches, check http://laravel.com/docs/cache.

## 📄 License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
