---
description: How to make Custom Scanner
sidebarDepth: 0
---

# Custom

To create a custom scanner, you are required to create two components:

* A driver-specific scan status.
* The actual scanner (_aka. the driver_).

## Scan Status

The scan `Status` component is responsible for parsing / resolving the output or response from an antivirus software or service.
For instance, for an online antivirus service, e.g. like [VirusTotal](https://www.virustotal.com), the API response must be evaluated.
Whereas for a CLI command, the return code must be checked, and so on.

You can create a status component by inheriting from the `BaseStatus` abstraction.

```php
use Aedart\Antivirus\Exceptions\UnsupportedStatusValue;
use Aedart\Antivirus\Results\BaseStatus;
use Illuminate\Contracts\Process\ProcessResult;

class MalwareScanStatus extends BaseStatus
{
    public function resolveValue(mixed $value): ProcessResult
    {
        if (!($value instanceof ProcessResult)) {
            throw new UnsupportedStatusValue('Invalid value type...');
        }

        return $value;
    }

    public function isOk(): bool
    {
        return $this->value()->successful();
    }

    public function __toString()
    {
        $value = $this->value();

        return match(true) {
            $value->successful() => $this->valueWithReason('Clean'),
            default => $this->valueWithReason('Infected'),
        };
    }
}
```

The status component may also hold other antivirus software- or service-specific status related methods.

## Scanner (_driver_)

A scanner (_or driver_) is responsible for passing the file stream on to an actual antivirus scanner, and return an an appropriate `ScanResult` instance. 
Consider the following example:

```php
use Aedart\Antivirus\Scanners\BaseScanner;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Streams\FileStream;
use Illuminate\Process\Factory;
use Illuminate\Support\Facades\Process;
use Acme\Antivirus\MalwareScanStatus;

class MalwareScanner extends BaseScanner
{
    public function scanStream(FileStream $stream): ScanResult
    {
        // Obtain profile specific options (if needed)
        $command = $this->get('command', '/var/lib/anti_malware');

        // Scan the file...
        $nativeResult = $this
            ->driver()
            ->run($command . ' -file ' . $stream->uri());

        // Parse native result into status and return scan result
        return $this->makeScanResult(
            status: $this->makeScanStatus($nativeResult),
            file: $stream,
        );
    }

    protected function statusClass(): string
    {
        return MalwareScanStatus::class;
    }

    protected function makeDriver(): Factory
    {
        return Process::getFacadeRoot();
    }
}
```

## Options

Once you have a status and a scanner component completed, you can add it to your configuration of available antivirus scanner profiles.

```php
return [

    // ...previous not shown...

    /*
    |--------------------------------------------------------------------------
    | Scanner Profiles
    |--------------------------------------------------------------------------
    */

    'profiles' => [

        'virus_total' => [
            'driver' => \Acme\Antivirus\Scanners\VirusTotal::class,
            'options' => [
                'command' => '/var/lib/anti_malware',
                
                // ...etc
            ],
        ],

        // ... other profiles not shown...
    ]
];

```