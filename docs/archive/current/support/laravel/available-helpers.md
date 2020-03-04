---
description: Available Laravel Aware-of Helpers
sidebarDepth: 0
---

# Available Helpers

Below is a list of the available Laravel Aware-of Helpers that this package offers.

::: tip Note
Corresponding Aware-of interfaces can be found inside the `Aedart\Contracts\Support\Helpers\*` namespace.
:::

[[TOC]]

## Auth

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Auth\Access\GateTrait`</small> | <small>`Illuminate\Contracts\Auth\Access\Gate`</small> |
| <small>`Aedart\Support\Helpers\Auth\AuthFactoryTrait`</small> | <small>`Illuminate\Contracts\Auth\Factory`</small> |
| <small>`Aedart\Support\Helpers\Auth\AuthTrait`</small> | <small>`Illuminate\Contracts\Auth\Guard`</small> |
| <small>`Aedart\Support\Helpers\Auth\PasswordBrokerFactoryTrait`</small> | <small>`Illuminate\Contracts\Auth\PasswordBrokerFactory`</small> |
| <small>`Aedart\Support\Helpers\Auth\PasswordTrait`</small> | <small>`Illuminate\Contracts\Auth\PasswordBroker`</small> |

## Broadcasting

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Broadcasting\BroadcastFactoryTrait`</small> | <small>`Illuminate\Contracts\Broadcasting\Factory`</small> |
| <small>`Aedart\Support\Helpers\Broadcasting\BroadcastTrait`</small> | <small>`Illuminate\Contracts\Broadcasting\Broadcaster`</small> |

## Bus

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Bus\BusTrait`</small> | <small>`Illuminate\Contracts\Bus\Dispatcher`</small> |
| <small>`Aedart\Support\Helpers\Bus\QueueingBusTrait`</small> | <small>`Illuminate\Contracts\Bus\QueueingDispatcher`</small> |

## Cache

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Cache\CacheFactoryTrait`</small> | <small>`Illuminate\Contracts\Cache\Factory`</small> |
| <small>`Aedart\Support\Helpers\Cache\CacheStoreTrait`</small> | <small>`Illuminate\Contracts\Cache\Store`</small> |
| <small>`Aedart\Support\Helpers\Cache\CacheTrait`</small> | <small>`Illuminate\Contracts\Cache\Repository`</small> |

## Config

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Config\ConfigTrait`</small> | <small>`Illuminate\Contracts\Config\Repository`</small> |

## Console

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Console\ArtisanTrait`</small> | <small>`Illuminate\Contracts\Console\Kernel`</small> |

## Container

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Container\ContainerTrait`</small> | <small>`Illuminate\Contracts\Container\Container`</small> |

## Cookie

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Cookie\CookieTrait`</small> | <small>`Illuminate\Contracts\Cookie\Factory`</small> |
| <small>`Aedart\Support\Helpers\Cookie\QueueingCookieTrait`</small> | <small>`Illuminate\Contracts\Cookie\QueueingFactory`</small> |

## Database

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Database\ConnectionResolverTrait`</small> | <small>`Illuminate\Database\ConnectionResolverInterface`</small> |
| <small>`Aedart\Support\Helpers\Database\DbTrait`</small> | <small>`Illuminate\Database\ConnectionInterface`</small> |
| <small>`Aedart\Support\Helpers\Database\SchemaTrait`</small> | <small>`Illuminate\Database\Schema\Builder`</small> |

## Encryption

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Encryption\CryptTrait`</small> | <small>`Illuminate\Contracts\Encryption\Encrypter`</small> |

## Events

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Events\EventTrait`</small> | <small>`Illuminate\Contracts\Events\Dispatcher`</small> |
| <small>`Aedart\Support\Helpers\Events\DispatcherTrait`</small> | <small>`Illuminate\Contracts\Events\Dispatcher`</small> |

## Filesystem

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Filesystem\CloudStorageTrait`</small> | <small>`Illuminate\Contracts\Filesystem\Cloud`</small> |
| <small>`Aedart\Support\Helpers\Filesystem\FileTrait`</small> | <small>`Illuminate\Filesystem\Filesystem`</small> |
| <small>`Aedart\Support\Helpers\Filesystem\StorageFactoryTrait`</small> | <small>`Illuminate\Contracts\Filesystem\Factory`</small> |
| <small>`Aedart\Support\Helpers\Filesystem\StorageTrait`</small> | <small>`Illuminate\Contracts\Filesystem\Filesystem`</small> |

