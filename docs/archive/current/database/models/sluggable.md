---
description: Sluggable Models
---

# Sluggable

If your model uses a [slug](https://en.wikipedia.org/wiki/Clean_URL), then the `Sluggable` interface and `Slugs` concern trait may offer some common utility methods. 

[[TOC]]

## How to use

```php
use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Models\Concerns;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements Sluggable
{
    use Concerns\Slugs;
}
```

## Slug attribute name

By default, the `Slugs` concern will assume that your model's slug attribute is named `"slug"`.
If this is not the case, you may customise this inside your model, by adding the `$slugKey` property.

```php
use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Models\Concerns;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements Sluggable
{
    use Concerns\Slugs;
    
    protected string $slugKey = 'post-url';
}
```

### Alternative

Alternatively, you may specify the slug attribute name by overwriting the `getSlugKeyName()` method.

```php
use Aedart\Contracts\Database\Models\Sluggable;
use Aedart\Database\Models\Concerns;
use Illuminate\Database\Eloquent\Model;

class Post extends Model implements Sluggable
{
    use Concerns\Slugs;
    
    public function getSlugKeyName(): string
    {
        return 'post-url';
    }
}
```

## Find by slug

The `findBySlug()` allows you to find a record that matches given slug. The method will return the first matching record or `null`, if none was found.

```php
$post = Post::findBySlug('january-hits');
```

## Find by slug or fail

Use `findBySlugOrFail()` method to ensure that a record exists or fail by throwing a `ModelNotFoundException`¹ exception. 

```php
$post = Post::findBySlugOrFail('sprint-soundtracks');
```

¹: _`\Illuminate\Database\Eloquent\ModelNotFoundException`_

::: warning Caution
If your model does not guarantee unique slugs, and multiple records are found by the `findBySlugOrFail()` method, then an `\Illuminate\Database\MultipleRecordsFoundException` is thrown.
:::

## Find many by slugs

To find multiple records by their slugs, you can use the `findManyBySlugs()` method.
The method returns an Eloquent `Collection` with models matching the given slugs.

```php
$posts = Post::findManyBySlugs([
    'sprint-soundtracks',
    'january-hits',
    'december-greatest-hits'
]);
```

## Find or create by slug

The `findOrCreateBySlug()` method attempts to find a record matching given slug. If none can be found, it will create a new record with provided attributes and return the model instance.

```php
$post = Post::findOrCreateBySlug('april-morning-tunes', [
    'author' => 'Christina Stein',
    'content' => 'Not nirvana or shangri-la, experience the heaven.'
]);
```

## Query Scopes

The following local [query scope methods](https://laravel.com/docs/11.x/eloquent#local-scopes) are offered:

### `whereSlug`

Matches against given slug.

```php
$post = Post::query()
            ->whereSlug('summer-hits')
            ->first();
```

### `whereSlugIn`

Matches against a list of slugs.

```php
$posts = Post::query()
            ->whereSlugIn([ 'autumn-hits', 'evening-soundtrack' ])
            ->get();
```

## Soft-deleted vs. Finding by slugs

If your model supports [soft-deleting](https://laravel.com/docs/11.x/eloquent#soft-deleting), and you attempt to find a record by a slug that has been soft deleted, then none of the _"find by slug"_ methods are going to return a match.
To query models that have been soft deleted, you must make use of Eloquent's `withTrashed()` method.

```php
$post = Post::withTrashed()
            ->whereSlug('my-deleted-hit')
            ->first();
```

## Onward

For additional information, please review the source code of the `\Aedart\Database\Models\Concerns\Slugs` trait.
