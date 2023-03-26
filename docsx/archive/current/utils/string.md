---
description: About the String Utility
sidebarDepth: 0
---

# String

Extended version of Laravel's [`Str` component](https://laravel.com/docs/10.x/helpers#strings-method-list).

[[TOC]]

## `slugToWords()`

Method converts a slug back to words.

```php
use Aedart\Utils\Str;

echo (string) Str::slugToWords('my-slug'); // My Slug
```
