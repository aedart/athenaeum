---
description: How to use Http Clients
---

# Usage

## Obtain Http Client

To obtain a Http Client instance, use the `HttpClientsManager`.
It can be obtained via `HttpClientsManagerTrait`.

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

In order to obtain a Http Client profile, state the profile name as argument for the `profile()` method. 

```php
$myClient = $this->getHttpClientsManager()->profile('my-client-profile');
```
