---
description: Setting the Http Protocol Version
sidebarDepth: 0
---

# Protocol Version

By default, Http protocol version `1.1` is used for each of your requests.
Should you need to send a request with a different version, then `useProtocolVersion()` will allow you to do so.

```php
$builder = $client
        ->useProtocolVersion('1.0');
```

## Via Configuration

The protocol version number can also be set via `configs/http-clients.php`.

```php
<?php

return [

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [
                
                'version' => '1.0'

                // ... remaining not shown ...
            ]
        ],
    ],
];
```

