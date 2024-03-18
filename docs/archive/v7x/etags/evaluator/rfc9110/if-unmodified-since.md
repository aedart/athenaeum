---
description: If-Unmodified-Since Precondition
sidebarDepth: 0
---

# If-Unmodified-Since

**Class:** _`\Aedart\ETags\Preconditions\Rfc9110\IfUnmodifiedSince`_

## Applicable

When `If-Match` is NOT present, `If-Unmodified-Since` header is available, and when the requested resource has a last modified date available.

## Condition

1. If the resources' last modification date is **earlier than or equal to** the date provided in the `If-Unmodified-Since` header, the condition is **true**.
2. Otherwise, the condition is **false**.

## When it passes

When condition passes, evaluation continues to [If-None-Match precondition](if-none-match.md).

## When it fails

If the request is state-changing, e.g. `POST`, `PUT`, `PATCH`... etc, the precondition will attempt to detect whether the requested state-change has already succeeded or not.
This is done via the [`hasStateChangeAlreadySucceeded()`](../resource-context.md#determine-state-change-success), in the given resource.
Should a state-change already have succeeded, then the [`abortStateChangeAlreadySucceeded()`](../actions.md#abort-state-change-already-succeeded) action method is invoked.

When the request is not state-changing, e.g. for `GET`, `HEAD` requests, or when a state-change could not be determined, the [`abortPreconditionFailed()`](../actions.md#abort-precondition-failed) action method is invoked.

## References

* [If-Unmodified-Since specification](https://httpwg.org/specs/rfc9110.html#field.if-unmodified-since)