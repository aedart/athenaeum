---
description: Update environment file keys and values
sidebarDepth: 0
---

# Env File

`EnvFile` is intended to be used when you need to update key-value pairs, in your application's environment file.

[[TOC]]

## Load

The static `load()` method is responsible for loading the application's environment file.
The method accepts an optional path to environment file. If none is specified, then the application's default
environment file path is used.

Once the environment file is loaded, its content is available in the resulting `EnvFile` instance, as a string. 

```php
use Aedart\Support\EnvFile;

$env = EnvFile::load();

// Or, using custom path...
$env = EnvFile::load('/.my-environment-file');
    
// ...remaining not shown...
```

## Append

The `append()` method allows you to append a new key-value pair in the environment file. 

```php
use Illuminate\Support\Str;

$env = EnvFile::load()
    ->append('ACME_SERVICE_API_TOKEN', Str::random(40));
```

## Replace

Use the `replace()` to replace the value of an existing key.
The method will throw an exception, if the key does not exist in the environment file.

```php
$env = EnvFile::load()
    ->replace('QUEUE_CONNECTION', 'redis');
```

## Save

To persist the changes to the environment file, you must use the `save()` method. 

```php
$env = EnvFile::load()
    ->replace('APP_DEBUG', 'true')
    ->save(); // Changes are now saved in the .env file
```

## Refresh

The `refresh()` method reloads the contents of the environment file into memory.

```php
$env = EnvFile::load()
    // ... changes not shown ...
    ->save()
    ->refresh(); // Reload file contents.
```

## Contents 

To obtain the raw contents of the loaded environment, use `contents()`.

```php
$contents = EnvFile::load()
    ->contents();
```