---
description: Fluent API of the Http Client
sidebarDepth: 0
---

# Fluent Api

In similar fashion to [Laravel's Http Client](https://laravel.com/docs/11.x/http-client), you can chain methods together and thereby gradually build your request. 

```php
$response = $client
        ->select('name', 'person')
        ->where('age', 'gt', 26)
        ->orderBy('age', 'desc')
        ->from('/users')
        ->get();
```

Throughout this chapter, the various available methods are briefly explored.


