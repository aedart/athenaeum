<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Example filesystem.php configuration
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    */

    'disks' => [

        // ...previous not shown...

        'database' => [
            'driver' => 'database',
            'connection' => env('DB_CONNECTION', 'mysql'),
            'files_table' => 'files',
            'contents_table' => 'files_contents',
            'hash_algo' => 'sha256',
            'path_prefix' => '',
            'throw' => true
        ]
    ],

];
