---
description: About ETag Generator
sidebarDepth: 0
---

# Default Generator

Unless otherwise specified in your `config/etags.php`, the `GenericGenerator` is the default used etag `Generator`.
Its main purpose is to hash arbitrary content, and create `Etag` instances with the hash value.

Depending on your configuration, two different hashing algorithms are used:

* `weak_algo`: used for when creating etags flagged as "weak" (_e.g. for weak comparison_)
* `strong_algo`: used for when creating etags that are NOT flagged as "weak" (_e.g. for strong comparison_) 

```php
return [
    // ...previous not shown ...

    'profiles' => [

        'default' => [
            'driver' => \Aedart\ETags\Generators\GenericGenerator::class,
            'options' => [
                'weak_algo' => 'crc32',
                'strong_algo' => 'sha1',
            ],
        ],
    ]
];
```

Feel free to specify whatever hashing algorithms your prefer, in the configuration.
Furthermore, you are encouraged to review the source code of `\Aedart\ETags\Generators\GenericGenerator` to gain a better understanding of the generator works.