---
description: How to Register Event Listeners
---

# Events

The [Event Dispatcher](https://laravel.com/docs/11.x/events) that comes with this package, offers you an application-wide observer pattern implementation.
Please read Laravel's [documentation](https://laravel.com/docs/11.x/events), to gain some basic understanding of it's capabilities.

## Register Event Listeners

By default, when you need to register [event listeners](https://laravel.com/docs/11.x/events#defining-listeners) or [subscribers](https://laravel.com/docs/11.x/events#event-subscribers), you need to state them within your `/config/events.php` configuration file.
See the [Athenaeum Package](../../events) for details and examples.

### Via Service Provider

If the default approach does not work for you, then you can always create a custom Service Provider that registers your desired listeners.

```php
<?php

namespace Acme\Console\Providers;

use Acme\Users\Events\UserHasRegistered;
use Acme\Users\Listeners\SendWelcomeMessage;
use Aedart\Support\Helpers\Events\DispatcherTrait;
use Illuminate\Support\ServiceProvider;

class MyEventServiceProvider extends ServiceProvider
{
    use DispatcherTrait;

    public function boot()
    {
        $this->getDispatcher()->listen(
            UserHasRegistered::class,
            SendWelcomeMessage::class
        );
    }
}
```

## Limitations

This package does not come with Laravel's [Queues](https://laravel.com/docs/11.x/queues).
As a consequence of this, [queued event listeners](https://laravel.com/docs/11.x/events#queued-event-listeners) are not available by default.
You could try to include the [Queue package](https://packagist.org/packages/illuminate/queue) by yourself.
Read the [Service Providers chapter](providers) for additional information. 
