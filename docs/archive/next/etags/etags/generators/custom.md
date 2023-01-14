---
description: How to create custom Etags Generator
sidebarDepth: 0
---

# Custom Generator

While the `GenericGenerator` is able to create a hash of all kinds of data, it might not be the most suitable for your needs. 
It comes with a cost. The default generator must determine the given data type, and attempt to return a string representation of that data.
This can take some processing power.

Depending on your needs, it could be more prudent to create your own `Generator`.

## How to create

Assuming that your generator also must hash content, using two available hashing algorithms (_for "weak" and "strong" comparison_), then the easiest way to create your own generator is by extending the `BaseGenerator`.

The following example assumes that your application has a `Person` data-type/component, and you wish to create a custom `Generator` that is able to create Etag representation of each `Person` instance.

```php
namespace Acme\ETags\Generators;

use Aedart\ETags\Exceptions\UnableToGenerateETag;
use Aedart\ETags\Generators\BaseGenerator;
use Acme\Data\Person;

class PersonGenerator extends BaseGenerator
{
    public function resolveContent(mixed $content, bool $weak = true): string
    {
        // Fail when content is not a Person...
        if (!($content instanceof Person)) {
            throw new UnableToGenerateETag('Content must be instance of Person');
        }
    
        // Return content for ETag flagged as weak ("weak" comparison)
        if ($weak) {
            return "{$person->name}";
        }
    
        // Return content for ETag NOT flagged as weak ("strong" comparison)
        return "{$person->name}_{$person->email}";
    }
}
```

The `resolveContent()` method is responsible for returning a string value which is then hashed using either of the previously mentioned hashing algorithms.
Note that you are free to completely ignore the `$weak` argument and return whatever string representation of the content, as you see fit.

## Configuration

Inside your `config/etags.php`, add a new profile that uses your custom generator, and specify your desired hashing algorithms.

```php
return [
    // ...previous not shown ...

    'profiles' => [

        // Add your generator as a new "profile"
        'persons' => [
            'driver' => \Acme\ETags\Generators\PersonGenerator::class,
            'options' => [
                'weak_algo' => 'adler32',
                'strong_algo' => 'md5',
            ],
        ],
    ]
];
```

## How to obtain generator

Once your custom generator and configuration are in order, then you can obtain it by its profile name.

```php
// Using factory
$generator = $factory->profile('persons');

// Or via facade
$generator = Generator::profile('persons');
```
