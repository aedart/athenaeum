---
description: How to make a custom Http Client
---

# Make A Custom Http Client

There are several good Http Clients available on [packagist](https://packagist.org/?query=http%20client).
With that in mind, perhaps the easiest way for you to create you Http Client, is by wrapping an existing client.

## Create you Client

In the following example, a simplified wrapper client is shown, using [Buzz Browser](https://github.com/kriswallsmith/Buzz) as the underlying driver that handles actual Http requests.
Your client must adhere to the `Aedart\Contracts\Http\Clients\Client` interface.

```php
namespace Acme\Http\Clients;

use Aedart\Contracts\Http\Clients\Client;
use Psr\Http\Message\ResponseInterface;
use Buzz\Browser;
use Buzz\Client\FileGetContents;
use Nyholm\Psr7\Factory\Psr17Factory;

class MyCustomHttpClient implements Client
{
    protected ?Browser $client;

    protected array $options = [];

    public function __construct(array $options = [])
    {
        $this->options = $options;

        // Create internal client
        $client = new FileGetContents(new Psr17Factory());
        $this->client = new Browser($client, new Psr17Factory()); 
    }

    public function driver()
    {
        return $this->client;
    }

    public function request(
        string $method,
        $uri,
        array $options = []
    ) : ResponseInterface
    {
        $factory = new Psr17Factory(); 
        
        $request = $factory->createRequest($method, $uri);

        // ... options handling not shown ...

        return $this->driver()->sendRequest($request);
    }

    // ... remaining not shown ...
}
```

## Create a new profile

Once you have completed your custom Http Client, create a new "profile" in `/configs/http-clients.php`, and add your Http Client's class path in the `driver` key.

```php
<?php
return [

    'profiles' => [

        'my-custom-client' => [
            'driver'    => \Acme\Http\Clients\MyCustomHttpClient::class,
            'options'   => [
                // Your client options
            ]
        ],

        // ... remaining not shown ...
    ]
];
```

## Obtaining the Client

To obtain your client, simply state the profile name in the `profile()` method.
See [basic usage](./usage.md) for more information.

```php
$myClient = $this->getHttpClientsManager()->profile('my-custom-client');
```
