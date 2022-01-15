---
description: How to install Testing Package
---

# How to install

```shell
composer require aedart/athenaeum-testing --dev
```

::: warning Caution
Please note that due to the [Orchestra Testbench](https://packagist.org/packages/orchestra/testbench) dependency, the entire [Laravel Framework](https://laravel.com/) is included.
This is not a mistake. It is how Orchestra is able to provide testing mechanisms for building Laravel specific components and packages.

If you are new to this, please make sure to read Orchestra's [documentation](https://github.com/orchestral/testbench).
Also, ensure this package is required as a [development dependency](https://getcomposer.org/doc/04-schema.md#require-dev) (_e.g. via the `--dev` option_).
:::
