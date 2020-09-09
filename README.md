[![Latest Stable Version](https://poser.pugx.org/aedart/athenaeum/v/stable)](https://packagist.org/packages/aedart/athenaeum)
[![Total Downloads](https://poser.pugx.org/aedart/athenaeum/downloads)](https://packagist.org/packages/aedart/athenaeum)
[![Latest Unstable Version](https://poser.pugx.org/aedart/athenaeum/v/unstable)](https://packagist.org/packages/aedart/athenaeum)
[![composer.lock](https://poser.pugx.org/aedart/athenaeum/composerlock)](https://packagist.org/packages/aedart/athenaeum)
[![License](https://poser.pugx.org/aedart/athenaeum/license)](https://packagist.org/packages/aedart/athenaeum)
[![Build Status](https://travis-ci.org/aedart/athenaeum.svg?branch=master)](https://travis-ci.org/aedart/athenaeum)

# Athenaeum

Athenaeum is a [mono repository](https://en.wikipedia.org/wiki/Monorepo); a collection of various packages. 
The majority are based on well known components, such as those offered by [Laravel](https://laravel.com/).
Some of the key packages that are offered by Athenaeum, are the following:

### [Config](https://aedart.github.io/athenaeum/archive/current/config/)

_A configuration loader, supporting *.ini, *.json, *.php, *.yml and *.toml._

### [Core](https://aedart.github.io/athenaeum/archive/current/core/)

_A custom Laravel Application implementation, intended to be integrated into legacy applications._

### [Circuits](https://aedart.github.io/athenaeum/archive/current/circuits)

_A Circuit Breaker to encapsulate failure prevention logic._

### [Dto](https://aedart.github.io/athenaeum/archive/current/dto/)

_Data Transfer Object abstraction._

### [Http Clients](https://aedart.github.io/athenaeum/archive/current/http/clients/) 

_Http Client wrapper, with a Manager able to handle multiple "profiles"._

### [Support](https://aedart.github.io/athenaeum/archive/current/support/) 

_Aware-of Helpers for Laravel and DTOs._

## Not a Framework

Despite the amount of packages, you should not mistake Athenaeum for a framework.
It is not the intent nor purpose of this mono repository to act as a framework.
The majority of the offered packages, are merely helpers and utilities.

# How to install

```console
composer require aedart/athenaeum
```

# Official Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Contribution

Have you found a defect ( [bug or design flaw](https://en.wikipedia.org/wiki/Software_bug) ), or do you wish improvements? In the following sections, you might find some useful information
on how you can help this project. In any case, I thank you for taking the time to help me improve this project's deliverables and overall quality.

### Bug Report

If you are convinced that you have found a bug, then at the very least you should create a new issue. In that given issue, you should as a minimum describe the following;

* Where is the defect located
* A good, short and precise description of the defect (Why is it a defect)
* How to replicate the defect
* (_A possible solution for how to resolve the defect_)

When time permits it, I will review your issue and take action upon it.

### Fork, code and send pull-request

A good and well written bug report can help me a lot. Nevertheless, if you can or wish to resolve the defect by yourself, here is how you can do so;

* Fork this project
* Create a new local development branch for the given defect-fix
* Write your code / changes
* Create executable test-cases (prove that your changes are solid!)
* Commit and push your changes to your fork-repository
* Send a pull-request with your changes
* _Drink a [Beer](https://en.wikipedia.org/wiki/Beer) - you earned it_ :)

As soon as I receive the pull-request (_and have time for it_), I will review your changes and merge them into this project. If not, I will inform you why I choose not to.

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
