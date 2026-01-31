---
description: Http Query Builder
sidebarDepth: 0
---

# Introduction

The Http Client contains a powerful Http Query Builder.
It gives you the possibility to set query parameters fluently, and it supports a few grammars.
These grammars are responsible for assembling (_or building_) the actual http query string.
Each offer a few options, which can be specified via your `config/http-clients.php` configuration.
Read the [configuration](../setup.md#http-query-grammars) chapter, for additional information about how to configure your desired grammar.

## Example

```php
$response = $client
        ->where('last_name', 'thomsen')
        ->where('age', 'gt', 31)
        ->get('https://acme.org/api/v1/users');
```

### Performed Request

The following illustrates the request that was sent, from previous example.
Each tab shows the http request that was sent, using a different Http Query Grammar.


 
::: details default
Builds query strings, yet does not follow any specific convention or standard.

```http
GET https://acme.org/api/v1/users?last_name=thomsen&age[gt]=31
```
:::

::: details json api
Builds query strings according to [Json API's recommendations](https://jsonapi.org/format/1.1/#fetching).

```http
GET https://acme.org/api/v1/users?filter[last_name]=thomsen&filter[age][gt]=31
```
:::
 
::: details odata
Builds query strings according to [OData v4](https://www.odata.org/getting-started/basic-tutorial/#queryData)'s syntax.

```http
GET https://acme.org/api/v1/users?$filter=last_name eq `thomsen` and age gt 31
```
:::

