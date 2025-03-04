---
description: How to install Athenaeum Core Application Package
sidebarDepth: 0
---

# How to install

```shell
composer require aedart/athenaeum-core
```

::: danger Warning
This package is not intended to be used inside a regular Laravel application.
The Athenaeum Core Application is a custom implementation of Laravel's [`\Illuminate\Contracts\Foundation\Application`](https://github.com/laravel/framework/blob/11.x/src/Illuminate/Contracts/Foundation/Application.php).
It is intended to run on it's own.

#### Will Highjack the Application

If you still choose to require and use this inside your regular Laravel application, then you risk that it will highjack the `app` binding (_Laravel's application instance_).
This will result in very undesirable behaviour.  
:::
