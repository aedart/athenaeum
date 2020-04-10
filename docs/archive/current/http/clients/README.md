---
description: About the Http Clients Package
---

# Http Clients

This package offers a Http Client wrapper, with a powerful fluent request builder that is able to use different Http Query grammars, supporting both [Json Api](https://jsonapi.org/) and [OData](https://www.odata.org/).
In addition, it also comes with a manager that allows you to handle multiple http client "profiles".
This allows you to segment each api you communicate with, into it's own client instance.

[Guzzle Http Client](http://docs.guzzlephp.org/en/stable/index.html) is used behind the scene.

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
    
    // ... remaining not shown ...
];
```

### Usage

```php
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Teapot\StatusCode;
use DateTime;

class CurrencyController
{
    use HttpClientsManagerTrait;
    
    public function index()
    {
        $client = $this->getHttpClientsManager()->profile('my-client');
        
        // Perform a GET requeset
        $response = $client
            ->useTokenAuth('my-secret-api-token')
            ->where('currency', 'DKK')
            ->whereDate('date', new DateTime('now'))
            ->expect(StatusCode::OK, function(Status $status){
                throw new RuntimeException('API is not available: ' . $status);
            })
            ->get('/currencies');
        
        // ...remaining not shown
    }
}
```
