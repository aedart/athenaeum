---
description: Debugging
sidebarDepth: 0
---

# Debugging

The Http Client offers two methods for debugging outgoing requests and incoming responses; `debug()` and `dd()`.

[[toc]]

## Prerequisite

To make use of the debugging methods, you must have [Symfony Var Dump](https://github.com/symfony/var-dumper) available in your project. 

```shell
composer require symfony/var-dumper --dev
```

## `debug()`

The `debug()` method will dump the outgoing request before it is sent.
When the corresponding response has been received, the method will also dump it.  

```php
$response = $client
        ->where('date', 'today')
        ->debug()
        ->get('/weather');

// Dumps the following (or similar):
//  Array
//  (
//      [request] => Array
//          (
//              [method] => GET
//              [target] => /weather?date=today
//              [uri] => /weather?date=today
//              [protocol_version] => 1.1
//              [headers] => Array
//                  (  
//                      [Accept] => Array
//                          (
//                              [0] => application/json
//                          )
//  
//                      [Content-Type] => Array
//                          (
//                              [0] => application/json
//                          )
//  
//                  )
//  
//              [body] => []
//          )
//  
//  )

// 
// Example dump of response received 
//  Array
//  (
//      [response] => Array
//          (
//              [status] => 404
//              [reason] => Not Found
//              [protocol_version] => 1.1
//              [headers] => Array
//                  (
//                  )
//  
//              [body] => 
//          )
//  
//  )
```

## `dd()`

Unlike `debug()`, The `dd()` method will only dump the outgoing request.
Afterwards the method **will exit** the entire script!

```php
$response = $client
        ->where('date', 'today')
        ->dd() // Dumps request and exists the script!
        ->get('/weather');

// code never reaches here...
``` 

::: warning
It is discouraged to use `dd()` for anything other than debugging, during development.
The method **WILL EXIST YOUR SCRIPT**, which is not favourable within a production environment!
:::

## Custom debugging callback

If the default provided debugging methods are not to your liking, then you can provide your own custom callback, in which you can perform whatever debugging logic you may wish.
Both `debug()` and `dd()` accept a callback, which is provided with the following arguments, when invoked.

* `Type $type`, Http Message Type (_enum_), which is either a `REQUEST` or `RESPONSE`.
* `MessageInterface $message`, [PSR-7 Message](https://www.php-fig.org/psr/psr-7/#31-psrhttpmessagemessageinterface) instance. Either a request or response.
* `Builder $builder`, Http request builder instance.

Consider the following example:

```php
use Aedart\Contracts\Http\Messages\Type;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Psr\Http\Message\MessageInterface;

$response = $client
        ->where('date', 'today')
        ->debug(function(Type $type, MessageInterface $message, Builder $builder) {
            if ($type === Type::REQUEST) {
                // debug a request...
            } else {
                // debug response...
            }       
        })
        ->get('/weather');

// Dumps request and exists the script!
// ...dump not shown here...
```
