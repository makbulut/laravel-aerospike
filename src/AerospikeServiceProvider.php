<?php
/**
 * Created by PhpStorm.
 * User: makbulut
 * Date: 22/03/2017
 * Time: 07:28
 */

namespace Makbulut\Aerospike;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AerospikeServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/aerospike.php', 'cache.stores.aerospike');

        Cache::extend('aerospike', function ($app) {

            $config = $app['config'];

            $server = $config['cache.stores.aerospike.servers'];

            $aerospike = new \Aerospike($server);

            $store = new AerospikeStore($aerospike, $config['cache.prefix'], $config['cache.stores.aerospike.namespace']);

            return Cache::repository($store);
        });
    }

}
