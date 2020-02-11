---
description: Create your Dto interface
---

# Create Interface

Strictly speaking, you do not have to create an interface for each Dto.
However, if you are working on a large and complex system, then it might be a good idea. 
It will help you to keep a clean design throughout your system's architecture.

Below you will see a simplified interface for a `Person` Dto.
It might not conform to your needs, but it exemplifies how Dto interfaces might look like.

```php
namespace Acme;

interface Person
{
    public function setName(?string $name);
    
    public function getName() : ?string;
    
    public function setAge(?int $age);

    public function getAge() : ?int;
}
```
