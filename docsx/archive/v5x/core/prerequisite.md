---
description: Prerequisite for using Athenaeum Core Application
---

# Prerequisite

[[TOC]]

## Composer

This might seem trivial for some developers, yet [composer](https://getcomposer.org/) must be available within your legacy application.
Without it's [autoloading capabilities](https://getcomposer.org/doc/01-basic-usage.md#autoloading), it can be difficult to integrate this package's components.
Therefore, please ensure that composer is installed and available inside your legacy application.

## PHP v7.4.x

Unfortunately this package is only available from Athenaeum `v4.x`, meaning that it requires PHP `v7.4.x` or higher.
If your application only runs on older versions of PHP, then you should spend the time upgrading it.
Your application stands to benefit greatly from this, both in terms of security, performance and new language features.

Please consult yourself with [PHP Migration Guides](https://www.php.net/manual/en/migration74.php), for additional information.

_As the author of this package, I apologise if you somehow feel mislead.
I have been working on this and many other packages by myself.
There are limits as to how much backwards compatibility I can offer._

### Other Requirements

See eventual remaining requirements on [packagist](https://packagist.org/packages/aedart/athenaeum-core) or inside this package's `composer.json`.

## Tools to help Upgrading

You are not the only developer, that has to deal with upgrading legacy applications.
Many other developers have gone through the same. Some of these developers have written very useful tools that can help you a lot.
Below is a small list of tools that will help you upgrade.

### PHP Compatibility checker

The [PHP Compatibility Checker](https://github.com/PHPCompatibility/PHPCompatibility) for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer) is a really great tools for identifying outdated code, e.g. unsupported features.
It can be a bit cumbersome to install and setup. Yet, once it is up and running, it will show you exactly what line(s) of code are not compatible with PHP 7.x, 8.x,...etc.

### Symfony Polyfill

Sadly, it is not always easy to deal with outdated code. Sometimes you might hit a "brick wall" that requires lots of hours or perhaps days to get through.
This is especially true, when your legacy application depends on PHP features that are no longer supported. 
Fortunately, [Symfony Polyfill](https://github.com/symfony/polyfill) has a great library that provides backwards compatibility to several outdated features.

### Rector

This is probably the coolest, and most powerful tool for upgrading outdated code. It's able to do so automatically!
Based on a few rules, [Rector](https://getrector.org/) will automatically refactor your code.
According to their documentation, it can upgrade code from PHP `v5.3.x`, all the way to PHP `v7.4.x`.
Check out their [online demo](https://getrector.org/demo) to see it in action.

### Other Tools?

There are many more tools available, than the ones mentioned above.
Try searching [packagist](https://packagist.org/) or your favorite search engine, whenever you feel stuck with some outdated lines of code. 

::: tip Note
If you happen to know of other great tools, that can help developers upgrade their legacy applications, then please feel free to contribute to this page's content.
:::

### Tip for installing Tools

Depending on the tool(s) that you choose to use, they can sometimes cause conflicts with the dependencies that your legacy application might contain.
To avoid having to deal with this, you can make use of [Composer Bin Plugin](https://github.com/bamarni/composer-bin-plugin).
It allows you to install your binary dependencies in a different folder, whilst linking the package's binaries into your regular vendor directory.

## Testing...?

Depending on your end-goals, perhaps it would be better if you start adding a few automated high-level tests for your legacy application. Afterwards, then you can start to refactor, redesign or add several new features.
Nevertheless, bringing automated tests into your legacy application, is beyond the scope of this package.
You may find some inspiration by reviewing the following testing frameworks [Codeception](https://codeception.com/), [PHP Spec](http://www.phpspec.net), [Behat](https://docs.behat.org), [PHPUnit](https://phpunit.de/)... [etc](https://www.google.com/search?q=php+testing+frameworks).

