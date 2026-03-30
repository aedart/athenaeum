---
description: How to use stream components
---

# Introduction

This package offers two stream components:

* `Stream`: Base "wrapper" implementation that inherits from [PSR-7's `StreamInterface`](https://www.php-fig.org/psr/psr-7/#13-streams).
* `FileStream`: an extended version of `Stream`.

For the sake of simplicity and clarity, the documentation _will only be referring to the `FileStream`._
Yet, it is important that some knowledge of the `Stream` component's existence, in case you may need to create your own specialisation.
