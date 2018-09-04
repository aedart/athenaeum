---
sidebarDepth: 3
---

# Testing

Various testing utilities that can be found in the `Aedart\Testing` namespace. 

## Prerequisite

Most testing utilities require [Codeception](https://codeception.com/).
Please ensure that you have installed Codeception as a dependency or [dev-dependency](https://getcomposer.org/doc/04-schema.md#require-dev), in your [composer.json](https://getcomposer.org).

## Test Cases

Base abstraction classes that your test-classes can inherit from.

### UnitTestCase

A basic unit test-case that setup [Faker](https://github.com/fzaninotto/Faker), before each test and closes [Mockery](https://github.com/mockery/mockery) after each test.

```php
use \Aedart\Testing\TestCases\UnitTestCase;

class MyTest extends UnitTestCase
{
    /**
     * @test
     */
    public function isFakerAvailable()
    {
        $value = $this->faker->address;

        $this->assertNotEmpty($value);
    }
}
```
