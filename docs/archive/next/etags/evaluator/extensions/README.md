---
description: Additional Preconditions (Extensions)
sidebarDepth: 0
---

# Introduction

As previously described, the `Evaluator` is able to evaluate a list of preconditions.
When none are specified, then a list of [predefined / supported preconditions are used](../preconditions.md#supported-preconditions). 
In this chapter you will find documentation of available custom preconditions (_extensions_), which are **NOT part of [RFC 9110](https://httpwg.org/specs/rfc9110.html#preconditions)**. 

In addition, this chapter contains a minimalistic example is shown for how to create a custom precondition.

[[TOC]]

## Custom Precondition

To create a custom precondition, extend the `BasePrecondition` abstraction.
You will be required to implement the following methods:

* `isApplicable()` _determines if precondition is applicable for current request and requested resource._
* `passes()` _determines if precondition passes (evaluation)._
* `whenPasses()` _invoked if the precondition passes._
* `whenFails()` _invoked if the precondition fails._

The following example precondition is applicable when a `X-If-Author` header is available.
If the requested "author" matches a predefined value, then the precondition passes.

```php
use Aedart\ETags\Preconditions\BasePrecondition;
use Aedart\Contracts\ETags\Preconditions\ResourceContext as Resource;

class IfAuthor extends BasePrecondition
{
    public function isApplicable(Resource $resource): bool
    {
        // Determine when this precondition is applicable - when should it
        // be evaluated?
        return $this->getMethod() === 'GET'
            && $this->getHeaders()->has('X-If-Author')
            && isset($resource->data()->author)
    }

    public function passes(Resource $resource): bool
    {
        // Determine when this precondition is considered "passed"
        $author = $this->getHeaders()->get('X-If-Author');
        
        return $resource->data()->author === $author;
    }

    public function whenPasses(Resource $resource): Resource|string|null
    {
        // Change the state of the resource... e.g. add meta info about the requested
        // author... or whatever makes sense to you...
        $resource->set('load_author_book_titles', true);
    
        // Alternatively, you can use custom actions to change the state... 
        // E.g. $this->actions()->markAuthorBooksToBeLoaded($resource); 
    
        // Finally, allow evaluation of evt. next precondition...
        return null;
    }

    public function whenFails(Resource $resource): Resource|string|null
    {
        // E.g. abort the current request... or perform other logic...
        return $this->actions()->abortPreconditionFailed($resource);
    }
}
```

## Pass / Fail Methods

The `whenPasses()` and `whenFails()` are responsible for **_either_** of the following:

### Return a `ResourceContext`

When a "changed" resource is returned, the evaluator will **_stop further evaluation_** and allow your regular request processing to continue.
Typically, this means that your request will proceed to input validation and your controller / route action is invoked.

```php
// ...Inside your precondition...
    
public function whenPasses(Resource $resource): Resource|string|null
{   
    // Change state or data, and return resource. No further preconditions evaluated!
    return $resource->set('pages_to_highlight', [ 2, 43, 44, 61]);
}
```

### Return class path (_to specific precondition_)

By returning a class path to a specific precondition, the evaluator will automatically instantiate it, determine if its applicable, and evaluate it. 

```php
// ...Inside your precondition...

public function whenPasses(Resource $resource): Resource|string|null
{
    // Change the state of the resource...
    $resource->set('load_author_book_titles', true);

    // Continue to specific precondition
    return MyOtherCustomPrecondition::class;
}
```

::: warning Caution
While this mechanism allows you to create complex evaluation flow, it will **NOT** allow you to specify a class path to a precondition that:

* Has already been evaluated.
* Is located before the current precondition (_array index in [list of preconditions](../preconditions.md#specify-preconditions)_).
* Does not exist in the evaluator's [list of preconditions](../preconditions.md#specify-preconditions).

The evaluator will throw a `LogicException` if in such situations
:::

### Return `null` (_next precondition_)

When you return `null` from your pass or fail method, the evaluator will simply continue to the next precondition in its list. 

```php
// ...Inside your precondition...

public function whenPasses(Resource $resource): Resource|string|null
{
    // ...resource change logic not shown here...
    
    // Continue to next precondition
    return null;
}
```

### Throw Http Exception

Lastly, in situations when your precondition needs to stop the request processing entirely, you can throw an appropriate Http Exception.
When doing so, your application's exception handler will deal with the exception and create a Http response accordingly.

```php
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

// ...Inside your precondition...

public function whenFails(Resource $resource): Resource|string|null
{
    throw new BadRequestHttpException('X-If-Author value must be a string');
}
```

To ensure that your default exception handler creates an appropriate response, your exception should inherit from `\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface`.

## Onward

For additional information, please review the source code of `\Aedart\ETags\Preconditions\BasePrecondition` abstraction.