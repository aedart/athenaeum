<?php

/**
 * @deprecated
 */
return [

    /*
     |--------------------------------------------------------------------------
     | Paths
     |--------------------------------------------------------------------------
     |
     | By default, the application's "lang" directory is searched, along with any
     | namespace and json paths registered by service providers that are booted.
     | Use this to state additional paths to search in.
    */

    'paths' => [

        realpath(__DIR__ . '/../../../../vendor/laravel/framework/src/Illuminate/Translation/lang')

    ],
];
