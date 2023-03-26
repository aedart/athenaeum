# Implement DTO

To implement your DTO, extend the `Dto` abstraction.
Also, you should ensure that it implements your previously defined interface.
 
```php

use Acme\Person as PersonInterface;
use Aedart\Dto;

class Person extends Dto implements PersonInterface
{
    protected $name = '';
    
    protected $age = 0;
 
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
