---
description: How to use Aware-of Generator
---

# Generator

Creating aware-of helpers can be a tiresome task.
To make it a bit easier for yourself, you can use this package's generator.
It is able to generate a series of interfaces and traits, based on a configuration file.

## Prerequisite 

You must have [Twig Template Engine](https://twig.symfony.com/) available in your project.

```shell
composer require twig/twig
```

## Create Configuration File

To create the configuration file, use the `dto:scaffold` command.
It will create a `aware-of-properties.php` file in your project directory

```shell
php vendor/bin/aware-of dto:scaffold
```

::: tip
You can specify the directory of where the configuration file should be created, via the `--output` option.

See `php vendor/bin/aware-of dto:scaffold -h` for additional information.
:::

## Run Generate Command

Provided that you have edited your configuration and specified what aware-of helpers should be generated (_covered later in this document_), you can run the `dto:create` command.

The command expects a path to the configuration file that you wish to use.

```shell
php vendor/bin/aware-of dto:create aware-of-properties.php
```

### Force Generate

To force create your aware-of helper, set the `--force` flag.

```shell
php vendor/bin/aware-of dto:create aware-of-properties.php --force
```

::: danger Warning
The `--force` will overwrite existing generated interfaces and traits!
:::

## Configuration

In your configuration file, you will find a series settings that you can tinker with.
Some of these are highlighted here. For full reference, please read the configuration file's internal comments.

### `output`

[Psr-4](https://www.php-fig.org/psr/psr-4/) directory location, where aware-of properties are to be created.

```php
return [
    'output'    => 'src/',
    
    // ... remaining not shown ... //
];
```

::: tip
If you are not accustomed with this generator, try setting the `output` to a dummy directory, e.g. `temp/`, to ensure that all generated interfaces and traits to not conflict with your project's existing classes and directories. 
:::

### `namespaces`

Contains two series of namespaces to apply, when creating aware-of helpers; one for interfaces and one for traits.

```php
return [
    'namespaces' => [

        'vendor' => 'Acme\\',

        'interfaces' => [

            'prefix'  => 'Contracts\\',

            // ... remaining not shown ... //
        ],

        'traits' => [

            'prefix'  => 'Traits\\',

            // ... remaining not shown ... //
        ],
    ],
    
    // ... remaining not shown ... //
];
```

#### `namespaces.vendor`

Top-most prefix to apply on all generated namespaces.

```php
return [
    'namespaces' => [

        'vendor' => 'Acme\\Dto\\',
        
        // ... remaining not shown ... //    
    ],
    
    // ... remaining not shown ... //
];
```

### `aware-of-properties`

Contains a list of all the aware-of helpers that you wish to create.

```php
return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        stringProperty('name', 'Name of a person', 'name'),
        integerProperty('age', 'Age of a person', 'years'),
        
        // ... etc
    ]
];
```

In the above example, a few global helper methods are used to generate meta-information about the Aware-of helpers.
Those methods accept the following arguments:

* Name of property (aware-of component)
* Description of property
* Data Type, e.g. string, int, boolean... etc
* (_optionally_) input argument name for the generated setter method

In the next section, you will find more information about these global helper methods.

## Global Helpers Methods

### `stringProperty()`

Returns "string" aware-of property configuration (_array_).

```php
return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        stringProperty('name', 'Name of a person', 'name'),
        
    ]
];
```

### `integerProperty()`

Returns "integer" aware-of property configuration (_array_).

```php
return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        integerProperty('id', 'Identifier', 'identifier'),
        
    ]
];
```

### `floatProperty()`

Returns "float" aware-of property configuration (_array_).

```php
return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        floatProperty('price', 'Product price', 'value'),
        
    ]
];
```

### `booleanProperty()`

Returns "boolean" aware-of property configuration (_array_).

```php
return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        booleanProperty('isRobot', 'State of player', 'state'),
        
    ]
];
```

### `arrayProperty()`

Returns "array" aware-of property configuration (_array_).

```php
return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        arrayProperty('categories', 'List of categories', 'list'),
        
    ]
];
```

### `callableProperty()`

Returns "callable" aware-of property configuration (_array_).

```php
return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        callableProperty('scoreFn', 'Callback to handle score', 'callback'),
        
    ]
];
```

### `iterableProperty()`

Returns "iterable" aware-of property configuration (_array_).

```php
return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        iterableProperty('players', 'List of players', 'players'),
        
    ]
];
```

### `mixedProperty()`

Returns "mixed" aware-of property configuration (_array_).

```php
return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        mixedProperty('player', 'The player of this game', 'instance'),
        
    ]
];
```

::: tip Note
The "mixed" type ensures that no type hinting is applied for the generated aware-of component.
:::

### `dateTimeProperty()`

Returns "[DateTime](https://secure.php.net/manual/en/class.datetime.php)" aware-of property configuration (_array_).

```php
return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        dateTimeProperty('created at', 'Date of creation', 'date'),
        
    ]
];
```

### `awareOfProperty()`

Returns an array of configuration that allows a generator to build an "aware-of property" component.
It accepts four arguments;

* `string $property` Name of property.
* `string $description` Description of property.
* `string $dataType` (_optional_) Property data type. Defaults to "string" if none given.
* `string|null $inputArgName` (_optional_) Name of property input argument (for setter method).
If `null` given, then input argument name is the same as the property name.

```php
use Aedart\Contracts\Utils\DataTypes;

return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        awareOfProperty('name', 'Name of a person', DataTypes::STRING_TYPE, 'value'),
        
    ]
];
```

### Creating Your Own Type

By using the `awareOfProperty()` helper method, you will be able to create whatever type you desire.
However, the generator will create the interface and trait into your configured `namespaces.[interfaces|traits].prefix` namespace, if it does not know a specific location for your type.

In order to determine the namespace of your type, you must add it to the list of namespaces, in your configuration.
For instance, lets imaging that you create a new type, called `Box` and you that it's interfaces and traits are to be stored in the sub-namespace `Boxes`.
To do so, add it inside the `namespaces.[interfaces|traits].` settings.

```php
use Aedart\Contracts\Utils\DataTypes;

return [
    'namespaces' => [

        // ... previous not shown ... //

        'interfaces' => [

            'prefix'  => 'Contracts\\',

            '\Box'                       => 'Boxes\\',
            DataTypes::STRING_TYPE      => 'Strings\\',
            // ... etc ... //
        ],

        'traits' => [

            'prefix'  => 'Traits\\',

            '\Box'                       => 'Boxes\\',
            DataTypes::STRING_TYPE      => 'Strings\\',
            // ... etc ... //
        ],
    ],
];
```

::: tip Note
If the above example, the `Box` type is assumed to be some kind of class reference, in the top-most namespace.
Should your desired type be class reference, then you must specify a full and valid namespace as the type!
:::
