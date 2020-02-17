---
description: How to install Athenaeum Core Application Package
sidebarDepth: 0
---

# How to install

```console
composer require aedart/athenaeum-core
```

::: danger Warning
This package is not intended to be used inside a regular Laravel application.
The Athenaeum Core Application is a custom / adapted version of a Laravel application.
It is therefore intended to run on it's own.

#### Will Highjack the `app` Binding

If you still choose to require and use this inside your regular Laravel application, then you risk that it will highjack the `app` binding, which will result in very undesirable behaviour.

If you haven't already, please read the [Limitations](./README.md) section to gain an understanding of what this application's limitations are.  
:::
