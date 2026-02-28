---
description: Stream transactions
sidebarDepth: 0
---

# Transactions

The `FileStream` component offers a way to safely perform dangerous operations on a file, by means of a [transaction](https://en.wikipedia.org/wiki/Transaction_processing) mechanism.
In this context, "dangerous operations" means any kind of stream manipulation that can fail.

[[TOC]]

## Perform Transaction

The easiest way to perform a transaction on a file stream, is by using the `transaction()` method.
It accepts the following arguments:

* `callable $operation`: Operation callback. A `Stream` instance is given as callback's argument.
* `int $attempts`: (_optional_) Maximum amount of attempts to perform operation. Defaults to `1`.
* `string|null $profile`: (_optional_) Transaction profile driver to use (_see [Customisation](#customisation) for details_).
* `array $options`: (_optional_) Transaction driver specific options (_see [Customisation](#customisation) for details_).

The following shows a simplified example, in which some content is appended to a file.

```php
$stream = FileStream::open('orders.txt', 'r+b');

$result = $stream->transaction(function($stream) {
    // Add or change content in given stream
    $stream
        ->append("\nT-shirt     Large       4.99 EUR")
        ->append("\nT-shirt     Small       4.45 EUR")
        ->append("\nT-shirt     Extra Large 5.15 EUR");
    
    // Return eventual result (optional)
    return (string) $stream;
});
```

## How it works

When the `transaction()` method is invoked, then the following process is performed:

### Begin

1. The target stream is locked using an [exclusive lock](./locking.md#exclusive-lock).
2. Target stream is backed up, if such configured (_see [backup](#backup) for details_).
3. A new copy is created (_processing stream_) of the target stream, using a [temporary stream](./open-close.md#temporary).

### Process

4. The callback is invoked using given the _processing stream_ as argument.

### Commit

5. After the callback has completed, the changes are committed; target stream's content is overwritten with content from the _processing stream_.
6. Backup-file is removed, if such configured (_see [backup](#backup) for details_).
7. Target stream's lock is released and evt. output from callback is returned.

### Rollback

* In case of failure, rollback and retry if more attempt are available. Rollback is performed by resetting the _process stream_ and (re)copying target stream's content into it. Backup file is _NOT_ used for rolling back!
* When no more attempts are available, release the lock and allow exception to bubble upwards

As you can see, this is not a simple process and many things can go wrong during a transaction.
It is therefore highly _RECOMMENDED_ that you enable [backup](#backup), if you use transactions in a production environment.

Furthermore, you _should expect_ that working with this kind of transactions can be memory and I/O intensive.

## Backup

::: warning
Backup of the target stream is _NOT ENABLED_, by the default transaction "profile".
Without any additional configuration or customisation, no backup is made.
:::

Backup can be configured in your `config/streams.php` configuration file, when situated within a regular Laravel application.
However, you can always overwrite the profile's "backup" configuration using the `$options` argument, in the `transaction()` method, regardless of what profile is used. 

```php
$stream = FileStream::open('orders.txt', 'r+b');

// Custom options
$options = [
    'backup' => [

        // When true, a backup of target stream (*.bak file) will be stored
        'enabled' => true,

        // Location of backup files
        'directory' => getcwd() . DIRECTORY_SEPARATOR . 'my_file_backups',

        // When true, backup file is automatically removed after commit.
        'remove_after_commit' => false,
    ],
];

$result = $stream->transaction(function($stream) {
    // ...not shown...
}, 1, null, $options);
```

When the above show example is executed, a backup file will be created within a "my_file_backups" directory.
The backup file's extension will be set to `*.bak` and the filename will include a datetime.

```console
/my_file_backups
    orders.txt_2022_04_03_182045_225174.bak
```

Unless the `remove_after_commit` setting is set to `true`, then the backup file will not be purged after a successful transaction commit.

## Customisation

As previously mentioned, if using stream transactions in a Laravel application, then you can add or change profiles in the `config/streams.php` configuration file.
When you wish to use a specific transaction, state the profile name in the `$profile` argument of the `transaction()` method.

```php
$stream = FileStream::open('orders.txt', 'r+b');

$result = $stream->transaction(function($stream) {
    // ...not shown...
}, 3, 'my-stream-transaction-profile');
```

However, when using this package outside Laravel, then you have similar options to customise the behaviour, as for the [locking mechanism](./locking.md#customise-behaviour).
You are encouraged to extend the `FileStream` component and overwrite the `getDefaultTransactionFactory()` method.

```php
use Aedart\Streams\FileStream;
use Aedart\Contracts\Streams\BufferSizes;
use Aedart\Contracts\Streams\Locks\LockType;
use Aedart\Contracts\Streams\Transactions\Factory;
use Aedart\Streams\Transactions\TransactionFactory;
use Aedart\Streams\Transactions\Drivers\CopyWriteReplaceDriver;

class MyFileStream extends FileStream
{
    public function getDefaultTransactionFactory(): Factory|null
    {
        $profiles = [
            'my-transaction-profile' => [
                'driver' => CopyWriteReplaceDriver::class,
                'options' => [
                    'maxMemory' => 10 * BufferSizes::BUFFER_1MB,

                    'lock' => [
                        'enabled' => true,
                        'profile' => 'default',
                        'type' => LockType::EXCLUSIVE,
                        'timeout' => 0.01,
                    ],

                    'backup' => [
                        'enabled' => true,
                        'directory' => getcwd() . DIRECTORY_SEPARATOR . 'backup',
                        'remove_after_commit' => false,
                    ],
                ]
            ]
        ];

        $default = 'my-transaction-profile';
        
        return new TransactionFactory($profiles, $default);
    }
}
```

For additional information about each of the above shown settings, please review the `config/streams.php` located inside this package.

## Onward

The transaction mechanism can be useful, when you need to perform unsafe or risky stream content manipulation. You _SHOULD_ enable backup of files, if you plan to use this feature in a production environment. 
Additionally, if the default provided stream transaction driver is not to your liking, then you can implement your own version.
Please review the source code of `\Aedart\Streams\Transactions\Drivers\CopyWriteReplaceDriver` for more information.
