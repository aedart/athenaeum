---
description: Http Client Driver
sidebarDepth: 0
---

# Driver

If for some reason you require access to the native underlying driver (Guzzle), then you can use the `driver()` method to obtain the instance.

```php
$driver = $client->driver();
```

::: tip Note
When you are gradually building your request, e.g. setting request options, then these options are not set directly in the native driver.
Only when the request is being performed are the request options passed on to the native driver.
:::

