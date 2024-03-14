---
description: Date Condition or Filter
sidebarDepth: 0
---

# Dates

The Http Query builder offers a few methods for adding date-based conditions, in you query string.

[[TOC]]

## Formats

Before showing examples of each supported method, you should know that you can change the date and time formats, for each grammar.
This can be done in your `config/http-clients.php` configuration file, under each grammar profile.
The formats are parsed using PHP's [`DateTime::format()` method](https://www.php.net/manual/en/datetime.format.php).

```php
<?php

return [

    // ... previous not shown ...

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Requests\Query\Grammars\DefaultGrammar::class,
            'options' => [

                /**
                 * Date formats
                 */
                'datetime_format' => \DateTimeInterface::ISO8601,
                'date_format' => 'Y-m-d',
                'year_format' => 'Y',
                'month_format' => 'm',
                'day_format' => 'd',
                'time_format' => 'H:i:s',
            ]
        ],
    ]
];
```

## Arguments

Each of the available date-based condition methods accept the following arguments:

- `$field`: `string` field/filter name
- `$operator`: `string|DateTimeInterface` string operator or value
- `$value`: `string|DateTimeInterface` (_optional_) date, either as a string or instance that inherits from `DateTimeInterface`. If omitted, the `$operator` acts as the value.

If no value is given, then the current datetime (`now`) is used as the default value.

## Where Datetime

The `whereDatetime()` adds a condition using a full "date & time" format.

```php
$response = $client
        ->whereDatetime('created', '2020-04-05')
        ->get('/users');
```


 
::: details default
```http
/users?created=2020-04-05T00:00:00+0000
```
:::

::: details json api
```http
/users?filter[created]=2020-04-05T00:00:00+0000
```
:::
 
::: details odata
```http
/users?$filter=created eq 2020-04-05T00:00:00+0000
```
:::

## Where Date

`whereDate()` can be used to add a condition where "year, month and day" formats are expected.

```php
$response = $client
        ->whereDate('created', 'gt', new DateTime('now'))
        ->get('/users');
```


 
::: details default
```http
/users?created[gt]=2020-04-05
```
:::

::: details json api
```http
/users?filter[created][gt]=2020-04-05
```
:::
 
::: details odata
```http
/users?$filter=created gt 2020-04-05
```
:::

## Where Year

`whereYear()` adds a date condition, where "year" is used as format. 

```php
$response = $client
        ->whereYear('created', 'lt', new DateTime('now'))
        ->get('/users');
```


 
::: details default
```http
/users?created[lt]=2020
```
:::

::: details json api
```http
/users?filter[created][lt]=2020
```
:::
 
::: details odata
```http
/users?$filter=created lt 2020
```
:::

## Where Month

`whereMonth()` adds a condition, where "month" is used as format.

```php
$response = $client
        ->whereMonth('created', '2020-07-15')
        ->get('/users');
```


 
::: details default
```http
/users?created=07
```
:::

::: details json api
```http
/users?filter[created]=07
```
:::
 
::: details odata
```http
/users?$filter=created eq 07
```
:::

## Where Day

To add a condition where "day" format is expected, use the `whereDay()` method.

```php
$response = $client
        ->whereDay('created', 'gt', '2020-07-15')
        ->get('/users');
```


 
::: details default
```http
/users?created[gt]=15
```
:::

::: details json api
```http
/users?filter[created][gt]=15
```
:::
 
::: details odata
```http
/users?$filter=created gt 15
```
:::

## Where Time

Conditions based on "time" format, can be added via `whereTime()`. 

```php
$response = $client
        ->whereTime('created', 'lt', new DateTime('now'))
        ->get('/users');
```


 
::: details default
```http
/users?created[lt]=16:58:00
```
:::

::: details json api
```http
/users?filter[created][lt]=16:58:00
```
:::
 
::: details odata
```http
/users?$filter=created lt 16:58:00
```
:::

## Or Methods

You may also use the `orWhereDatetime()`, `orWhereDate()`, `orWhereYear()`...etc methods to add "or" conjunctions.
But, apart from [OData](https://www.odata.org/getting-started/basic-tutorial/#queryData), these are **NOT considered conventional**.
For additional information about "or" conjunctions, please read the [`orWhere()` documentation](./where.md#or-where).

