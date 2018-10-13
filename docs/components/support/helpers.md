---
sidebarDepth: 3
---

# Aware Of Helpers

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
| `Aedart\Support\Helpers\Auth\Access\GateTrait` | `Illuminate\Contracts\Auth\Access\Gate` |
| `Aedart\Support\Helpers\Auth\AuthFactoryTrait` | `Illuminate\Contracts\Auth\Factory` |
| `Aedart\Support\Helpers\Auth\AuthTrait` | `Illuminate\Contracts\Auth\Guard` |
| `Aedart\Support\Helpers\Auth\PasswordBrokerFactoryTrait` | `Illuminate\Contracts\Auth\PasswordBrokerFactory` |
| `Aedart\Support\Helpers\Auth\PasswordTrait` | `Illuminate\Contracts\Auth\PasswordBroker` |

### Broadcasting

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `Aedart\Support\Helpers\Broadcasting\BroadcastFactoryTrait` | `Illuminate\Contracts\Broadcasting\Factory` |
| `Aedart\Support\Helpers\Broadcasting\BroadcastTrait` | `Illuminate\Contracts\Broadcasting\Broadcaster` |

### Bus

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `Aedart\Support\Helpers\Bus\BusTrait` | `Illuminate\Contracts\Bus\Dispatcher` |
| `Aedart\Support\Helpers\Bus\QueueingBusTrait` | `Illuminate\Contracts\Bus\QueueingDispatcher` |

### Cache

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `Aedart\Support\Helpers\Cache\CacheFactoryTrait` | `Illuminate\Contracts\Cache\Factory` |
| `Aedart\Support\Helpers\Cache\CacheStoreTrait` | `Illuminate\Contracts\Cache\Store` |
| `Aedart\Support\Helpers\Cache\CacheTrait` | `Illuminate\Contracts\Cache\Repository` |

### Config

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `Aedart\Support\Helpers\Config\ConfigTrait` | `Illuminate\Contracts\Config\Repository` |

### Console

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `Aedart\Support\Helpers\Console\ArtisanTrait` | `\Illuminate\Contracts\Console\Kernel` |

### Container

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Container\ContainerTrait` | `\Illuminate\Contracts\Container\Container` |

### Cookie

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Cookie\CookieTrait` | `\Illuminate\Contracts\Cookie\Factory` |
| `\Aedart\Support\Helpers\Cookie\QueueingCookieTrait` | `\Illuminate\Contracts\Cookie\QueueingFactory` |

### Database

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Database\ConnectionResolverTrait` | `\Illuminate\Database\ConnectionResolverInterface` |
| `\Aedart\Support\Helpers\Database\DbTrait` | `\Illuminate\Database\ConnectionInterface` |
| `\Aedart\Support\Helpers\Database\SchemaTrait` | `\Illuminate\Database\Schema\Builder` |

### Encryption

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Encryption\CryptTrait` | `\Illuminate\Contracts\Encryption\Encrypter` |

### Events

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Events\EventTrait` | `\Illuminate\Contracts\Events\Dispatcher` |

### Filesystem

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Filesystem\CloudStorageTrait` | `\Illuminate\Contracts\Filesystem\Cloud` |
| `\Aedart\Support\Helpers\Filesystem\FileTrait` | `\Illuminate\Filesystem\Filesystem` |
| `\Aedart\Support\Helpers\Filesystem\StorageFactoryTrait` | `\Illuminate\Contracts\Filesystem\Factory` |
| `\Aedart\Support\Helpers\Filesystem\StorageTrait` | `\Illuminate\Contracts\Filesystem\Filesystem` |

### Foundation

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Foundation\AppTrait` | `\Illuminate\Contracts\Foundation\Application` |

### Hashing

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Hashing\HashTrait` | `\Illuminate\Contracts\Hashing\Hasher` |

### Http

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Http\RequestTrait` | `\Illuminate\Http\Request` |

### Logging

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Logging\LogManagerTrait` | `\Illuminate\Log\LogManager` |
| `\Aedart\Support\Helpers\Logging\LogTrait` | `\Psr\Log\LoggerInterface` |

### Mail

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Mail\MailerTrait` | `\Illuminate\Contracts\Mail\Mailer` |
| `\Aedart\Support\Helpers\Mail\MailQueueTrait` | `\Illuminate\Contracts\Mail\MailQueue` |

### Notifications

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Notifications\NotificationDispatcherTrait` | `\Illuminate\Contracts\Notifications\Dispatcher` |
| `\Aedart\Support\Helpers\Notifications\NotificationFactoryTrait` | `\Illuminate\Contracts\Notifications\Factory` |

### Queue

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Queue\QueueFactoryTrait` | `\Illuminate\Contracts\Queue\Factory` |
| `\Aedart\Support\Helpers\Queue\QueueMonitorTrait` | `\Illuminate\Contracts\Queue\Monitor` |
| `\Aedart\Support\Helpers\Queue\QueueTrait` | `\Illuminate\Contracts\Queue\Queue` |

### Redis

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Redis\RedisFactoryTrait` | `\Illuminate\Contracts\Redis\Factory` |
| `\Aedart\Support\Helpers\Redis\RedisTrait` | `\Illuminate\Contracts\Redis\Connection` |

### Routing

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Routing\RedirectTrait` | `\Illuminate\Routing\Redirector` |
| `\Aedart\Support\Helpers\Routing\ResponseFactoryTrait` | `\Illuminate\Contracts\Routing\ResponseFactory` |
| `\Aedart\Support\Helpers\Routing\RouteRegistrarTrait` | `\Illuminate\Contracts\Routing\Registrar` |
| `\Aedart\Support\Helpers\Routing\UrlGeneratorTrait` | `\Illuminate\Contracts\Routing\UrlGenerator` |

### Session

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Session\SessionManagerTrait` | `\Illuminate\Session\SessionManager` |
| `\Aedart\Support\Helpers\Session\SessionTrait` | `\Illuminate\Contracts\Session\Session` |

### Translation

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Translation\TranslatorTrait` | `\Illuminate\Contracts\Translation\Translator` |

### Validation

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\Validation\ValidatorFactoryTrait` | `\Illuminate\Contracts\Validation\Factory` |

### View

| Trait        | Defaults to binding  |
| ------------ | -------------------- |
| `\Aedart\Support\Helpers\View\BladeTrait` | `\Illuminate\View\Compilers\BladeCompiler` |
| `\Aedart\Support\Helpers\View\ViewFactoryTrait` | `\Illuminate\Contracts\View\Factory` |
