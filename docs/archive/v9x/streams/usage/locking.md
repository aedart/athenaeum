---
description: Stream locking
sidebarDepth: 0
---

# Locking

The `FileStream` component offers a simple locking mechanism, which uses PHP's [`flock()`](https://www.php.net/manual/en/function.flock) to acquire and release a lock.
In this section, a few examples are shown on how to acquire a lock and perform operations on a file.

[[TOC]]

## Exclusive Lock

To acquire an exclusive lock (_`LOCK_EX`_) and perform some kind of write operation on the stream, use the `exclusiveLock()` method.

The method accepts the following arguments:

* `callable $operation`: Callback to be invoked after lock was acquired. The stream instance is given as argument to callback.
* `float $timeout`: (_optional_) Timeout of acquiring lock in seconds. Defaults to `0.5` seconds.
* `string|null $profile`: (_optional_) Name of locking profile to use (_See [Customise Behaviour](#customise-behaviour)_).
* `array $options`: (_optional_) Lock driver specific options (_See [Customise Behaviour](#customise-behaviour)_).

Once the callback has been performed, the lock is automatically released.

```php
// Assuming file is empty...
$stream = FileStream::open('persons.txt', 'r+b');

$result = $stream->exclusiveLock(function($stream) {
    // ...Do something with stream...
    $stream->put("\nJohn");
    
    return (string) $stream;
});

echo $result; // John
```

## Shared Lock

If you wish to acquire a shared lock (_`LOCK_SH`_), use the `sharedLock()` method.

Method accepts the same type of arguments as [`exclusiveLock()`](#exclusive-lock).

```php
// Assuming file has "Jim" as content
$stream = FileStream::open('persons.txt', 'r+b');

$result = $stream->sharedLock(function($stream) {    
    return (string) $stream;
});

echo $result; // Jim
```

## Customise Behaviour

If you are using the streams component inside a Laravel application, then you can customise the locking behaviour via the `config/streams.php` configuration.
Here, you may change existing lock profiles or add new ones.

```php
return [

    // ...previous not shown...

    /*
     |--------------------------------------------------------------------------
     | Lock profiles
     |--------------------------------------------------------------------------
    */

    'locks' => [

        // ...default profile not shown here...
        
        'my-lock-profile' => [
            'driver' => \Aedart\Streams\Locks\Drivers\FLockDriver::class,
            'options' => [
                'sleep' => 5_000,
                'fail_on_timeout' => true
            ]
        ]
    ],
    
    // ... remaining not shown...
];
```

Then, when you wish for your stream to acquire a lock using a specific lock profile, specify the profile for the `$profile` argument.

```php
$result = $stream->exclusiveLock(function($stream) {
    // ...not shown...
}, 0.01, 'my-lock-profile');
```

You can also choose to overwrite a given profile's options, when acquiring the lock, via the `$options` argument.

```php
// Custom options for a single operation...
$options = [
    'sleep' => 2_000
];

$result = $stream->exclusiveLock(function($stream) {
    // ...not shown...
}, 0.01, 'my-lock-profile', $options);
```

### Outside Laravel

If you wish to customise the locking behaviour whilst using this package outside a regular Laravel application, then you have a few ways to do so: 

* You can specify custom `$options`, which can configure the "default" profile.
* Set "profiles" manually on the internal `LockFactory`


#### Specify custom options

```php
// Custom options for a single operation...
$options = [
    'sleep' => 12_000,
    'fail_on_timeout' => false
];

$result = $stream->exclusiveLock(function($stream) {
    // ...not shown...
}, 0.01, null, $options);
```

#### Specify custom "profiles"

A list of custom profiles can always be specified on a stream's internal `LockFactory`.

```php
use \Aedart\Streams\Locks\Drivers\FLockDriver;

/** @type \Aedart\Streams\Locks\LockFactory $lockFactory */
$lockFactory = $stream
    ->getLockFactory();
    ->usingProfiles([
        'my-profile' => [
            'driver' => FLockDriver::class,
            'options' => [
                'sleep' => 10_000,
                'fail_on_timeout' => true
            ]
        ]
        
        // ...more profiles...
    ])
    ->defaultProfile('my-profile')
```

Unfortunately, the above shown example is not very practical, if you have to do this for every stream instance.
Therefore, to overcome this issue, you are encouraged to extend the `FileStream` component and overwrite the `getDefaultLockFactory()` method.

```php
use Aedart\Streams\FileStream;
use Aedart\Streams\Locks\LockFactory;
use Aedart\Contracts\Streams\Locks\Factory;

class MyFileStream extends FileStream
{
    public function getDefaultLockFactory(): Factory|null
    {
        $profiles = [
            'my-profile' => [
                'driver' => FLockDriver::class,
                'options' => [
                    'sleep' => 10_000,
                    'fail_on_timeout' => true
                ]
            ]
            
            // ...more profiles...
        ];
    
        $default = 'my-profile';
    
        return new LockFactory($profiles, $default);
    }
}
```

## Custom Lock Drivers

Should the default provided `FLockDriver` not be a good solution for you, then you can always add your own custom driver(s).
The easiest way of doing so, is by extending the `BaseLockDriver` abstraction.

```php
use Aedart\Streams\Locks\Drivers\BaseLockDriver;

class MyLockDriver extends BaseLockDriver
{
    public function acquireLock(Stream $stream, int $type, float $timeout): bool
    {
        // ...not shown...
    }
    
    public function releaseLock(Stream $stream): bool
    {
        // ...not shown...
    }
}
```

Once you have you driver implemented, then you can specify it as a profile's `driver`:

```php
// Where you specify your profiles...
$profiles = [
    'my-profile' => [
        'driver' => MyLockDriver::class,
        // ... remaining not shown ...
    ]
    
    // ...more profiles...
];
```
