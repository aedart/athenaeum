---
description: Properties Visibility and Accessibility
---

# Properties Visibility

## Protected vs. Private properties

By default, only `protected` properties will be accessible (_overloaded_).
This means that `private` declared properties are inaccessible.

```php
use Aedart\Properties\Overload;

class Person
{
    use Overload;

    protected ?string $name = null; // Accessible

    private ?int $age = null; // Inaccessible

    // ...remaining not shown ...
}
```

## Behaviour override

Should you wish to also expose your private declared properties, then this behaviour can be set per object from an inside scope.

```php
use Aedart\Contracts\Properties\AccessibilityLevels;
use Aedart\Properties\Overload;

class Person
{
    use Overload;

    protected ?string $name = null; // Accessible

    private ?int $age = null;    // Accessible

    public function __construct(){
	    // Change the property accessibility to private
	    $this->setPropertyAccessibilityLevel(AccessibilityLevels::PRIVATE_LEVEL);
    }
}
```
