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
use Aedart\Contracts\ETags\Preconditions\ResourceContext;

class IfAuthor extends BasePrecondition
{
    public function isApplicable(ResourceContext $resource): bool
    {
        // Determine when this precondition is applicable - when should it
        // be evaluated?
        return $this->getMethod() === 'GET'
            && $this->getHeaders()->has('X-If-Author')
            && isset($resource->data()->author)
    }

    public function passes(ResourceContext $resource): bool
    {
        // Determine when this precondition is considered "passed"
        $author = $this->getHeaders()->get('X-If-Author');
        
        return $resource->data()->author === $author;
    }

    public function whenPasses(ResourceContext $resource): ResourceContext|string
    {
        // Change the state of the resource... e.g. add meta info about the requested
        // author... or whatever makes sense to you...
        $resource->set('load_author_book_titles', true);
    
        // Alternatively, you can use custom actions to change the state... 
        // E.g. $this->actions()->markAuthorBooksToBeLoaded($resource); 
    
        // Finally, return the "changed" resource...
        return $resource;
    }

    public function whenFails(ResourceContext $resource): ResourceContext|string
    {
        // E.g. abort the current request... or perform other logic...
        return $this->actions()->abortPreconditionFailed($resource);
    }
}
```

## Pass / Fail Methods

The `whenPasses()` and `whenFails()` are responsible for **_either_** of the following:

**a) Return a `ResourceContext`**

When a "changed" resource is returned, the evaluator will stop further evaluation and allow your regular request processing to continue.
Typically, this means that your request will proceed to input validation and your controller / route action is invoked.

**b) Throw Http Exception**

In situations when your precondition needs to stop the request processing entirely, you can throw an appropriate Http Exception.
When doing so, your application's exception handler will deal with the exception and create a Http response accordingly.

To ensure that your default exception handler creates an appropriate response, your exception should inherit from `\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface`. 

**c) Return class path (_to next precondition_)**

Lastly, if your precondition is intended to allow other preconditions to evaluate, then you can return a class path to the next precondition.
Doing so means that the evaluator will automatically instantiate the new precondition, determine if its applicable, and evaluate it.

```php
    // ...Inside your precondition...
    
    public function whenPasses(ResourceContext $resource): ResourceContext|string
    {
        // Change the state of the resource... e.g. add meta info about the requested
        // author... or whatever makes sense to you...
        $resource->set('load_author_book_titles', true);
    
        // Continue to next precondition
        return MyOtherCustomPrecondition::class;
    }
```

It might seem a bit cumbersome to explicitly return the "next" precondition's class path.
But this is intentional. It will allow you to create complex flows of preconditions that must evaluated or skipped.  
The [default supported](../preconditions.md#supported-preconditions) use this mechanism extensively.

## Onward

For additional information, please review the source code of `\Aedart\ETags\Preconditions\BasePrecondition` abstraction.