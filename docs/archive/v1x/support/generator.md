---
title: Aware-Of Component Generator
sidebarDepth: 3
---

# Generator

Creating aware-of components (_glorified getters and setters_) can be a tiresome task.
To make it a bit easier for yourself, you can use this package's aware-of component generator.
Based on a php configuration file, it will generate a series of interfaces and traits, for your desired properties.

## Prerequisite 

You must have [Twig Template Engine](https://twig.symfony.com/) available in your project.

```
composer require twig/twig
```

## Create Configuration File

The first thing that you need to do, is to create a configuration file.
The easiest way to do so, is via the `dto:scaffold` command.
When executed, it will create a `aware-of-properties.php` file in your project.

```shell
php athenaeum dto:scaffold
```

::: tip
You can specify the directory of where the configuration file should be created, via the `--output` option.
See `php athenaeum dto:scaffold -h` for additional information.
:::

::: tip
The name of the configuration file is not important.
You can change this to whatever suits you.
:::

## Run Generate Command

Provided that you have edited your configuration and specified what aware-of components should be generated (_covered later in this document_), you can run the generate command.
The command expects a path to the configuration file that you wish to use.

```shell
php athenaeum dto:create-aware-of aware-of-properties.php
```

### Force Generate

Should you wish to force create your aware-of components, set the `--force` flag, when running the command.
It will overwrite any existing interfaces and traits.

```shell
php athenaeum dto:create-aware-of aware-of-properties.php --force
```

## Configuration

In your configuration file, you will find a series settings that you can tinker with.
Some of these are highlighted here. For full reference, please read the files internal comments.

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

Contains two series of namespaces to apply, when creating aware-of components; one for interfaces and one for traits.

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

Contains a list of all the aware-of components that you wish to create.

```php
return [
    // ... previous not shown ... //
    
    'aware-of-properties' => [

        stringProperty('name', 'Name of a person', 'name'),
        integerProperty('age', 'Age of a person', 'years'),
    ]
];
```

The data structure of this setting is a list of arrays, containing the information about the following:

* Name of property (aware-of component)
* Description of property
* Data Type, e.g. string, int, boolean... etc
* (_optionally_) input argument name for the generated setter method

To make it a bit easier, several global methods are offered, which return the desired data structure.
These are covered in the next section.

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