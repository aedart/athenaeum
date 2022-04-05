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

    'default' => env('MIME_TYPE_DETECTOR', 'default'),

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
                //
                // If size is set to `0` then entire data / contents is used
                // by sampler (not recommended).
                //
                // If you are having trouble detecting mime-type, you can
                // try increasing the sample size.
                // The `file` command in linux systems uses a maximum of
                // 1048576 bytes (~1 MB) as default, when attempting to
                // determine mime-type, ...etc
                //
                // @see https://manpages.debian.org/bullseye/file/file.1.en.html
                'sample_size' => 1048576,

                // Magic database to be used.
                //
                // Unless you are playing with custom "magic" databases, it is
                // recommended that you leave this to `null`.
                //
                // @see https://www.php.net/manual/en/function.finfo-open.php
                // @see https://manpages.debian.org/bullseye/file/file.1.en.html
                'magic_database' => null,
            ]
        ]
    ]
];
