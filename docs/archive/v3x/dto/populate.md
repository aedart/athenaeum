# Populate

You can populate your DTO using an array.

```php
// property-name => value array
$data = [
    'name' => 'Timmy Jones',
    'age'  => 32
];

// Create instance and invoke populate
$person = new Person();
$person->populate($data); // setName() and setAge() are invoked with the given values
```

## Via `__construct`

If you are extending the default DTO abstraction, then you can also pass in an array in the constructor.

```php
// property-name => value array
$data = [
    'name' => 'Carmen Rock',
    'age'  => 25
];

// Create instance and invoke populate
$person = new Person($data);
```

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
