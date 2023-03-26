---
description: Limit Results
sidebarDepth: 0
---

# Pagination

Two approaches are offered to set pagination. A cursor-based and a page-based approach. 

## Limit & Offset

`limit()` and `offset()` allow you to limit your results, via a traditional cursor-based pagination.

```php
$response = $client
        ->limit(10)
        ->offset(5)
        ->get('/users');
```


 
::: details default
```http
/users?limit=10&offset=5
```
:::

::: details json api
```http
/users?page[limit]=10&page[offset]=5
```
:::
 
::: details odata
```http
/users?$top=10&$skip=5
```
:::

### Take & Skip

`take()` and `skip()` are aliases for `limit()` and `offset()`.
These have been added for the sake of convenience and are inspired by Laravel's [Query Builder](https://laravel.com/docs/9.x/queries#ordering-grouping-limit-and-offset).  

```php
$response = $client
        ->take(10)
        ->skip(5)
        ->get('/users');
```


 
::: details default
```http
/users?limit=10&offset=5
```
:::

::: details json api
```http
/users?page[limit]=10&page[offset]=5
```
:::
 
::: details odata
```http
/users?$top=10&$skip=5
```
:::

## Page & Show 

If supported by the target API, you can use the page-based pagination methods instead.

```php
$response = $client
        ->page(3)
        ->show(25)
        ->get('/users');
```



 
::: details default
```http
/users?page=3&show=25
```
:::

::: details json api
```http
/users?page[number]=3&page[size]=25
```
:::
 
::: details odata
**Warning**: _Page-based pagination is not supported by OData_
```
/users
```
:::

