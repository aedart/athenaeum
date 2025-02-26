---
description: Instantiatable Models
---

# Instantiatable

Models that inherit from the `Instantiatable` interface, allow creating new instances statically and accept a database connection, via the `make()` method.
The `Instance` concern trait offers a default implementation.

## How to use

```php
use Aedart\Contracts\Database\Models\Instantiatable;
use Aedart\Database\Models\Concerns;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements Instantiatable
{
    use Concerns\Instance;
}

// ... later in your application
$post = Post::make(); // Creates a new instance
```

## Attributes

The `make()` method accepts an array of attributes.

```php
$post = Post::make([
    'author' => 'Christina Stein',
    'content' => 'When one avoids totality and attitude, one is able to hurt harmony.'
]);
```

## Connection

Lastly, you may also specify which connection should be used by the model.

```php
$post = Post::make([], 'my-db-connection');
```
