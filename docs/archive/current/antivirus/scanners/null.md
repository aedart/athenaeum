---
description: About Null Scanner
sidebarDepth: 0
---

# Null

**Driver**: `\Aedart\Antivirus\Scanners\NullScanner`

The Null scanner is intended for testing, or situation when a scanner is required, yet not intended to trigger an actual virus-scan.
For instance, if your application runs CI tests of file uploads, then this driver might be helpful, if you wish to disable scanning of those files.

## Options

The following shows the available options for the Null scanner.

```php
return [

    // ...previous not shown...

    /*
    |--------------------------------------------------------------------------
    | Scanner Profiles
    |--------------------------------------------------------------------------
    */

    'profiles' => [

        'null' => [
            'driver' => \Aedart\Antivirus\Scanners\NullScanner::class,
            'options' => [

                // Whether scanner should "pass" file scans (true), or
                // "fail" them (false).
                'should_pass' => false,
            ],
        ]
        
        // ...other profiles not shown...
    ]
];
```