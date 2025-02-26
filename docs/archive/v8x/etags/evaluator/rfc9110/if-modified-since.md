---
description: If-Modified-Since Precondition
sidebarDepth: 0
---

# If-Modified-Since

**Class:** _`\Aedart\ETags\Preconditions\Rfc9110\IfModifiedSince`_

## Applicable

When the request method is `GET` or `HEAD`, `If-None-Match` is NOT present, `If-Modified-Since` header is present, and when the requested resource has a last modified date available.

## Condition

1. If the resources' last modification date is **earlier or equal to** the date provided in the `If-Modified-Since` header, the condition is **false**.
2. Otherwise, the condition is **true**.

## When it passes

When condition passes, evaluation continues to [If-Range precondition](if-range.md).

## When it fails

The [`abortNotModified()`](../actions.md#abort-not-modified) action method is invoked.

## References

* [If-Modified-Since specification](https://httpwg.org/specs/rfc9110.html#field.if-modified-since)