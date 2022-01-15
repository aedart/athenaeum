---
description: How to create a Dto
---

# Implement DTO

In order to implement the DTO, extend the `Dto` abstraction and inherit from your DTO interface (_if you choose to use interfaces for your DTOs_).
 
```php

use Acme\Person as PersonInterface;
use Aedart\Dto\Dto;

class Person extends Dto implements PersonInterface
{
    protected ?string $name = '';
    
    protected ?int $age = 0;
 
    public function setName(?string $name)
    {
        $this->name = $name;
    }

    public function getName() : ?string
    {
        return $this->name;
    }

    public function setAge(?int $age)
    {
        $this->age = $age;
    }

    public function getAge() : ?int
    {
        return $this->age;
    }
}
```

Now you are ready to use the DTO.
The upcoming sections will highlight some of the usage scenarios. 
