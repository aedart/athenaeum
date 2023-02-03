---
description: Additional Preconditions (Extensions)
sidebarDepth: 0
---

# Introduction

As previously described, the `Evaluator` is able to evaluate a list of preconditions.
When none are specified, then a list of [predefined / supported preconditions are used](../preconditions.md#supported-preconditions). 
In this chapter you will find documentation of available custom preconditions (_extensions_), which are **NOT part of [RFC 9110](https://httpwg.org/specs/rfc9110.html#preconditions)**. 

In addition, the chapter contains a minimalistic example is shown for how to create a custom precondition.

## Custom Precondition

To create a custom precondition, extend the `BasePrecondition` abstraction.
You will be required to implement the following methods:

* `isApplicable()` _determines if precondition is applicable for current request and requested resource._
* `passes()` _determines if precondition passes._
* `whenPasses()` _invoked if the precondition passes._
* `whenFails()` _invoked if the precondition fails._

The following example precondition is applicable when a `X-If-Author` header is available.
Furthermore, if the requested "author" matches a predefined value, then the precondition passes.

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

Please see the source code of `\Aedart\ETags\Preconditions\BasePrecondition` for additional information.