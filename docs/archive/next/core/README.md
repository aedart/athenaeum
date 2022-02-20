---
description: About the Athenaeum Core Application Package
---

# Athenaeum Core Application

The Athenaeum Core Application is a custom implementation of [Laravel's](https://laravel.com/) [`\Illuminate\Contracts\Foundation\Application`](https://github.com/laravel/framework/blob/6.x/src/Illuminate/Contracts/Foundation/Application.php).
It is intended to bring some of Laravel's services and components into your [legacy application](https://en.wikipedia.org/wiki/Legacy_system).
It offers the following features:

- Registration and booting of [Service Providers](https://laravel.com/docs/8.x/providers)
- Laravel's [Service Container](https://laravel.com/docs/8.x/container)
- Laravel's [Configuration Repository](https://laravel.com/docs/8.x/configuration)
- Laravel's [Event Dispatcher](https://laravel.com/docs/8.x/events)
- Laravel's [Cache Repository](https://laravel.com/docs/8.x/cache)
- Laravel's [Console Application](https://laravel.com/docs/8.x/artisan) (_lightweight version of Artisan_)
- Exception Handling (_optional_)

Please read the "Motivation" and "Limitations" section before continuing.
_However, if you are entirely new to Laravel and have little experience working with it's Application and Services, then please start by reading the [newcomer chapter](../new.md)._

## Motivation

Despite your best intentions, it might not be possible to make use of the entire Laravel framework, when dealing with legacy applications. 
For whatever reasons, you may have to continue development of new features in an outdated system.
Ultimately, you may wish to start from scratch and make use of all the tools and frameworks you desire.
This may even prove to be the best choice in the long run.
Unfortunately, such a choice isn't always available, and you have to make due with whatever you have.
In other words, at the end of the day, you still have to get the job done.

Nevertheless, to make some tasks easier, perhaps you choose to make due with a few of Laravel's packages.
But when a few packages (or services) become a handful, then it can become somewhat tricky or cumbersome trying to setup those services, when you lack Laravel's native mechanisms; _the ability to register and boot service providers._

This package was created to offer such a mechanism, in hopes that it can bridge the gab between you legacy application and some of Laravel's packages.
However, you must understand that **it is not a replacement for Laravel framework!**

### Why not include the entire Framework?

Should you be able to include the entire Laravel Framework in your vendor, and you are able to achieve your goals within your legacy application, then please do so.
Laravel is incredible powerful. If you spend enough time reviewing it's source code, you might be surprised just how flexible it actually is. 
Consequently, if such a choice is available to you, then you shouldn't have any need for this package. 

Regardless, please bare in mind that no framework can solve every kind of problem or challenge.
Nor would it be fair, to demand it's authors and contributes to solve all of your challenges, when dealing with legacy applications. 
Not even this package will be able to solve all problems.
It only offers a "minimum" set of functionality, hopefully allowing you to bring some of Laravel's capabilities, services and components into your legacy application.
How you choose to make use of it, if at all, is entirely up to you. 

## Limitations

When comparing this package's deliverables, with the application offered by Laravel, it has an abundance of limitations.
To illustrate some of these limitations, consider the following major unsupported features: 

### No Http Request / Response Support

Presumably your legacy application already has it's own way of dealing with Http Requests and Responses.
Trying to redesign your application to support a different request and response mechanism, might prove to be very difficult, when the architecture is already established. 
Therefore, this application does not offer any support for such.
In other words, it does not impose you to change your already established request and response handling.

### No Frontend Support

For the same reasons as Http Request / Response handling, no frontend related features are directly offered.
This means that [Blade](https://laravel.com/docs/8.x/blade) isn't directly supported.

### No Database Support

Most legacy applications already have some kind of database abstraction layer.
Perhaps [PDO](https://www.php.net/manual/en/class.pdo) or [mysqli](https://www.php.net/manual/en/class.mysqli.php) is used directly.
Regardless of such, redesigning your entire database abstraction layer can be extremely overwhelming and perhaps also ill advised. 
As such, [Eloquent](https://laravel.com/docs/8.x/eloquent) is not directly support by this application.
Yet, should you still desire to attempt incorporating Eloquent into your legacy application, then please read [Laravel's documentation](https://packagist.org/packages/illuminate/database).  

### Other Limitations

The reason why the Athenaeum Core Application is able to provide some support for Laravel's services (packages), is because it implements the [`\Illuminate\Contracts\Foundation\Application`](https://github.com/laravel/framework/blob/6.x/src/Illuminate/Contracts/Foundation/Application.php) interface.
This provides some of the compatibility. But it's implementation differs from that of Laravel's.
For this reason, you should expect it's behaviour to be vastly different.
It is not able to support all features, that you otherwise would expect from Laravel's application.

## Alternatives

### Laravel Framework or Lumen

Given the line of argumentation already provided, if may seem redundant to state [Laravel Framework](https://laravel.com/) or [Lumen](https://lumen.laravel.com/) as alternatives (_E.g. you may not have this choice available_).
Yet, this cannot be emphasised enough: _continuing to add features into a legacy application will increase complexity._
Integrating this package into your legacy application will most certainly bring unforeseen challenges.
Therefore, when mentioning Laravel (_or Lumen_) as a possible alternative, try to think about your challenge in a different way.
Perhaps you can extract those "new" features out of your legacy application, by offering them via an API or [microservice](https://en.wikipedia.org/wiki/Microservices).
If this is possible for you, then Laravel or Lumen are good alternatives to consider.

### Other Frameworks

There are many other [PHP frameworks](https://en.wikipedia.org/wiki/Category:PHP_frameworks).
Some are lightweight, whilst others are large-scale.
Some are easy to master, and some are a bit more cumbersome to learn.
The point is, you should know that there are many different types of frameworks available.
Each having it's own strengths and weaknesses.
Perhaps one of those frameworks can be integrated directly into your legacy application, and fulfill some of your needs, without causing too many changes. 
In any case, it is worth taking some time researching what features other frameworks offer, and what requirements they impose. 
