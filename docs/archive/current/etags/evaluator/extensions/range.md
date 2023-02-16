---
description: Range Extension Precondition
sidebarDepth: 0
---

# Range

**Class:** _`\Aedart\ETags\Preconditions\Additional\Range`_

::: warning Note
This extension is enabled by default in the `Evaluator`, because a client is able to perform a `Range` request, without `If-Range` precondition.
When such happens, it is prudent and feasible to perform the same kind of range-set validation, as for the RFC 9110 defined `If-Range` precondition.
:::

## Applicable

When the request method is `GET`, `Range` header is present, `If-Range` is NOT present, and the resource supports range requests.

## Condition

If the requested ranges are applicable (_if they are valid_) for the requested resource.
Validation of ranges is performed via a [`RangeValidator`](../range-validator.md).

## When it passes

The [`processRange()`](../actions.md#process-range) action method is invoked.
Evaluator continues to [extensions](../extensions/README.md), when available. Otherwise, request processing continues.

## When it fails

The [`ignoreRange()`](../actions.md#ignore-range) action method is invoked.
Evaluator continues to [extensions](../extensions/README.md), when available. Otherwise, request processing continues.

## References

* [If-Range precondition](../rfc9110/if-range.md)