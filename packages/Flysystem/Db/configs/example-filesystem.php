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
            'files-table' => 'files',
            'contents-table' => 'files_contents',
            'path_prefix' => '',
        ]
    ],

];
