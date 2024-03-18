---
description: About the Athenaeum Core Application Package
---

# Athenaeum Core Application

The Athenaeum Core Application is a custom implementation of [Laravel's](https://laravel.com/) [`\Illuminate\Contracts\Foundation\Application`](https://github.com/laravel/framework/blob/11.x/src/Illuminate/Contracts/Foundation/Application.php).

It offers the following features:

- Registration and booting of [Service Providers](https://laravel.com/docs/11.x/providers)
- Laravel's [Service Container](https://laravel.com/docs/11.x/container)
- Laravel's [Configuration Repository](https://laravel.com/docs/11.x/configuration)
- Laravel's [Event Dispatcher](https://laravel.com/docs/11.x/events)
- Laravel's [Cache Repository](https://laravel.com/docs/11.x/cache)
- Laravel's [Console Application](https://laravel.com/docs/11.x/artisan) (_lightweight version of Artisan_)
- Exception Handling (_optional_)

## Motivation

Originally, the Core Application package was developed to allow integrating some of Laravel's services and components into [legacy applications](https://en.wikipedia.org/wiki/Legacy_system) (_See [version `4.x`](../../v4x/core/) for extensive background information_).
This is **no longer the case!** This package serves as a minimalistic application, intended for either;

* Testing
* Tinkering
* Development of **non-essential** standalone applications  

In other words, you are probably much better off using either [Laravel](https://laravel.com/), [Lumen](https://lumen.laravel.com/), or [other frameworks](https://en.wikipedia.org/wiki/Category:PHP_frameworks). 
You _SHOULD NOT_ use this application, unless you are very familiar with Laravel's inner-workings, and you know exactly what you are doing!

## Limitations

The Core Application comes with a number of limitations, most of which are on purpose.

* No Http Request / Response Support
* No Frontend Support (_no [Blade](https://laravel.com/docs/11.x/blade)_)
* No Database Support (_no [Eloquent](https://laravel.com/docs/11.x/eloquent)_)
* ...etc

This package is NOT intended to act as a replacement for Laravel, nor Lumen.
Furthermore, you should expect that the behaviour of the application can be vastly different, then that of a regular Laravel application.
