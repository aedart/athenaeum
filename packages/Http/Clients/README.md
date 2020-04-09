# Athenaeum Http Clients


This package offers a Http Client wrapper, with a powerful fluent request builder that is able to use different Http Query grammars, supporting both [Json Api](https://jsonapi.org/) and [OData](https://www.odata.org/).
In addition, it also comes with a manager that allows you to handle multiple http client "profiles."
This allows you to segment each api you communicate with, into it's own client instance.

By default, [Guzzle Http Client](http://docs.guzzlephp.org/en/stable/index.html) is used behind the scene.

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

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
