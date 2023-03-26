# Laravel

The `LaravelTestHelper` is a wrapper for [Orchestral Testbench](https://github.com/orchestral/testbench).
It allows you to test laravel components using various testing-frameworks, like [Codeception](https://codeception.com/).

## Prerequisite

To use this component, you must install [Orchestral Testbench](https://github.com/orchestral/testbench):

```shell
composer require --dev "orchestra/testbench=~3.0"
```

## How to Use

In the below stated example, a codeception's unit test (extends PHP Unit) is being used.

```php
use Codeception\TestCase\Test;
use Aedart\Testing\Laravel\LaravelTestHelper;

class MyUnitTest extends Test
{
    use LaravelTestHelper;

    protected function _before(){
        // Start the Laravel application
        $this->startApplication();
    }

    protected function _after(){
        // Stop the Laravel application
        $this->stopApplication();
    }
    
    /**
     * @test
     */
    public function readSomethingFromConfig(){
        // Calling config, using Laravel defined helper method
        $defaultDbDriver = config('database.default');

        $this->assertSame('mysql', $defaultDbDriver);
    }

    /**
     * @test
     */
    public function readSomethingElseFromConfig(){
        // Get the application instance
        $app = $this->getApplication();
        
        $queueDriver = $app['config']['queue.default'];
        
        $this->assertSame('sync', $queueDriver);
    }
    
    // ... Remaining not shown ... //
}
```

## Onward

For more information, please review [Orchestral's documentation](https://github.com/orchestral/testbench) and review the source code of `LaravelTestHelper`.
