<?php
/**
 * Created by PhpStorm.
 * User: makbulut
 * Date: 22/03/2017
 * Time: 07:28
 */

namespace Makbulut\Aerospike;

use Cache;
use Illuminate\Support\ServiceProvider;

class AerospikeServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

       /* $configPath = __DIR__ . '/../config/aerospike.php';
        $this->mergeConfigFrom($configPath, 'aerospike');

		$this->app->singleton('aerospike', function ($app) {
			$config = $this->app['config'];

			if ($config['cache.stores.aerospike.servers']) {
				$config = $config['cache.stores.aerospike.servers'];
			} else {
				$config = ["hosts" => [["addr" => "localhost", "port" => 3000]]];
			}

			$db = new \Aerospike($config);
			return $db;
		});*/
	}

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../config/aerospike.php';
        $this->publishes([$configPath => config_path('aerospike.php')], 'config');


        Cache::extend('aerospike', function ($app) {

            $config = $app['config'];

            if ($config['aerospike.servers']) {
                $config = $config['aerospike.servers'];
            } else {
                $config = ["hosts" => [["addr" => "localhost", "port" => 3000]]];
            }

            $aerospike = new \Aerospike($config);

            $store = new AerospikeStore($aerospike, $this->getPrefix($config), $config['namespace']);

            return Cache::repository($store);
        });
    }


    /**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('aerospike');
	}

    protected function getPrefix(array $config)
    {
        return array_get($config, 'prefix') ?: $this->app['config']['cache.prefix'];
    }
}
