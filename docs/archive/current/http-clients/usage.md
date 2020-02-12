---
description: How to use Http Clients
---

# Usage

## Obtain Http Client

To obtain a http client, you can use the `HttpClientsManager`, which can be obtained via a trait.

```php
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;

class WeatherController
{
    use HttpClientsManagerTrait;
    
    public function index()
    {
        $client = $this->getHttpClientsManager()->profile();
        
        // Perform a GET requeset
        $response = $client->get('/weather-report.html');
        
        // ...remaining not shown
    }
}
```

## Obtain Specific Client Profile

In order to obtain a Http Client instance that matches a specific profile, simply state the name as argument for the `profile()` method. 

```php
$myClient = $this->getHttpClientsManager()->profile('my-client-profile');
```
