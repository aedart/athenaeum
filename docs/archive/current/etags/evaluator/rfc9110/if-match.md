---
description: If-Match Precondition
sidebarDepth: 0
---

# If-Match

**Class:** _`\Aedart\ETags\Preconditions\Rfc9110\IfMatch`_

## Applicable

When `If-Match` header is requested.

## Condition

1. If `If-Match` header is "*", the condition is **true** if a current representation (_Etag_) exists for the target resource.
2. If `If-Match` header is a list of Etags, the condition is **true** if any of the listed tags match the Etag of the selected representation (_the resource_).
3. Otherwise, the condition is **false**.

## When it passes

When condition passes, evaluation continues to [If-None-Match precondition](if-none-match.md).

## When it fails

If the request is state-changing, e.g. `POST`, `PUT`, `PATCH`... etc, the precondition will attempt to detect whether the requested state-change has already succeeded or not.
This is done via the [`hasStateChangeAlreadySucceeded()`](../resource-context.md#determine-state-change-success), in the given resource.
Should a state-change already have succeeded, then the [`abortStateChangeAlreadySucceeded()`](../actions.md#abort-state-change-already-succeeded) action method is invoked.

When the request is not state-changing, e.g. for `GET`, `HEAD` requests, or when a state-change could not be determined, the [`abortPreconditionFailed()`](../actions.md#abort-precondition-failed) action method is invoked.

## References

* [If-Match specification](https://httpwg.org/specs/rfc9110.html#field.if-match)