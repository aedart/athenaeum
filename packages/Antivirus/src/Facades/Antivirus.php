<?php

namespace Aedart\Antivirus\Facades;

use Aedart\Contracts\Antivirus\Manager;
use Aedart\Contracts\Antivirus\Results\ScanResult;
use Aedart\Contracts\Antivirus\Scanner;
use Aedart\Contracts\Streams\FileStream;
use Illuminate\Support\Facades\Facade;
use Psr\Http\Message\StreamInterface as PsrStream;
use Psr\Http\Message\UploadedFileInterface as PsrUploadedFile;
use SplFileInfo;

/**
 * Antivirus Facade
 *
 * @method static ScanResult scan(string|SplFileInfo|PsrUploadedFile|FileStream|PsrStream $file) Scan a single file for infections
 * @method static bool isClean(string|SplFileInfo|PsrUploadedFile|FileStream|PsrStream $file) Determine if file is clean (not infected)
 * @method static Scanner profile(string|null $name = null, array $options = []) Creates a new antivirus scanner instance or returns existing
 * @method static Scanner scanner(string|null $driver = null, array $options = []) Creates a new antivirus scanner instance
 *
 * @see Manager
 * @see Scanner
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus\Facades
 */
class Antivirus extends Facade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor(): string
    {
        return Manager::class;
    }
}
