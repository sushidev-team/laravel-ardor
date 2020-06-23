<?php

return [

    /*
    |--------------------------------------------------------------------------
    | ARDOR 
    |--------------------------------------------------------------------------
    |
    */

    'cache_driver'  => env('ARDOR_CACHE_DRIVER', env('CACHE_DRIVER', 'file')),
    'cache_send'    => env('ARDOR_CACHE_REQUEST', true),

    // Full URL to ardor node
    'node'   => env('ARDOR_NODE',   null),
    // eg. ARDOR-3H9G-7TE4-VEQR-98YXG
    'wallet' => env('ARDOR_WALLET', null),
    // eg. worship suspend name true reflect bird despite class question flow stair terrible
    'secret' => env('ARDOR_SECRET', null),
    // Admin pasword
    'adminPassword' => env('ARDOR_ADMINPW', null),
    // Contracts
    'contracts' => [

    ],
    // Bundlers
    'bundlers' => [
        \AMBERSIVE\Ardor\Bundlers\DefaultTransactionBundler::class
    ],

    // Bundler settings
    'bundlerSettings' => [

        '\AMBERSIVE\Ardor\Bundlers\DefaultTransactionBundler' => [
            'accounts' => [
                'ARDOR-DAZJ-VVSM-552M-8K459'
            ]
        ]

    ]
];
