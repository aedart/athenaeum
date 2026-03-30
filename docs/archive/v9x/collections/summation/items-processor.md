---
description: Items Processor
sidebarDepth: 0
---

# Items Processor

The `ItemProcessor` is a component capable of applying "processing rules" on a collection of items.
Each rule can perform a series of computations in which results are set inside a [`Summation`](./README.md) collection.  
The final summation can then be used as part of a summary report.

[[TOC]]

**Example**

```php
use Aedart\Collections\Summations\ItemsProcessor;
use Aedart\Contracts\Collections\Summation;

// Set processing rules
$summation = (new ItemsProcessor([
    ProductTypesSum::class,
    WarehouseStockValue::class,
    PerishableProductsSum::class,
    TotalProductsSum::class
]))

// Prepare Summation Collection
->before(function(Summation $summation) {
    return $summation
            ->set('stock', 0)
            ->set('stock.type_a', 0)
            ->set('stock.type_b', 0)
            ->set('stock.type_c', 0)
            ->set('stock.value', 0)
            ->set('amount_perishable', 0)
            ->set('total_products', 0);
})

// Process items
->process($records);
```

## When to use this

The previous shown example illustrates a possible scenario, in which some kind of warehouse management system must build a summary report.
Most commonly, you _SHOULD_ attempt to build such a report using your datasource (_e.g. your database_).
However, sometimes there are situations when the following might be true:

* It's not possible to obtain desired information from your datasource.
* It's not feasible to queries to your datasource multiple times.
* Different (_possibly complex_) processing rules must be applied, based on items' properties and or state.  

To emphasise the point, of when you could make use an `ItemProcessor` component, consider the following code.

```php
foreach ($records as $record) {
    if($record['type'] === 'A') {
        // process logic for type A...
    } else if($record['type'] === 'B') {
        // process logic for type B...
    } else if($record['type'] === 'C') {
        // process logic for type C...
    }
    
    if($record['type'] === 'B' && $record['expires_at'] >= now()) {
        // more process logic for type B...
    }
    
    if($record['cost'] >= 10000) {
        // process logic for "expensive" item
    } else {
        // process logic for "none-expensive" item
    }
    
    // ... etc
}
```

In short, if you start having complex processing rules within your code, then perhaps you should consider refactoring it.
The `ItemProcessor` can help your to separate item specific processing logic. 

### Game as examples

For the sake of simplicity, the remaining of this documentation will use a game as example of how the `ItemProcessor` can be used.
Image that you must create a live report of a player's current stats, based on the player's items.
This could, for instance, be stats such as _strength, agility, intelligence, armor, minimum and maximum damage,_ ...etc.
Furthermore, imaging that your datasource is delivered by a 3rd party that only offers you limit data retrieval possibilities.
Unlike a database, you might not have the same type "query" possibilities when data is derived from a cvs file, xml file or perhaps a RESTful api.

Your final solution, could look something like this:

```php
use Aedart\Collections\Summations\ItemsProcessor;
use Aedart\Contracts\Collections\Summation;

// Set processing rules
$playerStats = (new ItemsProcessor([
    TotalItems::class,
    Swords::class,
    Shilds::class,
    Maces::class,
    Bows::class,
    Boots::class,
    ChestArmor::class,
    MagicItems::class
]))

// Prepare base stats
->before(function(Summation $stats) {
    return $stats
            ->set('strength', 18)
            ->set('agility', 21)
            ->set('intelligence', 15)
            ->set('min_damage', 42)
            ->set('max_damage', 51)
            ->set('magic_damage', 0)
            ->set('armor', 2)
            ->set('magic_resist', 0)
            ->set('max_health', 650)
            ->set('total_items', 0);
})

// Process player items (e.g. data from 3rd party)
->process($items);
```

In the above shown example, `$playerStats` will hold the final `Summation` instance, containing all the results that have been produced by the various applied rules.
There are some important aspects to consider in this example:

* Your processing logic is separated into their on classes.
* You can always add, remove or replace processing rules.
* You can easily wrap the entire logic into some kind of report or summary component, invoking it whenever and wherever you need it.

How to create processing rules is briefly explained in the upcoming sections. 

## Creating "global" Processing Rule

To create processing rules that apply on all items, simply implement the `ProcessingRule` interface.

**Simple example**

```php
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summation;

class TotalItems implements ProcessingRule
{
    public function process($item, Summation $summation): Summation
    {
        return $summation->increase('total_items', 1);
    }
}
```

Counting all items is a trivial matter, which of course could be solved in via `count($items)` or using other similar functionality. 
Therefore, a slightly different example could be a rule, in which you increase or decrease magic damage or resistance, depending on the item's properties.

**Using item properties or state**

```php
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summation;

class MagicItems implements ProcessingRule
{
    public function process($item, Summation $summation): Summation
    {
        if (empty($item['is_magic'])) {
            return $summation;
        }
        
        return $summation
                    ->increase('magic_damage', $item['magic_damage'])
                    ->increase('magic_resist', $item['magic_resist']);
    }
}
```

The example illustrates how a property of the given `$item` can determine whether processing logic should be performed or not.
Furthermore, multiple values in the `$summation` component can be manipulated, if it makes sense. 
A different way of achieving the same result, is shown a bit later.

**Applying (global) processing rules**

```php
use Aedart\Collections\Summations\ItemsProcessor;

// Set processing rules
$processor = new ItemsProcessor([
    TotalItems::class,
    MagicItems::class
]);
```

