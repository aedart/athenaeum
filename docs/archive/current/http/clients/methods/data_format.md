---
description: Request's Payload data format
sidebarDepth: 0
---

# Payload Format

You can set a request's payload format, by using one the the following methods.
Details on how to set the payload, is covered in the upcoming [section](./data).

[[TOC]]

## Json

If you are sending Json, then you can use the `jsonFormat()` method to ensure that all of your request's payload (request body) is automatically Json encoded.
The method will also automatically set the `Accept` and `Content-Type` headers to `application/json`.

```php
$response = $client
        ->jsonFormat()
        ->post('/users', [
            'name' => 'Alicia',
            'job' => 'Painter'
        ]);
```

## Form

To send form data (_`Content-Type: application/x-www-form-urlencoded`_), use the `formFormat()` method.

```php
$response = $client
        ->formFormat()
        ->post('/subscribe', [
            'email' => 'jim@acme.org',
        ]);
```

## Multipart

When you need to send files as part of your request, use `multipartFormat()`.
It will set the `Content-Type` to `multipart/form-data`.

```php
$response = $client
        ->multipartFormat()
        ->attachFile('profile_picture', '/img/profile.png')
        ->post('/profile-picture');
```

You can find more information about sending files, in the [attachments section](./attachments).  

## Via Configuration

The data format can also be specified in your http client's profile options, in your configuration.

```php
<?php

return [

    'profiles' => [

        'default' => [
            'driver' => \Aedart\Http\Clients\Drivers\DefaultHttpClient::class,
            'options' => [

                'data_format' => \GuzzleHttp\RequestOptions::JSON,

                // ... remaining not shown ...
            ]
        ],
    ],
];
```
