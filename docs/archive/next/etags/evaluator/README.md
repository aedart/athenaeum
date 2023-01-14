---
description: How to work with Http Conditional Requests Evaluator
sidebarDepth: 0
---

# Introduction

[[TOC]]

## The Basics

The design philosophy behind the request preconditions `Evaluator` is to evaluate an incoming [conditional request (precondition)](https://httpwg.org/specs/rfc9110.html#preconditions), e.g. `If-Match`, against the requested [resource](./resource-context.md).   

When a precondition is evaluated, either of the following will happen:

* When it passes (`true`):
  * Evaluator continues to evaluate another precondition (_if requested_)
  * Or it returns a changed [resource](./resource-context.md) (_e.g. a state change or perhaps entirely modified resource_)
* When it fails (`false`):
  * The request is aborted by throwing an appropriate `HttpException`, via an [`Actions` component](./actions.md)  

All preconditions are evaluated in accordance with [RFC9110 defined precedence order](https://httpwg.org/specs/rfc9110.html#precedence).
See [supported preconditions](./preconditions.md#supported-preconditions) for additional information.

--- 

TODO: ...

```php
use Aedart\ETags\Preconditions\Evaluator;
use Aedart\ETags\Preconditions\Resources\GenericResource;

// Process If-Match, If-None-Match, If-Modified-Since... etc
// Depending on condition's pass/fail, the request can be aborted via
// an appropriate Http Exception, or proceed to your logic...
$resource = Evaluator::make($request)
    ->evaluate(new GenericResource(
        data: $model,
        etag: $model->getStrongEtag(),
        lastModifiedDate: $model->updated_at
    ));
```