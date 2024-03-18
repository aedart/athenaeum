---
description: Response Expectations
sidebarDepth: 0
---

# Response Expectations

The Http Client offers the possibility to "assert" a response's Http Status Code, headers or payload, should you require it. 
In this section, the `expect()` method is introduced. 

[[TOC]]

## Status Code Expectations

### PSR-18

::: warning Caution
When applying response expectations, the [PST-18: HTTP Client's](https://www.php-fig.org/psr/psr-18/#error-handling) is no longer upheld.
The standard recommendation states the following:

"_[...] A Client MUST NOT treat a well-formed HTTP request or HTTP response as an error condition. For example, response status codes in the 400 and 500 range MUST NOT cause an exception and MUST be returned to the Calling Library as normal. [...]_"

This client offers you way to react to status codes, e.g. by throwing exceptions. This mechanism is entirely optional.
In other words, as a developer you have to decide whether to make use of this mechanism, or not.
:::

### Expect Http Status Code

In order to assert that a received response has a specific Http Status Code, e.g. [200 OK](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/200), state your expected/desired status code, as the first argument for the `expect()` method.

```php
use Teapot\StatusCode\All as StatusCode;

$response = $client
        ->expect(StatusCode::OK)
        ->get('/users');
```

If the received response's status code does not match, then an `ExpectationNotMetException` will be thrown.

### Otherwise Callback

The `ExpectationNotMetException` is thrown when the expected status code does not match the received status code.
However, this is only intended as a "boilerplate" exception.
Most likely, you want to throw your own exception.
Therefore, when you provide a `callable` as the second argument, then the `ExpectationNotMetException` is not thrown.
The provided callback is invoked instead. 

```php
use Teapot\StatusCode\All as StatusCode;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Acme\Exceptions\BadResponse;

$response = $client
        ->expect(StatusCode::OK, function(Status $status){
            throw new BadResponse('Bad response received: ' . (string) $status);
        })
        ->get('/users');
```

The callback argument is provided with the following arguments, in the given order:

- `Status`: A wrapper for the received response's http status code and phrase.
- `ResponseInterface`: The received response (_[PSR-7](https://www.php-fig.org/psr/psr-7/)_).
- `RequestInterface`: The sent request (_[PSR-7](https://www.php-fig.org/psr/psr-7/)_).

### Range of Status Codes

The `expect()` method also accepts a range of status codes.
If the received status code matches one of the expected codes, then the response is considered valid.
Should it not match, then either the `ExpectationNotMetException` is thrown, or the callback is invoked (_if provided_). 

```php
use Teapot\StatusCode\All as StatusCode;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Acme\Exceptions\BadResponse;

$response = $client
        ->expect([StatusCode::OK, StatusCode::NO_CONTENT], function(Status $status){
            throw new BadResponse('Bad response received: ' . (string) $status);
        })
        ->get('/users');
```

## Advanced Expectations

### Validate Headers or Payload

In situations when you need to assert more than the received status code, then you can provide a `callable` as the first argument.
Doing so, will allow you to perform whatever validation logic you may require, upon the received response.

```php
use Aedart\Contracts\Http\Clients\Responses\Status;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Acme\Exceptions\BadResponse;

$response = $client
        ->expect(function(
            Status $status,
            ResponseInterface $response,
            RequestInterface $request
        ){
            if( ! $response->hasHeader('user_id')){
                throw new BadResponse('Missing user id');
            }
            
            // ... other response validation - not shown...

            if( ! $status->isSuccessful()){
                throw new BadResponse('Bad response received: ' . (string) $status);
            }
        })
        ->get('/users');
```

### Multiple Expectations

There is no limit to the amount of expectations that you may add for a response.
Thus, you can add multiple expectations via the the `expect()` method.
They will be executed in the same order as you add them.

```php
use Aedart\Contracts\Http\Clients\Responses\Status;
use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode\All as StatusCode;
use Acme\Exceptions\BadResponse;

$response = $client
        // Expect status code...
        ->expect(StatusCode::OK, function(Status $status){
            throw new BadResponse('Bad response received: ' . (string) $status);
        })
    
        // Expect http header...
        ->expect(function(Status $status, ResponseInterface $response){
            if( ! $response->hasHeader('user_id')){
                throw new BadResponse('Missing user id');
            }
        })

        // Expect payload...
        ->expect(function(Status $status, ResponseInterface $response){
            if ( ! $status->isOk()) {
                throw new BadResponse('Bad response received: ' . (string) $status);
            }
        
            $content = $response->getBody()->getContents();
            $response->getBody()->rewind();

            $decoded = json_decode($content);
            if(empty($decoded) || json_last_error() !== JSON_ERROR_NONE){
                throw new BadResponse('Payload is invalid');
            }
        })
        ->get('/users');
```

#### Array of Callbacks

If you expectations start to get bulky or lengthy, then you _should_ extract them into their own methods.
You can add them via an array, using the `withExpectations()` method.
How you choose to extract expectation logic, is entirely up to you.

```php
$response = $client
        ->withExpectations([
            [$this, 'expectOkStatus'],
            $expectUserIdCallback,
            // ...etc
        ])
        ->get('/users');
```

### Custom Response Expectation Classes

You may also extract your expectation logic into a separate class, if you wish so.
Simply extend the `ResponseExpectation` class and implement the `expectation()` method.
The benefit of doing so, is that you can encapsulate more complex response validation logic.
For instance, you can use Laravel's [Validator](https://laravel.com/docs/10.x/validation#manually-creating-validators) to perform validation of a response's payload.  

```php
use Aedart\Http\Clients\Requests\Builders\Expectations\ResponseExpectation;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Aedart\Utils\Json;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Acme\Exceptions\UserWasNotCreatedException;
use Illuminate\Support\Facades\Validator;

class UserWasCreated extends ResponseExpectations
{
    public function expectation(
        Status $status,
        ResponseInterface $response,
        RequestInterface $request
    ): void {
        // Check status code
        if ( ! $status->isCreated()) {
            throw new UserWasNotCreatedException((string) $status);
        }
    
        // Validate response body...
        $payload = Json::decode($response->getBody()->getContents(), true);
        $validator = Validator::make($payload, [
            'uuid' => 'required|uuid',
            'name' => 'required|string'
        ]);    

        if ($validator->fails()) {
            // ... do something else...
        }
    }
}

// --------------------------------------- /
// Use expectation when you send your request
$response = $client
        ->expect(new UserWasCreated())
        ->post('/users', [ 'name' => 'John Snow' ]);
```

### Response Manipulation

The `expect()` method is not design nor intended to manipulate the received response.
This falls outside the scope of the given method. It's only purpose is to allow status code and response validation.

If you require a way to modify the incoming response or perhaps the outgoing request, then consider using [custom middleware](./middleware). 

## Status Code Object

The `Status` object, that given to your expectation callbacks, offers a variety of methods to quickly determine if it matches a desired Http status code.

```php
use Aedart\Contracts\Http\Clients\Responses\Status;
use Teapot\StatusCode\All as StatusCode;

$client
    ->expect(function(Status $status){
        if ($status->isMovedPermanently()) {
            // ...
        }
    
        if ($status->isBadRequest()) {
            // ...
        }
        
        if ($status->is(StatusCode::UNPROCESSABLE_ENTITY)) {
            // ...
        }
        
        if ($status->satisfies([ StatusCode::CREATED, StatusCode::NO_CONTENT ])) {
            // ...
        }
        
        if ( ! $status->isSuccessful()) {
            // ...
        }
    });
```

_See `\Aedart\Contracts\Http\Clients\Responses\Status` for additional details._