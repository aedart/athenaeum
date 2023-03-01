---
description: How to use Antivirus Scanners
sidebarDepth: 0
---

# How to use

[[TOC]]

## Manager

A `Manager` is responsible for obtaining an antivirus scanner instance.
To obtain the `Manager` instance, you can use `AntivirusManagerTrait`.

```php
use Aedart\Antivirus\Traits\AntivirusManagerTrait;

class FilesController
{
    use AntivirusManagerTrait;
    
    public function index()
    {
        $manager = $this->getAntivirusManager();
        
        // ...remaining not shown...
    }
}
```

## Scanner

Before you can scan a file, you must first obtain a scanner instance from the `Manager`.
This can be achieved via the `profile()` method.

```php
$scanner = $manager->profile(); // Default profile
```

To obtain a scanner for a specific profile, specify the profile's name.  

```php
$scanner = $manager->profile('my-scanner-profile');
```

### Scan a File

The `scan()` method is used for scanning a file for infections, e.g. viruses, malware or other harmful code.
It returns a `ScanResult` instance, which contains a status and few details about what was scanned. 

```php
$result = $scanner->scan('contacts.txt');

print_r($result->toArray());
```

The output of the above shown example can be similar to this:

```
Array
(
    [status] => Infected: Win.Test.EICAR_HDB-1
    [filename] => contacts.txt
    [filepath] => /tmp/phpm7zz6s
    [filesize] => 68
    [datetime] => 2023-03-01T08:15:18.753Z
    [user] => null 
    [details] => Array
        (
            [profile] => default
            [clamav_session_id] => 1
        )
)
```

### Supported Types

The `scan()` method accepts the following types as it's file argument: 

* `string` path to file.
* `SplFileInfo` uploaded file (_e.g. Laravel's [`UploadedFile` instance](https://laravel.com/docs/10.x/http-tests#testing-file-uploads)_).
* `FileStream` [file stream](../streams/README.md).
* `UploadedFileInterface` [PSR-7 uploaded file](https://www.php-fig.org/psr/psr-7/#36-psrhttpmessageuploadedfileinterface) instance.
* `StreamInterface` [PSR-7 stream](https://www.php-fig.org/psr/psr-7/#34-psrhttpmessagestreaminterface) instance.

::: warning Using PSR-7 Components
There is a considerable performance cost, when using `scan()` in combination with PSR components.
Please read the [PSR Uploaded Files & Streams](./psr.md) chapter, before using!
:::

### Result & Status

The `ScanResult` instance can be used to determine if the scanned file was clean.
A scan is **ONLY** considered okay when the following conditions are meet:

* Antivirus has scanned the file.
* No infections were found (_virus, malware,...etc_).
* No scanning failure occurred, e.g. timeout, could not read file, filetype unsupported... etc.

```php
// Determine if file is clean (ok)
if ($result->isOk()) {
    // ... do something when file is clean ...
}

// Or, the Opposite of isOk
if ($result->hasFailed()) {
    // ... take action, e.g. abort the request...
}
```

You can also obtain the result's `Status`, of the scanned file.
The status is always specific to the [scanner driver](./scanners/README.md) and may provide you with more specific details about why a result isn't okay.

```php
$status = $result->status();

// General for all status instances
if ( ! $status->isOk() && $status->hasReason()) {
    echo $status->reason();
    
    // ...etc
}

// ------------------------------------------------------------ //
// Driver specific

// E.g. for ClamAV scanner
if($status->hasInfection() || $status->hasError()) {
    // ...
}
```

### Is File Clean

As an alternative to scanning a file and manually checking the scan result, you can use the `isClean()` method.
It returns `true` if the scanned file is clean.

```php
if ($scanner->isClean('contacts.txt')) {
    // ...
}

// Equivalent to the above...
if ($scanner->scan('contacts.txt')->isOk()) {
    // ...
}
```

## Facade

An alternative way of performing file scans, is by using the  `Antivirus` [Facade](https://laravel.com/docs/10.x/facades).
It allows you to perform a scan directly.

```php
use Aedart\Antivirus\Facades\Antivirus;

$result = Antivirus::scan($file); // Scan using default profile

// Or, check if file is clean...
if (Antivirus::isClean($file)) {
    // ...
}
```

You can also use the facade to obtain a scanner for a specific profile.

```php
$scanner = Antivirus::profile('my-scanner-profile');
```

## Validation Rule

This package also comes with a custom [validation rule](https://laravel.com/docs/10.x/validation#custom-validation-rules), which can prevent upload of infected files.

```php
use Aedart\Antivirus\Validation\Rules\InfectionFreeFile;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/files', function (Request $request) {
    $request->validate([
        'file' => [
            'required',
            'file',
            new InfectionFreeFile()
        ]
    ]);

    $file = $request->file('file');

    // ... do something with uploaded file...
});
```

Unless otherwise specified, the `InfectionFreeFile` rule will use the default scanner profile.
To use a different profile, specify the profile name as the first argument.

```php
$rule = new InfectionFreeFile('my-scanner-profile');
```