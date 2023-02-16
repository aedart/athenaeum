---
description: If-Range Precondition
sidebarDepth: 0
---

# If-Range

**Class:** _`\Aedart\ETags\Preconditions\Rfc9110\IfRange`_

## Applicable

When the request method is `GET`, both `Range` and `If-Range` headers are present, and the resource supports range requests.

## Condition

**a**) [ETag](https://httpwg.org/specs/rfc9110.html#field.etag) or [HTTP-date](https://httpwg.org/specs/rfc9110.html#http.date) is matched against the resource.

When `If-Range` header is an [HTTP-date](https://httpwg.org/specs/rfc9110.html#http.date):

1. (_ignored¹_) ~~_If the HTTP-date validator provided is not a strong validator in the sense defined by [Section 8.8.2.2](https://httpwg.org/specs/rfc9110.html#lastmod.comparison), the condition is **false**_~~.
2. If the HTTP-date validator provided **exactly matches** the Last-Modified date of the resource, the condition is **true**.
3. Otherwise, the condition is **false**.

When `If-Range` header is an [ETag](https://httpwg.org/specs/rfc9110.html#field.etag):

1. If the Etag validator provided **exactly matches** the ETag of the resource using the strong comparison, the condition is **true**.
2. Otherwise, the condition is **false**.

**b**) If the requested ranges are applicable (_if they are valid_) for the requested resource.
Validation of ranges is performed via a [`RangeValidator`](../range-validator.md).

---

1: _Default implementation is not able to reliably deduce whether validation of Last-Modified Date is strong or weak._
_If you have a well versed in RFC9110's definitions of strong and weak Date validators, and you have a good idea on how this can be safely implemented, feel free to submit a pull request!_

## When it passes

The [`processRange()`](../actions.md#process-range) action method is invoked.
Evaluator continues to [extensions](../extensions/README.md), when available. Otherwise, request processing continues.

## When it fails

The [`ignoreRange()`](../actions.md#ignore-range) action method is invoked.
Evaluator continues to [extensions](../extensions/README.md), when available. Otherwise, request processing continues.

## References

* [If-Range specification](https://httpwg.org/specs/rfc9110.html#field.if-range)
* [Range extension](../extensions/range.md)