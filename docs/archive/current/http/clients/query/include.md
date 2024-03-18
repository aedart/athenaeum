---
description: Include Resource
sidebarDepth: 0
---

# Include

To include one or more related resources in your response, use the `include()` method.

```php
$response = $client
        ->include('friends')
        ->get('/users');
```


 
::: details default
```http
/users?include=friends
```
:::

::: details json api
```http
/users?include=friends
```
:::
 
::: details odata
```http
/users?$expand=friends
```
:::

## Include Multiple Resources

You can also request an array of related resources to be included.

```php
$response = $client
        ->include(['friends', 'jobs', 'hobbies'])
        ->get('/users');
```


 
::: details default
```http
/users?include=friends,jobs,hobbies
```
:::

::: details json api
```http
/users?include=friends,jobs,hobbies
```
:::
 
::: details odata
```http
/users?$expand=friends,jobs,hobbies
```
:::

