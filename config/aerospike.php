<?php
/**
 * Created by PhpStorm.
 * User: makbulut
 * Date: 22/03/2017
 * Time: 07:28
 */


return [

    'driver' => 'aerospike',
    'namespace' => env('AEROSPIKE_NAMESPACE', 'test'),
    'servers' => [
        "hosts" => [
            [
                "addr" => env('AEROSPIKE_HOST', 'localhost'),
                "port" => (int) env('AEROSPIKE_PORT', 3000)
            ]
        ]
    ]

];
