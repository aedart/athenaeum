---
description: How to use Test-Case Abstractions
---

# Test Cases

The following test-case abstractions are available. All test-cases inherit from Codeception's `Unit` test-case (_extended version of [PHPUnit Test-Case](https://packagist.org/packages/phpunit/phpunit)_).

[[TOC]]

## Prerequisite

It is recommended that you have some experience working with Codeception.
Please read their [documentation](https://codeception.com/docs/01-Introduction) before continuing here.

## Unit Test-Case

A basic unit test-case that has a [Faker](https://packagist.org/packages/fakerphp/faker) instance setup. 
Furthermore, [Mockery](https://github.com/mockery/mockery) is automatically closed after each test.
This abstraction is mostly suited for testing single components in isolation.

```php
use Aedart\Testing\TestCases\UnitTestCase;

class MyTest extends UnitTestCase
{
    /**
     * @test
     */
    public function isFakerAvailable()
    {
        $value = $this->getFaker()->address();

        $this->assertNotEmpty($value);
    }
}
```

### Faker Locale

To change the [locale](https://github.com/fzaninotto/Faker#localization) that the Faker instance should use, set the `$FakerLocale` property.

```php
class MyTest extends UnitTestCase
{
    protected string|null $FakerLocale = 'da_DK';
    
    // ... remaining not shown ...
}
```

See the source code of `Aedart\Testing\TestCases\Partials\FakerPartial` for additional information.

## Integration Test-Case

The `IntegrationTestCase` abstraction is suitable for more complex testing. It automatically creates a [Service Container](../container) instance before each test and destroys it again after each test.
This allows you to test components that depend on the Service Container.

This test-case inherits from the `UnitTestCase` abstraction, meaning that a Faker instance is available and Mockery is also setup.

```php
use Aedart\Testing\TestCases\IntegrationTestCase;
use Acme\Users\UserModel;
use Acme\Data\DataLink;

class MyTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function canCreateSpecialComponent()
    {
        // E.g. bind instances
        $this->ioc->bind('data-link', function(){
            return new DataLink();
        });

        // E.g. resolve components that depend on other
        // components...
        $userModel = $this->ioc->make(UserModel::class);

        // Or perhaps... 
        $otherUserModel = new UserModel($this->ioc);
        $otherUserModel->name = $this->getFaker()->name();

        // ... remaining not shown ...
    }
}
```

### Service Container As Application

::: danger Warning
By default, the created Service Container instance is automatically registered as "application". This means that it binds itself as the `app` keyword (_Laravel Application_).
This can be useful for testing your components in combination with Laravel's Service Providers or other Laravel core components. But this can also result in very unexpected and undesirable behaviour.
**Please be very careful how use make use of this!**

#### How to disable

To disable this behaviour, set `$registerAsApplication` to `false`.

```php
class MyTest extends IntegrationTestCase
{
    protected bool $registerAsApplication = false;

    // ... remaining not shown ...
}
```

See [`registerAsApplication()`](../container/service-container.md) for additional information.

:::

## Laravel Test-Case

The `LaravelTestCase` starts a new Laravel application before each test and destroys it again, after each test has completed.
It utilises [Orchestra Testbench](https://packagist.org/packages/orchestra/testbench) to achieve this.
It inherits from the `IntegrationTestCase` and therefore also offers the same features and previously shown.

::: tip Note 
The `$registerAsApplication` property is set to `false` in this test-case.
:::

```php
use Aedart\Testing\TestCases\LaravelTestCase;

class MyTest extends LaravelTestCase
{
    /**
     * @test
     */
    public function canAccessLaravelComponents()
    {
        $redis = $this->ioc->make('redis');

        // ... remaining not shown ...
    }
}
```

## Browser Test-Case

`BrowserTestCase` can be used for writing tests to be executed in a browser. [Laravel Dusk](https://laravel.com/docs/10.x/dusk) is used behind the scene.
Please review the Test-Case's source code and Laravel documentation for additional information.

```php
use Aedart\Testing\TestCases\BrowserTestCase;
use Laravel\Dusk\Browser;

class MyBrowserTest extends BrowserTestCase
{
    public function canVisitPage()
    {
        $this->browse(function(Browser $browser) {
            
            $browser
                ->visit('https://www.google.com/')
                ->waitForText("I'm Feeling Lucky")

        });    
    }
}
```

::: tip

In order to run browser tests, you will be required to have the correct `ChromeDriver` binary installed.
You can use the following to install the binary:

```shell
vendor/bin/dusk-updater update
```

:::

## Athenaeum Test-Case

If you are using the [Athenaeum Core Application](../core), then you can use the `AthenaeumTestCase` to help you test your components or application.
It only offers a few handful of the testing capabilities that the Laravel Test-Case does.
However, it might just be enough to get you started.

The test-case ensures that an application instance is created before each test, and destroyed after each test has completed.
Since it also inherits from `IntegrationTestCase`, it too offers the Faker instance and Mockery setup.

```php
use Aedart\Testing\TestCases\AthenaeumTestCase;

class MyTest extends AthenaeumTestCase
{
    /**
     * @test
     */
    public function canExecuteCustomCommand()
    {
        $exitCode = $this
            ->withoutMockingConsoleOutput()
            ->artisan('pirate:talk');

        // ... remaining not shown ...
    }
}
```

For additional information, please review the source code of the `AthenaeumTestCase`.
