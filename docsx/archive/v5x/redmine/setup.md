---
description: How to setup Redmine API Client
---

# Setup

[[TOC]]

## Prerequisites

### Enable the REST Api for Redmine 

Make sure that you have enabled your Redmine instance's REST API, and that you have generated an API key for a user.
Review [Redmine's official documentation](https://www.redmine.org/projects/redmine/wiki/Rest_api) for details.

### Setup Http Client package

To use this API Client, you are required to have setup the [Http Client](./../http/clients/setup.md).

## Register Service Provider

Register `RedmineServiceProvider` in your `configs/app.php` configuration file.

```php
return [

    // ... previous not shown ... //

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */

    'providers' => [

        \Aedart\Redmine\Providers\RedmineServiceProvider::class

        // ... remaining services not shown ... //
    ],
];
```

## Publish Assets (optional)

Run `vendor:publish` to publish this package's configuration.

```shell
php artisan vendor:publish
```

After the command has completed, you should see `configs/redmine.php` in your application.

### Publish Assets for Athenaeum Core Application

If you are using the [Athenaeum Core Application](../../core), then run the following command to publish assets:

```shell
php {your-cli-app} vendor:publish-all
```

## Configuration

Inside your `configs/redmine.php` file, you can specify the "connections" profiles.
These are nothing more than identifiers for what [Http Client](./../http/clients/setup.md) connection profile to be used.

By default, a `"redmine"` http client profile is expected to exist. Feel free to change this to whatever connection profile you wish.
However, please know that only a connection profiles using the `JsonHttpClient` as driver can be used for the Redmine Clients.

### In your `configs/http-clients.php`

Add a dedicated Redmine profile (_you can name it whatever your wish_). Make sure to specify the `base_uri` to your Redmine server url.

```php
return [

    // ...previous not shown ... 

    'profiles' => [

        'redmine' => [
            'driver' => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options' => [

                'base_uri' => env('REDMINE_API_URI', 'https://your-redmine.com/'),
                
                // ...remaining not shown ...            
            ]
        ]
    ],
    
    // ...remaining not shown ... 
];
```

### In your `configs/redmine.php`

Make sure that you have specified the `authentication` setting (_your API token_).

```php
return [

    // ...previous not shown ... 

    'connections' => [

        'default' => [

            'http_client' => 'redmine',

            /*
             | Redmine Authentication token. This option is automatically set as
             | the appropriate Http Header (X-Redmine-API-Key)
            */
            'authentication' => env('REDMINE_TOKEN')
        ]
    ]
];
```