---
description: Circuit Breaker Events
---

# Events

The following are the events that the circuit breaker dispatches.
These can, for instance, be used to create "service monitoring" logic.

[[TOC]]

Each of these events offer the following methods:

* `state()`: Returns the circuit breaker's current `State`.
* `lastFailure()`: Returns the last reported `Failure` or `null`, if none available.

Both `State` and `Failure` are immutable objects.
Please review `Aedart\Contracts\Circuits\State` and `Aedart\Contracts\Circuits\Failure` for additional information.

## Has Closed

`Aedart\Contracts\Circuits\Events\HasClosed` is dispatched when state, is changed to _Closed_ state (_initial / success state_).

## Has Open

`Aedart\Contracts\Circuits\Events\HasOpened` is dispatched when state, is changed to _Open_ state (_circuit has tripped / failure state_).

## Has Half-Open

`Aedart\Contracts\Circuits\Events\HasHalfOpened` is dispatched when state, is changed to _Half-Open_ state (_intermediate state / recovery attempt state_).

## Failure Reported

Whenever a failure has been reported, `Aedart\Contracts\Circuits\Events\FailureReported` is dispatched.
This event offers a `failure()` method. It guarantees to return a `Failure` object, that contains information about the reported failure.

```php
use Aedart\Contracts\Circuits\Events\FailureReported;

class NotifyOnWhetherServiceFailure
{
    public function handle(FailureReported $event)
    {
        $failure = $event->failure();

        $reason = $failure->reason();
        $failureTime = $failure->reportedAt();
        $totalReportedFailures = $failure->totalFailures();

        // Send notification about failure ... not shown here...
    }
}
```
