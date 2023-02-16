---
description: Semantic Version validation rule
---

# Semantic Version

Determines whether a version number adheres to [semantic versioning](https://semver.org/) or not.

```php
use Aedart\Validation\Rules\SemanticVersion;

$data = $request->validate([
    'version' => [ new SemanticVersion() ],
]);
```
