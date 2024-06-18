<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Default Mime-Type detection profiles
     |--------------------------------------------------------------------------
     |
     | The default profiles to be used, when no specific detector profile
     | requested.
    */

    'default' => 'default',

    /*
     |--------------------------------------------------------------------------
     | Detector profiles
     |--------------------------------------------------------------------------
     |
     | List of available mime-type detection profiles.
    */

    'detectors' => [

        'default' => [
            'driver' => \Aedart\MimeTypes\Drivers\FileInfoSampler::class,
            'options' => [

                // Default sample size in bytes.
                // If size is set to `0` then entire data / contents is used
                // by sampler.
                'sample_size' => 1048576,

                // Magic database to be used.
                // @see https://www.php.net/manual/en/function.finfo-open.php
                'magic_database' => null,
            ]
        ],

        'file-info' => [
            'driver' => \Aedart\MimeTypes\Drivers\FileInfoSampler::class,
            'options' => [
//                'sample_size' => 1048576,
                'sample_size' => \Aedart\Contracts\Streams\BufferSizes::BUFFER_128KB,
                'magic_database' => null
            ]
        ]
    ]
];
