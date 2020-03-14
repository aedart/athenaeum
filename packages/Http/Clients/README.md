# Athenaeum Http Clients

Provides a Http Client wrapper along with a Manager that is able to handle multiple "profiles".
This allows you to segment each api you communicate with, into it's own client instance.

By default, [Guzzle Http Client](http://docs.guzzlephp.org/en/stable/index.html) is used as the default Http Client.
However, this package does not limit you to using using only Guzzle. You can create your own wrapper.

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
        $response = $client->get('/currencies');
        
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