Processing rules must be stated as the first argument in the `ItemsProcessor`'s constructor method.
If the rules inherit from the `ProcessingRule`, then they are applied on all items that are processed.
This is good, if that is your intent.
But, it is more likely that you wish to create processing rules, that are only applied when needed.
This is covered in the next section.

## Creating Processing Rule that apply for some items

In the previous example(s), the `MagicItems` rule would be applied for all types of items.
Yet, it's implementation contained an abort condition, which skips further processing if given item isn't magical in nature.
This can be rewritten, so that the rule is automatically only applied for items that are magical.
To do so, a processing rule must also inherit from the `Determinable` interface.

**Determinable processing rule example 1**

```php
use Aedart\Contracts\Collections\Summations\Rules\Determinable;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summation;

class MagicItems implements
    ProcessingRule,
    Determinable
{
    public function canProcess($item): bool
    {
        return !empty($item['is_magic']);
    }

    public function process($item, Summation $summation): Summation
    {        
        return $summation
                    ->increase('magic_damage', $item['magic_damage'])
                    ->increase('magic_resist', $item['magic_resist']);
    }
}
```

As illustrated, the `canProcess()` method is responsible for determining whether the processing rule can be applied or not.
Behind the scene, the `ItemsProcessor` will filter off any processing rules that are not applicable for a given item.
It can only do so, if the processing rule inherits from the `Determinable` interface.
To continue with the game examples, consider the following two processing rules.

**Determinable processing rule example 2**

```php
use Aedart\Contracts\Collections\Summations\Rules\Determinable;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summation;

class ChestArmor implements
    ProcessingRule,
    Determinable
{
    public function canProcess($item): bool
    {
        return $item['type'] === 'armor' && $item['armor_type'] === 'chest';
    }

    public function process($item, Summation $summation): Summation
    {        
        $summation->increase('armor', $item['armor']);
    
        if ($item['weight'] === 'heavy') {
            $summation->decrease('agility', 2);
        }
    
        return $summation;
    }
}
```

**Determinable processing rule example 3**

```php
use Aedart\Contracts\Collections\Summations\Rules\Determinable;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summation;

class Maces implements
    ProcessingRule,
    Determinable
{
    public function canProcess($item): bool
    {
        return $item['type'] === 'weapon' && $item['weapon_type'] === 'mace';
    }

    public function process($item, Summation $summation): Summation
    {
        $summation
            ->increase('min_damage', $item['min_damage'])
            ->increase('max_damage', $item['min_damage']);
        
        if (!empty($item['is_magic']) && $item['magic_class'] === 'light') {
            $summation->increase('intelligence', 5);
        }
        
        return $summation;
    }
}
```

Processing rules can accommodate all kinds of different logic. The above shown examples can be rewritten in any number of ways.
It's entirely up to you how to design them, what they must do and how much responsibility each should have. 

## Post processing

Sometimes it might not be feasible to create a processing rule, if the resulting value(s) can be determined as a result of all other processed values.  
Consider a situation in which you must find the average value of something, e.g. average player damage.
You could add a rule, in which the average value is calculated based on other values and then proceed to process the items. 
Doing so will achieve the task, but it comes at the cost of (re)calculating the average value, each time the processing rule is applied. 
If you find yourself in such a situation, then it's better to extract such logic into "post processing". 

To perform post-processing logic, you can apply a callback using the `after()` method, in your `ItemsProcessor`.
A `Summation` instance is given as argument to the callback, containing all resulting values from the applied processing rules.
You can then proceed to manipulate existing values even further, or add new values.

**Post-processing example**

```php
use Aedart\Contracts\Collections\Summation;

$playerStats = $processor
    ->after(function(Summation $stats) {
        $min = $stats->get('min_damage');
        $max = $stats->get('max_damage');
        $magic = $stats->get('magic_damage');
    
        return $stats
            ->set('average_damage', ($min + $max + $magic) / 3);
    })
    ->process($items);
```

## Item datatype

Up and till this point, the previous examples treated an `$item` as an `array`.
However, the `ProcessingRule` **does not imply any datatype restrictions** on the `$item` property.
Thus, you can process anything from simple scalar types, to complex objects.

## The cost of using this approach

Using the `ItemsProcessor` _can_ help to you separate complex processing rules into their own components.
Yet, **it does not come for free!**

Depending on the amount of "items" you must process and the complexity of your rules, this type of solution can decrease performance of your application.
You should therefore always use this with care and only when suitable.
If you are working with a database as your datasource, chances are good that you can retrieve desired data directly from it.
Should that not be the case, then you _SHOULD_ at the very least consider how to limit the amount of items to be processed, when using this component.

The `ItemsProcessor`'s `process()` method accepts either an `array` or [`Traversable`](https://www.php.net/manual/en/class.traversable).
This means that when you must iterate through large amounts of data, you should consider applying either of the following **or similar approaches**:

* [Generators (_yield syntax_)](https://www.php.net/manual/en/language.generators.syntax.php).
* [Chunk your data](https://www.php.net/manual/en/function.array-chunk).

Which approach is the most suitable, will depend entirely on your situation.
The point is that you should think about your application's performance, when using this type of solution, especially if you intend to process a large amount of data.

## Onward

The `ItemProcessor` is tailored specifically to be used for generating summaries or reports, based on various types of "items". 
It is certainly isn't intended for solving all kinds of data processing challenges and should only be used when the situation is called for.
That being said, it can be a convenient way of separating complex processing logic into their own components.
For more information about this component, please review the source code.