## Foundation

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Foundation\AppTrait`</small> | <small>`Illuminate\Contracts\Foundation\Application`</small> |

## Hashing

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Hashing\HashTrait`</small> | <small>`Illuminate\Contracts\Hashing\Hasher`</small> |

## Http

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Http\ClientFactoryTrait`</small> | <small>`Illuminate\Http\Client\Factory`</small> |
| <small>`Aedart\Support\Helpers\Http\RequestTrait`</small> | <small>`Illuminate\Http\Request`</small> |

## Logging

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Logging\LogManagerTrait`</small> | <small>`Illuminate\Log\LogManager`</small> |
| <small>`Aedart\Support\Helpers\Logging\LogTrait`</small> | <small>`\Psr\Log\LoggerInterface`</small> |

## Mail

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Mail\MailManagerTrait`</small> | <small>`Illuminate\Contracts\Mail\Factory`</small> |
| <small>`Aedart\Support\Helpers\Mail\MailerTrait`</small> | <small>`Illuminate\Contracts\Mail\Mailer`</small> |
| <small>`Aedart\Support\Helpers\Mail\MailQueueTrait`</small> | <small>`Illuminate\Contracts\Mail\MailQueue`</small> |

## Notifications

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Notifications\NotificationDispatcherTrait`</small> | <small>`Illuminate\Contracts\Notifications\Dispatcher`</small> |
| <small>`Aedart\Support\Helpers\Notifications\NotificationFactoryTrait`</small> | <small>`Illuminate\Contracts\Notifications\Factory`</small> |

## Queue

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Queue\QueueFactoryTrait`</small> | <small>`Illuminate\Contracts\Queue\Factory`</small> |
| <small>`Aedart\Support\Helpers\Queue\QueueMonitorTrait`</small> | <small>`Illuminate\Contracts\Queue\Monitor`</small> |
| <small>`Aedart\Support\Helpers\Queue\QueueTrait`</small> | <small>`Illuminate\Contracts\Queue\Queue`</small> |

## Redis

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Redis\RedisFactoryTrait`</small> | <small>`Illuminate\Contracts\Redis\Factory`</small> |
| <small>`Aedart\Support\Helpers\Redis\RedisTrait`</small> | <small>`Illuminate\Contracts\Redis\Connection`</small> |

## Routing

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Routing\RedirectTrait`</small> | <small>`Illuminate\Routing\Redirector`</small> |
| <small>`Aedart\Support\Helpers\Routing\ResponseFactoryTrait`</small> | <small>`Illuminate\Contracts\Routing\ResponseFactory`</small> |
| <small>`Aedart\Support\Helpers\Routing\RouteRegistrarTrait`</small> | <small>`Illuminate\Contracts\Routing\Registrar`</small> |
| <small>`Aedart\Support\Helpers\Routing\UrlGeneratorTrait`</small> | <small>`Illuminate\Contracts\Routing\UrlGenerator`</small> |

## Session

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Session\SessionManagerTrait`</small> | <small>`Illuminate\Session\SessionManager`</small> |
| <small>`Aedart\Support\Helpers\Session\SessionTrait`</small> | <small>`Illuminate\Contracts\Session\Session`</small> |

## Translation

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Translation\TranslatorTrait`</small> | <small>`Illuminate\Contracts\Translation\Translator`</small> |

## Validation

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\Validation\ValidatorFactoryTrait`</small> | <small>`Illuminate\Contracts\Validation\Factory`</small> |

## View

| Trait        | Defaults to  |
| ------------ | -------------------- |
| <small>`Aedart\Support\Helpers\View\BladeTrait`</small> | <small>`Illuminate\View\Compilers\BladeCompiler`</small> |
| <small>`Aedart\Support\Helpers\View\ViewFactoryTrait`</small> | <small>`Illuminate\Contracts\View\Factory`</small> |
