---
description: About Cache Exporter
sidebarDepth: 0
---

# Cache

**Driver**: `\Aedart\Translation\Exports\Drivers\CacheExporter`

A wrapper exporter that caches the resulting translations from another exporter.
Configure the exporter profile in your `config/translations-exporter.php`:

```php
return [

    // ...previous not shown...
    
    /*
    |--------------------------------------------------------------------------
    | Exporter Profiles
    |--------------------------------------------------------------------------
    */

    'profiles' => [

        'cache' => [
            'driver' => \Aedart\Translation\Exports\Drivers\CacheExporter::class,
            'options' => [
                // The exporter to use
                'exporter' => 'lang_js_json',

                // The cache store to use
                'cache' => env('CACHE_DRIVER', 'file'),

                // Time-to-live (in seconds)
                'ttl' => 3600,

                // Cache key prefix
                'prefix' => 'trans_export_'
            ],
        ]

        'lang_js_json' => [
            'driver' => \Aedart\Translation\Exports\Drivers\LangJsJsonExporter::class,
            'options' => [
                'json_key' => '__JSON__',
                'json_options' => 0,
                'depth' => 512
            ],
        ],

        // ... remaining profiles not shown...
    ]
];
```