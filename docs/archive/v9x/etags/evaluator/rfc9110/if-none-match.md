---
description: If-None-Match Precondition
sidebarDepth: 0
---

# If-None-Match

**Class:** _`\Aedart\ETags\Preconditions\Rfc9110\IfNoneMatch`_

## Applicable

When `If-None-Match` header is requested.

## Condition

1. If the `If-None-Match` header is "*", the condition is **false** if current representation (_Etag_) exists for the target resource.
2. If the `If-None-Match` header is a list Etags, the condition is **false** if one of the listed tags matches the Etag of the selected representation (_the resource_).
3. Otherwise, the condition is **true**.

## When it passes

When condition passes, evaluation continues to [If-Range precondition](if-range.md).

## When it fails

If request is `GET` or `HEAD`, the [`abortNotModified()`](../actions.md#abort-not-modified) action method is invoked.

For other Http methods, the [`abortPreconditionFailed()`](../actions.md#abort-precondition-failed) action method is invoked.


## References

* [If-None-Match specification](https://httpwg.org/specs/rfc9110.html#field.if-none-match)