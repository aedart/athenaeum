# Athenaeum Antivirus

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

## Supported Scanners

* [ClamAV](https://www.clamav.net/)
* Null Scanner (_for testing purposes_)
* (_Your custom scanner_)

## Documentation

Please read the [official documentation](https://aedart.github.io/athenaeum/) for additional information.

## Repository

The mono repository is located at [github.com/aedart/athenaeum](https://github.com/aedart/athenaeum)

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
