---
description: How to enforce Components with Aware-of Interfaces
---

# Enforce Via Interface

Should your component's design require one or more specific Laravel components, then you can choose to enforce your component's design by making use of the complementary Aware-of Helper interfaces.

```php
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;

class Box implements ConfigAware 
{
    use ConfigTrait;
    
    // ... remaining not shown ... //
}
```
