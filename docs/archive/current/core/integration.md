---
description: How to use Athenaeum Core Application
---

# How to Integrate

TODO: ... The following are a few incomplete notes:

1. Create a bootstrap directory - name does not matter

2. Create `app.php` file inside bootstrap dir

3. Create app instance and specify paths - make sure to create these paths

4. Create `.env` with `APP_NAME` and `APP_ENV`

5. Create Console Application, e.g. `cli.php`
Cli should be up and running

6. Publish assets via `php cli vendor:publish-all`
Configs should be published
Run cli again - you should have more commands available.

7. Include application in your entry point, e.g. inside your `index.php`
Example on how.

alternative setup, header + footer files?

Isolated testing notes:

```shell
cd /public
php -S localhost:8000
```

Enter localhost:8000/index.php

-----------------------
Other topics:
    Register Service Providers, e.g. Laravel's or Own
    Exception Handling - should be the first?
        What about logging????
    The run method - alternative setup

Advanced:
    Ext. Application
    Custom Bootstrappers
    Custom Service Providers?