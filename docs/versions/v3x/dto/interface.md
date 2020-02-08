# Create Interface

Start off by creating an interface for your DTO.
Below is an example for a simple Person interface

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
