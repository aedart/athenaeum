---
description: Alpha-Dash-Dot validation rule
---

# Alpha-Dash-Dot

Ensures the field is an alpha-numeric string, allowing dashes, underscores and dots (`.`).
This rule is an extended version of Laravel's [`alpha_dash`](https://laravel.com/docs/9.x/validation#rule-alpha-dash) rule.

```php
use Aedart\Validation\Rules\AlphaDashDot;

$data = $request->validate([
    'slug' => [ new AlphaDashDot() ],
]);
```
