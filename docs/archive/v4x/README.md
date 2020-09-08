---
description: Athenaeum Release Notes
---

# Release Notes

## `v4.x` Highlights

The following highlights some of the new features, available from this version.

### Mono Repository

Athenaeum has now been converted into a true [mono repository](https://en.wikipedia.org/wiki/Monorepo).
This means that you are now able to obtain your desired components, via individual packages.
This has been made possible using [Symplify's Monorepo Builder](https://github.com/symplify/monorepo-builder).
You can now switch your `aedart/athenaeum` dependency to a more specific package, e.g. `aedart/athenaeum-dto`.

### Core Application

A new package that offers a [custom Laravel Application](core).
It is intended to be used within legacy applications, and act as a bridge that allows you to use some of Laravel's services and components.

### Service Registrar

A component that allows you to [register and boot](service) Laravel Service Providers.

### Console

A Service Provider that [registers Console Commands and Schedules](console) via configuration files.

### Events

A Service Provider that [registers Event Listeners and Subscribers](events) via configuration files. 

### Http Clients

The [Http Clients](http/clients) package has been redesigned, adding several new features to allow a more fluent experience.
See the [migration guide](upgrade-guide.md) for details. 

### Http Cookies

New package that contains two simple DTOs; `Cookie` and `SetCookie`.

### Upgraded Dependencies

All dependencies have been upgraded to use the latest version.
Athenaeum packages now make use of Laravel `v7.x`, Symfony `v5.x`, Codeception `v4.x`, ...etc.

### Improved Documentation

The documentation has been greatly improved.
Each package has it's own set of chapters, including install and usage guides.
Additionally, previous documentation has been restored and can be found in the [Archive](../README.md) section.


## Changelog

Make sure to read the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md) for additional information about the latest release, new features, changes and bug fixes. 
