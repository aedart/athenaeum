---
description: About Duration Helper
sidebarDepth: 0
---

# Duration

`Duration` is a helper for dealing with relative time.

[[toc]]

## Example

```php
use Aedart\Utils\Dates\Duration;

$a = new DateTime("2020-09-23 + 42 seconds + 23456 microseconds");
$b = new DateTime("2020-09-23 - 5 hours - 6 minutes");

$duration = Duration::fromDifference($a, $b);

echo $duration->format('%r%Y-%M-%D %H:%I:%S.%F'); //  '-00-00-00 05:06:42.023456'
```

## Creating new instance

You can create a new Duration instance, using a variety of methods.
The following demonstrates some of these:

```php
$duration = Duration(42); // Using seconds
$duration = Duration(new DateInterval('P10Y7DT4H5M34S')); // Using DateInterval
$duration = Duration(new DateTime('@' . (42 * 60))); // Using DateTime
```

### `from()`

The `from()` is a static alias for the Duration classes constructor.

```php
$duration = Duration::from(new DateInterval('P10Y7DT4H5M34S'));
```

### `fromString()`

`fromString()` can be used to create a new Duration instance, using a data and time string.

```php
$duration = Duration::fromString('@' . (42 * 60));
``` 

### `fromSeconds()`

As the name implies, `fromSeconds()` returns a new instance from specified amount of seconds.

```php
$duration = Duration::fromSeconds(3600);
```

### `fromMinutes()`

To create a new Instance from minutes, use `fromMinutes()`.

```php
$duration = Duration::fromMinutes(5);
```

### `fromHoursMinutes()`

To create an instance from hours and _optional_ minutes, use the `fromHoursMinutes()` method.

```php
$duration = Duration::fromHoursMinutes(2, 30); // Minutes are optional
```

Should you have a hours and minutes string, like `02:30` or `1:25`, then use the `fromStringHoursMinutes()` method to create duration instance.

```php
$duration = Duration::fromStringHoursMinutes('02:25');
```

### `fromDifference()`

When you wish to calculate the difference between two dates (_or times_), use the `fromDifference()`.

```php
$then = new DateTime("2020-09-23 - 5 hours - 6 minutes");
$when = new DateTime("2020-09-23 + 42 seconds + 23456 microseconds");

$duration = Duration::fromDifference($when, $then);
```

## Convert

To obtain the duration in minutes, seconds or other format, use can use the following:

```php
$duration = Duration::from(52200);

echo $duration->asSeconds(); // 52200
echo $duration->asMinutes(); // 870
echo $duration->toHoursMinutes(); // '14:30'
echo $duration->toHoursMinutes(true); // '14 hours 30 minutes'
echo $duration->toDaysHoursMinutes(); // '0-14:30'
echo $duration->toDaysHoursMinutes(true); // '0 days 14 hours 30 minutes'
```

## Format

The `format()` can be used to format the duration into a string.
Behind the scene, PHP native [`DateInterval::format`](https://www.php.net/manual/en/dateinterval.format.php) is used.

```php
$duration = Duration::from(new DateInterval('P10Y7DT4H5M34S'));

echo $duration->format('%Y-%M-%D %H:%I:%S'); // '10-00-07 04:05:34'
```

## Onward

Please review the source code for additional methods and examples.




