---
description: Naming Convention for Properties
---

# Naming Convention

## Property Names

Properties can either be stated in [CamelCase](http://en.wikipedia.org/wiki/CamelCase) or [Snake Case](http://en.wikipedia.org/wiki/Snake_case).

```php
$person->personId = 78; // Valid

$person->category_name = 'Products'; // Valid

// Invalid, because its a mix of both camelCase and underscore
$person->swordFish_length = 63;
```

## Getter / Setter Method Names

Getters and setters follow a most strict naming convention; the must follow [CamelCase](http://en.wikipedia.org/wiki/CamelCase) and be prefixed with `get` for getter methods and `set` for setter methods.
In addition, the `Overload` component uses the following syntax or rules when searching for a property’s corresponding getter or setter:

```
getterMethod = getPrefix, camelCasePropertyName;
getPrefix = "get";

setterMethod = setPrefix, camelCasePropertyName;
setPrefix = "set";

camelCasePropertyName = {uppercaseLetter, {lowercaseLetter}};

uppercaseLetter = "A" | "B" | "C" | "D" | "E" | "F" | "G" | "H" | "I" | "J" | "K"
| "L" | "M" | "N" | "O" | "P" | "Q" | "R" | "S" | "T" | "U" | "V" | "W" | "X"
| "Y" | "Z" ;

lowercaseLetter = "a" | "b" | "c" | "d" | "e" | "f" | "g" | "h" | "i" | "j" | "k"
| "l" | "m" | "n" | "o" | "p" | "q" | "r" | "s" | "t" | "u" | "v" | "w" | "x"
| "y" | "z" ;
```

_Above stated syntax / rules is expressed in [EBNF](http://en.wikipedia.org/wiki/Extended_Backus%E2%80%93Naur_Form)_

### Examples

```php
// Looks for getPersonId(), setPersonId($value);
$person->personId = 78;

// Looks for getCategoryName() and setCategoryName($value);
$person->category_name = 'Products';
```

