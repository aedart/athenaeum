[![Latest Stable Version](https://poser.pugx.org/aedart/athenaeum/v/stable)](https://packagist.org/packages/aedart/athenaeum)
[![Total Downloads](https://poser.pugx.org/aedart/athenaeum/downloads)](https://packagist.org/packages/aedart/athenaeum)
[![Latest Unstable Version](https://poser.pugx.org/aedart/athenaeum/v/unstable)](https://packagist.org/packages/aedart/athenaeum)
[![composer.lock](https://poser.pugx.org/aedart/athenaeum/composerlock)](https://packagist.org/packages/aedart/athenaeum)
[![License](https://poser.pugx.org/aedart/athenaeum/license)](https://packagist.org/packages/aedart/athenaeum)
[![Build Status](https://github.com/aedart/athenaeum/actions/workflows/tests.yaml/badge.svg?branch=main)](https://github.com/aedart/athenaeum/actions/workflows/tests.yaml)

# Athenaeum

Athenaeum is a [mono repository](https://en.wikipedia.org/wiki/Monorepo); a collection of various packages. 
The majority are based on well known components, such as those offered by [Laravel](https://laravel.com/).
A few of the offered packages are:

**[Config](https://aedart.github.io/athenaeum/archive/current/config/)**

_A configuration loader, supporting *.ini, *.json, *.php, *.yml and *.toml._

**[Core](https://aedart.github.io/athenaeum/archive/current/core/)**

_A custom Laravel Application implementation, intended to be testing, tinkering or developing non-essential custom applications._

**[Circuits](https://aedart.github.io/athenaeum/archive/current/circuits)**

_A Circuit Breaker to encapsulate failure prevention logic._

**[Dto](https://aedart.github.io/athenaeum/archive/current/dto/)**

_Data Transfer Object abstraction._

**[Http Clients](https://aedart.github.io/athenaeum/archive/current/http/clients/)** 

_Http Client wrapper, with a Manager able to handle multiple "profiles"._

**[Support](https://aedart.github.io/athenaeum/archive/current/support/)**

_Aware-of Helpers for Laravel and DTOs._

## Not a Framework

Athenaeum shouldn't be mistaken for a framework, despite the amount of packages that are offered.
The packages are merely helpers and utilities...

# How to install

```console
composer require aedart/athenaeum
```

# Official Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
