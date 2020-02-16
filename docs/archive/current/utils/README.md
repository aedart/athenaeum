---
description: About the Utils Package
---

# Introduction

This package offers a few utility components.
They are used throughout many of the Athenaeum packages, yet you can choose to make use of them, as you see fit.

## Example

```php
use Aedart\Utils\Json;
use Aedart\Utils\Version;

// Obtain version of installed package
$version = Version::package('aedart/athenaeum-utils');

// Json encode ~ throws exception if encoding fails
echo Json::encode([
    'version' => $version
]);
```


