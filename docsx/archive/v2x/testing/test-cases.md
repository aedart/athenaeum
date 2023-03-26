# Test Cases

Base abstraction classes for your test-classes can inherit from.

## UnitTestCase

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

