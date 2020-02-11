---
description: How to export Dto
---

# Export

## Export to array

Each DTO can be exported to an array.

```php 
$properties = $person->toArray();

var_dump($properties);  // Will output a "property-name => value" list
                        // Example:
                        //  [
                        //      'name'  => 'Timmy'
                        //      'age'   => 16
                        //  ]
```
