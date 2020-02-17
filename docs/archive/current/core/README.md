---
description: About the Athenaeum Core Application Package
---

# Athenaeum Core Application

TODO... documentation is in the process of being written. Come back a bit later...

## Motivation

When working with [legacy applications](https://en.wikipedia.org/wiki/Legacy_system) - despite your best intentions - it might not be possible to use the entire Laravel framework.
At the end of the day, the reasons why you continue to add features and keep a legacy application alive does not matter.
You still have to get the job done.
Surely, you can make your work a bit easier by using a few of Laravel's packages.
But when you end up having to use more than just a few, then it becomes somewhat tricky to setup all those services. 


I have created this package in hopes that it can bridge the gab between some of Laravel's packages and legacy applications. 
It is not a replacement for the Laravel framework! 

### But why not just use Laravel?

To be as clear as humanly possible, if you can make use of the entire Laravel framework in order to achieve your goal within your legacy application, then please do so.
If you do spend enough time reviewing Laravel's source code, you might be surprised how flexible and powerful it actually is.

However, despite such flexibility, Laravel can't be bent to solve every kind of challenge. Nor is it fair to ask it's author and contributors to solve every problem that you might be facing, when dealing with legacy applications.
Ultimately, not even this package will be able to solve all of your challenges.
It only offers a "minimum" set of functionality, hopefully allowing you to bring some of Laravel's capabilities, services and components into your legacy application. 

## Limitations

When comparing this application with the one offered by Laravel, this application has an abundance of limitations.
Some of those limitations are deliberate. It is not this application's intent to be a copy of Laravel's application.

To illustrate some of the limitations, consider the following major unsupported features: 

### No Http Request / Response Support

Presumably your legacy application already has it's own way of dealing with Http Requests and Responses.
Trying to redesign your application to support a different request and response handling, might prove to be very difficult, when the architecture is already established. 
Therefore, this application does not offer any support for such.

### No Frontend Support

For the same reasons as Http Request / Response handling, no frontend related features are directly offered.
This means that [Blade](https://laravel.com/docs/6.x/blade) isn't directly supported.

### No Database Support

Most legacy applications already have some kind of database abstraction layer.
Perhaps they makes use of [PDO](https://www.php.net/manual/en/class.pdo) or maybe good old [mysqli](https://www.php.net/manual/en/class.mysqli.php).
Regardless, redesigning your entire database abstraction layer can be extremely overwhelming and perhaps also ill advised. 
As such, [Eloquent](https://laravel.com/docs/6.x/eloquent) is not directly support by this application.
Yet, should you still desire to attempt incorporating Eloquent into your legacy application, then please read [Laravel's documentation](https://packagist.org/packages/illuminate/database).  

### Other Limitations

The reason why the Athenaeum Core Application is able to provide some support for Laravel's services (packages), is because it implements the [`\Illuminate\Contracts\Foundation\Application`](https://github.com/laravel/framework/blob/6.x/src/Illuminate/Contracts/Foundation/Application.php) interface.
This provides some of the compatibility. But it's implementation differs from that of Laravel's.
For this reason, you should expect it's behaviour to be different and therefore not able to support all the features that you otherwise would expect from Laravel's application.

## Alternatives

TODO... A few good alternatives?
