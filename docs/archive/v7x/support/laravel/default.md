---
description: Overwriting the default of a Laravel Aware-of Helper
---

# Custom Default

To overwrite the default resolved instance, overwrite the `getDefault[Dependency]` method.

```php
use Aedart\Support\Helpers\Config\ConfigTrait;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Config\Repository as Config;

class Box
{
    use ConfigTrait;
    
    public function getDefaultConfig(): ?Repository
    {
        return new Config([
            'width'     => 25,
            'height'    => 25
        ]);
    }
    
    // ... remaining not shown ... //
}
```
