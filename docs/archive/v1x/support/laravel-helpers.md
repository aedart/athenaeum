---
sidebarDepth: 3
---

# Laravel Aware Of Helpers

[Getters and Setters](https://en.wikipedia.org/wiki/Mutator_method) helpers for some of [Laravel's](http://laravel.com/) core packages. 

These components allow you to manually set and retrieve a Laravel component, e.g. a configuration `Repository`.
Additionally, when no component instance has been specified, it will automatically default to whatever Laravel has bound in the [IoC](https://laravel.com/docs/5.7/container).

You can think of these helpers as alternatives, or supplements to Laravel's native [Facades](http://laravel.com/docs/5.7/facades).

## Usage

Imagine that you have a component that depends on Laravel's configuration `Repository`.
To ensure that your component is able to gain access to it, use the `ConfigTrait`.

```php
use Aedart\Support\Helpers\Config\ConfigTrait;

class Box
{
    use ConfigTrait;
    
    // ... remaining not shown ... //
}
```

When you use your component, you will automatically have the configuration `Repository` available, when your are working inside a typical Laravel Application.

```php
$box = new Box();

$config = $box->getConfig();
```

You can also specify a custom `Repository`, should you wish it.

```php
$box->setConfig($myCustomRepository);
```

## Enforce Via Interface

For each available aware-of helper, there is a complementary interface, so that you can enforce your dependencies.

```php
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;

class Box implements ConfigAware 
{
    use ConfigTrait;
    
    // ... remaining not shown ... //
}
```

## Custom Default

You can also easily overwrite the default instance provided, by overwriting the `getDefault[Dependency]` method, which exists inside each aware-of trait.

```php
<?php
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

## Outside Laravel Usage

If you wish to use these helpers outside a typical Laravel Application, then you must ensure that the required services have been registered in the [IoC](https://laravel.com/docs/5.7/container).

## Pros and Cons

If you are a regular Laravel user, then you most likely have your own desired way to obtain dependencies.
Most likely, you either resolve these via the Service Container or rely on [Facades](http://laravel.com/docs/5.7/facades).
There is absolutely nothing wrong with that and you should continue to do so, if it feels right.

As previously mentioned, these components are alternatives or supplementary - either they make sense for you to use or they do not.
In other words, you have to decide for yourself when and how to use these, if at all.
Should you do, then remember that they do add a bit of additional complexity to your components.

## Available Aware Of Helpers

These are the available aware-of helpers for Laravel components.
The _Defaults to binding_ column illustrates what Service Container binding a given trait defaults to, if no custom has been set or overwritten.
See [Facade Class Reference](https://laravel.com/docs/5.7/facades#facade-class-reference) for additional information.

::: tip Note
Corresponding aware-of interfaces can be found inside the `Aedart\Contracts\Support\Helpers\*` namespace.
:::

### Auth

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Auth\Access\GateTrait`</small> | <small>`Illuminate\Contracts\Auth\Access\Gate`</small> |
| <small>`Aedart\Support\Helpers\Auth\AuthFactoryTrait`</small> | <small>`Illuminate\Contracts\Auth\Factory`</small> |
| <small>`Aedart\Support\Helpers\Auth\AuthTrait`</small> | <small>`Illuminate\Contracts\Auth\Guard`</small> |
| <small>`Aedart\Support\Helpers\Auth\PasswordBrokerFactoryTrait`</small> | <small>`Illuminate\Contracts\Auth\PasswordBrokerFactory`</small> |
| <small>`Aedart\Support\Helpers\Auth\PasswordTrait`</small> | <small>`Illuminate\Contracts\Auth\PasswordBroker`</small> |

### Broadcasting

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Broadcasting\BroadcastFactoryTrait`</small> | <small>`Illuminate\Contracts\Broadcasting\Factory`</small> |
| <small>`Aedart\Support\Helpers\Broadcasting\BroadcastTrait`</small> | <small>`Illuminate\Contracts\Broadcasting\Broadcaster`</small> |

### Bus

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Bus\BusTrait`</small> | <small>`Illuminate\Contracts\Bus\Dispatcher`</small> |
| <small>`Aedart\Support\Helpers\Bus\QueueingBusTrait`</small> | <small>`Illuminate\Contracts\Bus\QueueingDispatcher`</small> |

### Cache

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Cache\CacheFactoryTrait`</small> | <small>`Illuminate\Contracts\Cache\Factory`</small> |
| <small>`Aedart\Support\Helpers\Cache\CacheStoreTrait`</small> | <small>`Illuminate\Contracts\Cache\Store`</small> |
| <small>`Aedart\Support\Helpers\Cache\CacheTrait`</small> | <small>`Illuminate\Contracts\Cache\Repository`</small> |

### Config

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Config\ConfigTrait`</small> | <small>`Illuminate\Contracts\Config\Repository`</small> |

### Console

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Console\ArtisanTrait`</small> | <small>`Illuminate\Contracts\Console\Kernel`</small> |

### Container

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Container\ContainerTrait`</small> | <small>`Illuminate\Contracts\Container\Container`</small> |

### Cookie

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Cookie\CookieTrait`</small> | <small>`Illuminate\Contracts\Cookie\Factory`</small> |
| <small>`Aedart\Support\Helpers\Cookie\QueueingCookieTrait`</small> | <small>`Illuminate\Contracts\Cookie\QueueingFactory`</small> |

### Database

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Database\ConnectionResolverTrait`</small> | <small>`Illuminate\Database\ConnectionResolverInterface`</small> |
| <small>`Aedart\Support\Helpers\Database\DbTrait`</small> | <small>`Illuminate\Database\ConnectionInterface`</small> |
| <small>`Aedart\Support\Helpers\Database\SchemaTrait`</small> | <small>`Illuminate\Database\Schema\Builder`</small> |

### Encryption

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Encryption\CryptTrait`</small> | <small>`Illuminate\Contracts\Encryption\Encrypter`</small> |

### Events

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Events\EventTrait`</small> | <small>`Illuminate\Contracts\Events\Dispatcher`</small> |

### Filesystem

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Filesystem\CloudStorageTrait`</small> | <small>`Illuminate\Contracts\Filesystem\Cloud`</small> |
| <small>`Aedart\Support\Helpers\Filesystem\FileTrait`</small> | <small>`Illuminate\Filesystem\Filesystem`</small> |
| <small>`Aedart\Support\Helpers\Filesystem\StorageFactoryTrait`</small> | <small>`Illuminate\Contracts\Filesystem\Factory`</small> |
| <small>`Aedart\Support\Helpers\Filesystem\StorageTrait`</small> | <small>`Illuminate\Contracts\Filesystem\Filesystem`</small> |

### Foundation

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Foundation\AppTrait`</small> | <small>`Illuminate\Contracts\Foundation\Application`</small> |

### Hashing

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Hashing\HashTrait`</small> | <small>`Illuminate\Contracts\Hashing\Hasher`</small> |

### Http

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Http\RequestTrait`</small> | <small>`Illuminate\Http\Request`</small> |

### Logging

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Logging\LogManagerTrait`</small> | <small>`Illuminate\Log\LogManager`</small> |
| <small>`Aedart\Support\Helpers\Logging\LogTrait`</small> | <small>`\Psr\Log\LoggerInterface`</small> |

### Mail

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Mail\MailerTrait`</small> | <small>`Illuminate\Contracts\Mail\Mailer`</small> |
| <small>`Aedart\Support\Helpers\Mail\MailQueueTrait`</small> | <small>`Illuminate\Contracts\Mail\MailQueue`</small> |

### Notifications

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Notifications\NotificationDispatcherTrait`</small> | <small>`Illuminate\Contracts\Notifications\Dispatcher`</small> |
| <small>`Aedart\Support\Helpers\Notifications\NotificationFactoryTrait`</small> | <small>`Illuminate\Contracts\Notifications\Factory`</small> |

### Queue

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Queue\QueueFactoryTrait`</small> | <small>`Illuminate\Contracts\Queue\Factory`</small> |
| <small>`Aedart\Support\Helpers\Queue\QueueMonitorTrait`</small> | <small>`Illuminate\Contracts\Queue\Monitor`</small> |
| <small>`Aedart\Support\Helpers\Queue\QueueTrait`</small> | <small>`Illuminate\Contracts\Queue\Queue`</small> |

### Redis

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Redis\RedisFactoryTrait`</small> | <small>`Illuminate\Contracts\Redis\Factory`</small> |
| <small>`Aedart\Support\Helpers\Redis\RedisTrait`</small> | <small>`Illuminate\Contracts\Redis\Connection`</small> |

### Routing

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Routing\RedirectTrait`</small> | <small>`Illuminate\Routing\Redirector`</small> |
| <small>`Aedart\Support\Helpers\Routing\ResponseFactoryTrait`</small> | <small>`Illuminate\Contracts\Routing\ResponseFactory`</small> |
| <small>`Aedart\Support\Helpers\Routing\RouteRegistrarTrait`</small> | <small>`Illuminate\Contracts\Routing\Registrar`</small> |
| <small>`Aedart\Support\Helpers\Routing\UrlGeneratorTrait`</small> | <small>`Illuminate\Contracts\Routing\UrlGenerator`</small> |

### Session

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Session\SessionManagerTrait`</small> | <small>`Illuminate\Session\SessionManager`</small> |
| <small>`Aedart\Support\Helpers\Session\SessionTrait`</small> | <small>`Illuminate\Contracts\Session\Session`</small> |

### Translation

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Translation\TranslatorTrait`</small> | <small>`Illuminate\Contracts\Translation\Translator`</small> |

### Validation

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Validation\ValidatorFactoryTrait`</small> | <small>`Illuminate\Contracts\Validation\Factory`</small> |

### View

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\View\BladeTrait`</small> | <small>`Illuminate\View\Compilers\BladeCompiler`</small> |
| <small>`Aedart\Support\Helpers\View\ViewFactoryTrait`</small> | <small>`Illuminate\Contracts\View\Factory`</small> |
