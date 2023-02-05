---
description: Athenaeum Packages Upgrade Guide
sidebarDepth: 1
---

# Upgrade Guide

## From version 6.x to 7.x.

[[TOC]]

### PHP version `8.1` required

You need PHP `v8.1` or higher to run Athenaeum packages.

**Note**: _PHP `v8.2` is supported!_

### Laravel `v10.x`

Please read Laravel's [upgrade guide](https://laravel.com/docs/10.x/upgrade), before continuing here.

### Audit Package

The Audit package has been slightly refactored. As a result, a few components have been deprecated and replaced with improved versions.
However, the dispatched events have undergone some breaking changes. 

#### Deprecations

* `\Aedart\Audit\Traits\RecordsChanges` trait. Replaced by `\Aedart\Audit\Concerns\ChangeRecording`.
* `\Aedart\Audit\Traits\HasAuditTrail` trait  Replaced by `\Aedart\Audit\Concerns\AuditTrail`.
* `\Aedart\Audit\Models\Concerns\AuditTrailConfiguration` concern. Replaced by `\Aedart\Audit\Concerns\AuditTrailConfig`.

The deprecated components will be removed in the next major version.

#### Dispatch Multiple Models Changed

The `ModelChangedEvents::dispatchMultipleModelsChanged()` no longer skips all models, if the first is marked as "skip next recording" (_via model's `skipRecordingNextChange()`_). 
Instead, models are now filtered by their skip state. Only if the models allow recording, will they be included in the dispatched event.

#### Multiple Models Changed Event

The public `$models` attribute can no longer be an `array`, in `MultipleModelsChanged`.
The attribute must now be a `Collection` instance.

#### Model Changed Events (_trait_)

The `\Aedart\Audit\Observers\Concerns\ModelChangedEvents` concern/trait has been redesigned.
Its methods now accept all supported arguments of `ModelHasChanged` event.
Previously, only `$model`, event `$type` and a `$message` was accepted.
Now, the all create / make methods accept the following arguments:

* `Model $model` The model that has changed.
* `string $type` The event type.
* `array|null $original = null` (_optional_) Original data (attributes) before change occurred. Default's to given model's original data, if none given. 
* `array|null $changed = null` (_optional_) Changed data (attributes) after change occurred. Default's to given model's changed data, if none given.
* `string|null $message = null` (_optional_) Eventual user provided message associated with the event. Defaults to model's Audit Trail Message, if available.
* `Model|Authenticatable|null $user = null` (_optional_) The user that caused the change. Defaults to current authenticated user.
* `DateTimeInterface|Carbon|string|null $performedAt = null` (_optional_)  Date and time of when the event happened. Defaults to model's "updated at" value, if available, If not, then current date time is used.

### Removed `SearchProcessor::language()`

The deprecated `\Aedart\Filters\Processors\SearchProcessor::language()` method has been removed. This features didn't work as intended.
No replacement has been implemented.

### Removed `Str::tree()`

`\Aedart\Utils\Str::tree()` was deprecated in `v6.4`. It has been replaced by `\Aedart\Utils\Arr::tree()`.

## Onward

More extensive details can be found in the [changelog](https://github.com/aedart/athenaeum/blob/master/CHANGELOG.md).
