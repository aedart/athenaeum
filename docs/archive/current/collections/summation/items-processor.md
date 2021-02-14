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

In short, if you start having complex processing rules within your code, then perhaps your should consider refactoring it.
The `ItemProcessor` can help your to separate such concerns. 

### Game as examples

For the sake of simplicity, the remaining of this documentation will use a game as example of how the `ItemProcessor` can be used.
Image that you must create a live report of a player's current _strength, agility, intelligence, armor, minimum and maximum damage, ...etc_, based on the player's items.
Furthermore, imaging that your datasource is delivered by 3rd party, _e.g. a cvs file, xml file or RESTful api_.
Thus, you do not have the same kind of control and access af your datasource, as you normally would with a database.

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

// Process player items
->process($items);
```

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

A slightly more complex example, could be a rule in which you increase or decrease magic damage or resistance, depending on the item's properties.

**Using item properties or state example**

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

## Creating Processing Rule that apply for some items

In the previous example, the `MagicItems` rule would be applied for all types of items.
Yet, it's implementation contained an abort condition, which skips further processing if given item isn't magical in nature.
This can be rewritten, so that the rule is automatically only applied for items that are magical.
To do so, you must inherit from the `Determinable` interface.

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
Behind the scene, the `ItemsProcessor` will filter off any processing rules that are not applicable for a given item, if the processing rule inherits from the `Determinable` interface.
To continue with the game example, consider the following two processing rules.

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

## Post processing

To perform post-processing logic, you can apply a callback using the `after()` method, in your `ItemsProcessor`.

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

In all of the shown examples, the `$item` that is passed to a processing rule is treated as an `array`.
However, the `ProcessingRule` **does not imply any datatype restrictions** on the `$item` property.
So, you can process anything from scalar types to complex objects, should you require it.

## Onward

Using the `ItemsProcessor` _can_ help to you separate complex processing rules into their own components.
Yet, **it does not come for free!**
Depending on the amount of "items" you must process and the complexity of your rules, this type of solution can decrease performance of your application.
You should therefore always use this with care and only when suitable.
If you are working with a database as your datasource, chances are good that you can retrieve desired data directly from it.
Should that not be the case, then you _SHOULD_ at the very least consider how to limit the amount of items to be processed, when using this component. 
