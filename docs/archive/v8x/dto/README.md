---
description: About the Dto Package
---

# Data Transfer Object (DTO)

A variation / interpretation of the Data Transfer Object (DTO) design pattern (Distribution Pattern). A DTO is nothing more than an object that
can hold some data. Most commonly it is used for for transporting that data between systems, e.g. a client and a server.
This package provides an abstraction for such DTOs.

If you don't know about DTOs, I recommend you to read [Martin Fowler's description](http://martinfowler.com/eaaCatalog/dataTransferObject.html) of DTO, and perhaps
perform a few [Google searches](https://www.google.com/search?q=data+transfer+object&ie=utf-8&oe=utf-8) about this topic.

## When to use this

* When you need to encapsulate data that needs to be communicated between two or more systems, services or components.

::: warning A word of caution
Using DTOs will increase the complexity of your project.
You should only use them when you are really sure that you need them.
:::
