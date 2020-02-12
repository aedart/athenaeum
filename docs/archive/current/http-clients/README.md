---
description: About the Http Clients Package
---

# Http Clients

Provides a Http Client wrapper and a Manager that is able to handle multiple "profiles".
This allows you to segment each api you communicate with, into it's own client instance.

By default, [Guzzle Http Client](http://docs.guzzlephp.org/en/stable/index.html) is used as a Http Client.
However, this package does not limit you to using Guzzle. You can create your own wrapper.

## Example

## Configuration


```php
return [

    'profiles' => [

        'my-client' => [
            'driver'    => \Aedart\Http\Clients\Drivers\JsonHttpClient::class,
            'options'   => [
                'base_uri' => 'https://acme.com/api/v2'
            ]
        ],
    ]
];
```

### Usage

```php
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;

class CurrencyController
{
    use HttpClientsManagerTrait;
    
    public function index()
    {
        $client = $this->getHttpClientsManager()->profile('my-client');
        
        // Perform a GET requeset
        $response = $client->get('/users');
        
        // ...remaining not shown
    }
}
```
