---
description: About the Antivirus Package
---

# Introduction

_**Available since** `v7.4.x`_

The Antivirus package provides a "profile-based" approach for scanning files for infections, such as viruses, malware or other harmful code.

```php
use Aedart\Antivirus\Facades\Antivirus;

$result = Antivirus::scan($file);

if (!$result->isOk()) {
    // File may contain harmful code... do something!
}
```

The package also comes with a default validation rule, to prevent upload of infected files.

```php
use Aedart\Antivirus\Validation\Rules\InfectionFreeFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/pictures', function (Request $request) {
    $request->validate([
        'picture' => [
            'required',
            'file',
            new InfectionFreeFile()
        ]
    ]);

    $file = $request->file('picture');

    // ... do something with uploaded file...
});
```