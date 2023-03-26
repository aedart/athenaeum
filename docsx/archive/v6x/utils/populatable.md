---
description: About the Populatable Contract
sidebarDepth: 0
---

# Populatable

Should you require a uniform way to populate (hydrate) your objects, e.g. a model or a [dto](https://en.wikipedia.org/wiki/Data_transfer_object), then the `Populatable` interface is a good way to go.
The `populate()` method allows you to hydrate your object using an array. 

```php
use Aedart\Contracts\Utils\Populatable;

class Box implements Populatable
{
    public function populate(array $data = []) : static
    {
        foreach($data as $name => $value){
            // Populate your object... not shown here
        }
        
        return $this;
    }
}
```

## Verify Required Properties

A quick way to ensure that your objects are populated with the correct properties, is by using the `verifyRequired()` method, via the `PopulateHelper`.
It will automatically throw an `\Exception`, in case that a required property is missing.

State the name of the required properties, as the 2nd argument for the `verifyRequired()` method.

```php
use Aedart\Contracts\Utils\Populatable;
use Aedart\Utils\Helpers\PopulateHelper;

class Box implements Populatable
{
    public function populate(array $data = []) : static
    {
        // Fail if "width" and "height" properties are missing
        PopulateHelper::verifyRequired($data, [
            'width',
            'height'
        ]);
        
        // ...Do something with data...
        
        return $this;
    }
}
```

::: warning
`verifyRequired()` is not intended to be a saturated validation method for input.
Please consider using a [Validator](https://laravel.com/docs/9.x/validation#validating-arrays), if you plan to populate objects with data received from a request or other untrusted source.
:::
