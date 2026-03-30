---
description: About Scan Events
sidebarDepth: 0
---

# Events

Whenever a file is scanned, a `FileWasScanned` event is dispatched.
It contains the file's `ScanResult`, which you can use to act upon.

```php
use Aedart\Contracts\Antivirus\Events\FileWasScanned;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

Event::listen(FileWasScanned::class, function(FileWasScanned $event) {
    $result = $event->result();
    
    if (!$result->isOk()) {
        Log::warning('Infected file attempted uploaded', [
            'report' => $result->toArray() 
        ]);
    }
});
```