---
description: Where Condition or Filter
sidebarDepth: 0
---

# Where

The `where()` method allows you specify condition clauses.
It accepts a field, an operator and a value.
However, just like the [select](./select) method, the API you are working with may not support operators at all.
If so, then you might have to settle using `where()` as a regular key-value construct.

[[TOC]]

## Arguments

`where()` accepts the following arguments:

- `$field`: `string|array` name of field or key-value pair, where key = field name, value = mixed.
- `$operator`: `mixed` operator or value
- `$value`: `mixed` (_optional_) value. If omitted, then `$operator` acts as value.

```php
$response = $client
        ->where('name', 'john')
        ->get('/users');
```

:::: tabs
 
::: tab default
```http
/users?name=john
```
:::

::: tab json api
```http
/users?filter[name]=john
```
:::
 
::: tab odata
```http
/users?$filter=name eq 'john'
```
:::

::::

## Operator

When passing an operator to the `where()` method, each grammar will attempt to add it to the final query string.
There is no limitation of the types of operators you can use, provided the operator is stated as string.
Consider the following example. 

```php
$response = $client
        ->where('year', 'gt', 2020)
        ->get('/users');
```

:::: tabs
 
::: tab default
```http
/users?year[gt]=2020
```
:::

::: tab json api
```http
/users?filter[year][gt]=2020
```
:::
 
::: tab odata
```http
/users?$filter=year gt 2020
```
:::

::::

## Multiple Conditions

You may add as many conditions as you require.
The following illustrates multiple conditions on the same field.

```php
$response = $client
        ->where('year', 'gt', 2020)
        ->where('year', 'lt', 2051)
        ->get('/users');
```

:::: tabs
 
::: tab default
```http
/users?year[gt]=2020&year[lt]=2051
```
:::

::: tab json api
```http
/users?filter[year][gt]=2020&filter[year][lt]=2051
```
:::
 
::: tab odata
```http
/users?$filter=year gt 2020 and year lt 2051
```
:::

::::

### Via Array

If you pass an array as the first argument, then the query builder will interpret it as a list of conditions.
Each key acts as the name of the field (_or filter name_), whereas the value acts as operator / value.

```php
$response = $client
        ->where([
            'year' => [
                'gt' => 2021,
                'lt' => 2031
            ],
            'name' => 'john'
        ])
        ->get('/users');
```

:::: tabs
 
::: tab default
```http
/users?year[gt]=2021&year[lt]=2031&name=john
```
:::

::: tab json api
```http
/users?filter[year][gt]=2021&filter[year][lt]=2031&filter[name]=john
```
:::
 
::: tab odata
```http
/users?$filter=year gt 2021 and year lt 2031 and name eq 'john'
```
:::

::::

## Array Values

When dealing with array values, you should be aware of how your chosen grammar produces it's final query string.
Consider a situation the API you are working allows you to perform "where users in list" filtering.
You might construct your condition in the following way.

```php
$response = $client
        ->where('users', 'in', [1, 2, 3, 4])
        ->get('/users');
``` 

The above shown example will produce the following query string.
_Depending on your needs, this outcome might not be favourable for you._

:::: tabs
 
::: tab default
```http
/users?users[in][0]=1&users[in][1]=2&users[in][2]=3&users[in][3]=4
```
:::

::: tab json api
```http
/users?filter[users][in][0]=1&filter[users][in][1]=2&filter[users][in][2]=3&filter[users][in][3]=4
```
:::
 
::: tab odata
```http
/users?$filter=users in (1,2,3,4)
```
:::

::::

Alternatively, you could convert array values in to a comma-separated list.
If so, then you could create your condition in the following way:

```php
$response = $client
        ->where('users', 'in', implode(',', [1, 2, 3, 4]))
        ->get('/users');
``` 

:::: tabs
 
::: tab default
```http
/users?users[in]=1,2,3,4
```
:::

::: tab json api
```http
/users?filter[users][in]=1,2,3,4
```
:::
 
::: tab odata

**Caution**: _The above shown example will not create a valid OData "where users in ..." query.
Consider using a regular array as value or make use of the `whereRaw()` method instead._ 

```http
/users?$filter=users in `1,2,3,4`
```
:::

::::

## Where Raw

The `whereRaw()` method can be used for stating conditions as raw expressions.
Alternatively, you may also use the [raw](./raw) method instead.

Two arguments are supported by the `whereRaw()` method:

- `$expression`: `string` the raw expression
- `$bindings`: `array` (_optional_) binding values

```php
$response = $client
        ->whereRaw('filter=user eq :amount', [ 'amount' => 10 ])
        ->get('/users');
``` 

:::: tabs
 
::: tab default
```http
/users?filter=user eq 10
```
:::

::: tab json api

**Caution**: _Resulting query string is not a valid Json API filter!_

```http
/users?filter=user eq 10
```
:::
 
::: tab odata

**Caution**: _Resulting query string is not a valid OData filter!_ 

```http
/users?$filter=filter=user eq 10
```
:::

::::

## Or Where

`orWhere()` and `orWhereRaw()` can be used to add "or" conjunctions in your http query string.
However, apart from [OData](https://www.odata.org/getting-started/basic-tutorial/#queryData), these are **NOT considered conventional**.
Chances are pretty good that these are NOT supported by API you are working with, if "or" conjunctions are supported at all.

```php
$response = $client
        ->where('name', 'john')
        ->orWhere('gender', 'male')
        ->get('/users');
``` 

:::: tabs
 
::: tab default

**Caution**: _Not conventional!_

The ampersand + pipe symbols (_`&|`_) are used as a prefix, for each field/filter that acts as an "or" conjunction.
This symbol can be changed in the grammar's configuration, in `config/http-clients.php`.

```http
/users?name=john&|gender=male
```
:::

::: tab json api

**Caution**: _Not conventional!_

The pipe symbol (_`|`_) is used as a prefix, for each field/filter that acts as an "or" conjunction.
This symbol can be changed in the grammar's configuration, in `config/http-clients.php`.

```http
/users?filter[name]=john&filter[|gender]=male
```
:::
 
::: tab odata

```http
/users?$filter=name eq 'john' or gender eq 'male'
```
:::

::::

If your target API does support "or" conjunctions, yet these grammars fail to deliver the desired syntax for such, please consider [creating a custom grammar](./custom_grammar.md).
