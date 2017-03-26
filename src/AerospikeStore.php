<?php
/**
 * Created by PhpStorm.
 * User: makbulut
 * Date: 22/03/2017
 * Time: 07:51
 */

namespace Makbulut\Aerospike;

use Illuminate\Contracts\Cache\Store;

class AerospikeStore implements Store
{

    protected $aerospike;

    protected $prefix;

    protected $namespace;

    const ARRAY_KEY = 'scv';

    public static $option = [
        \Aerospike::OPT_POLICY_EXISTS => \Aerospike::POLICY_EXISTS_CREATE_OR_REPLACE,
        \Aerospike::OPT_POLICY_KEY => \Aerospike::POLICY_KEY_SEND
    ];

    /**
     * Create a new Aerospike store.
     *
     * @param  \Aerospike $aerospike
     * @param  string $prefix
     * @param  string $namespace
     */
    public function __construct(\Aerospike $aerospike, $prefix = '', $namespace = '')
    {
        $this->aerospike = $aerospike;
        $this->namespace = $namespace;
        $this->prefix = strlen($prefix) > 0 ? $prefix.':' : '';
    }
    public function get($key)
    {
        $start_time = microtime(true);

        $result = array();
        $status = $this->aerospike->get($this->getKey($key), $result);

        $end_time =  microtime(true) - $start_time;
        scv_info_msg("aerospike cache get time: ".$key." -> ".$end_time);

        if ($status == \Aerospike::OK && isset($result['bins'][self::ARRAY_KEY])) {
            return $result['bins'][self::ARRAY_KEY];
        } else {
            return null;
        }
    }
    public function put($key, $value, $minutes)
    {
        $minutes = max(1, $minutes);

        $status = $this->aerospike->put($this->getKey($key), [self::ARRAY_KEY => $value], $minutes * 60, self::$option);
    }

    public function increment($key, $value = 1)
    {
        $status = $this->aerospike->increment($this->getKey($key), self::ARRAY_KEY, $value);
    }

    public function decrement($key, $value = -1)
    {
        $status = $$this->increment($key, $value);
    }

    public function forever($key, $value)
    {
        $status = $this->aerospike->put($this->getKey($key), [self::ARRAY_KEY => $value], 0, self::$option);
    }

    public function forget($key)
    {
        $this->aerospike->remove($this->getKey($key));
    }

    public function flush()
    {
        //todo: implement after
    }
    public function getPrefix()
    {
        return $this->prefix;
    }

    private function getKey($key)
    {
        return $this->aerospike->initKey($this->namespace, $this->prefix, $key);
    }
}