---
description: Date Format validation rule
---

# Date Format

Adaptation of Laravel's [`date_format`](https://laravel.com/docs/12.x/validation#rule-date-format) rule.
The difference is that, this rule handles an edge case that concerns UTC timezone offset.

If allowed date format contains the [`p` token (_timezone offset_)](https://www.php.net/manual/en/datetime.format.php),
and the date in question contains +00:00 or "Z" (_UTC_) as timezone offset, then this rule will use a slightly different comparison that ensures desired outcome. 

For instance, if you expect a date format like `'Y-m-d\TH:i:sp'`, then the following equivalent dates will pass validation.
* `2023-01-01T11:25:00+00:00`
* `2023-01-01T11:25:00Z`

```php
use Aedart\Validation\Rules\DateFormat;

$data = $request->validate([
    'performed_at' => [ new DateFormat('Y-m-d\TH:i:sp') ],
]);
```
