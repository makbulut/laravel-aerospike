<?php

return [

    'namespace' => env('AEROSPIKE_NAMESPACE', 'test'),
    'servers' => [
        "hosts" => [
            [
                "addr" => env('AEROSPIKE_HOST', 'localhost'),
                "port" => env('AEROSPIKE_PORT', 3000)
            ]
        ]
    ]

];