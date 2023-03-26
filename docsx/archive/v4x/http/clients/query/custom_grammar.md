---
description: Custom Http Query Grammar
sidebarDepth: 0
---

# Custom Grammar

When the default provided Http Query Grammars prove to be insufficient, then you can choose to create a custom grammar.

[[TOC]]

## Extend Existing Grammars

If you only require a few tweaks, e.g. when you just wish to alter the "limit" and "offset" keywords, then it's probably easiest to just extend one of the existing grammars.

```php
<?php

namespace Acme\Http\Query\Grammars;

use Aedart\Http\Clients\Requests\Query\Grammars\DefaultGrammar;

class MyCustomGrammar extends DefaultGrammar
{
    protected string $limitKey = 'take';

    protected string $offsetKey = 'skip';

    // ... etc
}
```

Once you have performed your adaptations, simply create a new grammar profile in your `configs/http-clients.php` and make use of it.

```php
<?php

return [
    // ... previous not shown ...

    'grammars' => [

        'profiles' => [

            'custom' => [
                'driver' => \Acme\Http\Query\Grammars\MyCustomGrammar::class,
                'options' => [

                    // ... remaining not shown ...
                ]
            ],

            // ... remaining not shown ...
        ]
    ]
];
```

## From Scratch

Alternatively, you can also create an entire grammar by inheriting from the `Grammar` and `Identifiers` interfaces.
You must then implement a `compile()` method, which handles all the available methods provided by the Http Query Builder.
The following example show how you could get started.

```php
<?php

namespace Acme\Http\Query\Grammars;

use Aedart\Contracts\Http\Clients\Requests\Query\Builder;
use Aedart\Contracts\Http\Clients\Requests\Query\Identifiers;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;

class MyCustomGrammar implements Grammar,
    Identifiers
{
    public function compile(Builder $builder): string
    {
        $parts = $builder->toArray();
        if (empty($parts)) {
            return '';
        }

        $selects = $parts[self::SELECTS];

        // ... remaining not shown...
    }
}
```
