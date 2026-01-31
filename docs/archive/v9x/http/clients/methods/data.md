---
description: Request Payload Data
sidebarDepth: 0
---

# Payload

[[TOC]]

## Via Request Methods

The `post()`, `put()`, `patch()`, `delete()` and `request()` methods allow you to set a request's payload data, via an array of key-value pairs. 

```php
$response = $client
        ->patch('/users/5547', [
            'email' => 'smith.henrikson@acme.org'
        ]);
```

## Add Data

If you require to build up your request's payload gradually, then you can achieve such using the `withData()` method.
The method accepts an array, which is merged with the request's already added payload data, before it is sent.

```php
$builder = $client
        ->withData([ 'name' => 'Sophia' ]);

// Later...
$builder->withData([ 'email' => 'sophia.wayne@acme.org' ]);
```

## Set Data

Alternatively, you can specify the entire payload using `setData()`.
The method **will overwrite** payload data that has already been set.

```php
$builder = $client
        ->setData([
            'name' => 'Sophia',
            'email' => 'sophia.wayne@acme.org'
        ]);
```

## Raw Payload

In situations where you require complete control of the request's body, use `withRawPayload()`.
Unlike the previous illustrated methods, the raw-payload method allows you to specify the entire request body. 

```php
$builder = $client
        ->withRawPayload('raw request body...');
```

::: warning
You cannot set a request's payload using both raw-payload and data (`withData()`, `setData()` or via request methods).

[Attachments](./attachments) specified prior or after setting the raw-payload, will be ignored.
:::
