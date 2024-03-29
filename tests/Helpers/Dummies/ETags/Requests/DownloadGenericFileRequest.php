<?php

namespace Aedart\Tests\Helpers\Dummies\ETags\Requests;

use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\Resources\GenericResource;
use Aedart\Utils\Memory;
use Aedart\Utils\Str;
use Illuminate\Http\Testing\File as TestFile;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Download Generic File Request
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\ETags\Requests
 */
class DownloadGenericFileRequest extends DownloadFileRequest
{
    /**
     * File size to create
     *
     * @var int Kilobytes
     */
    public static int $fileSize = 6;

    /**
     * The range unit
     *
     * @var string
     */
    public static string $rangeUnit = 'kilobytes';

    /**
     * @inheritdoc
     */
    protected function makeResourceContext(File $file): ResourceContext
    {
        $etag = static::fileEtag($file);

        return GenericResource::forFile(
            file: $file,
            etag: $etag,
            rangeUnit: static::$rangeUnit
        );
    }

    /**
     * @inheritdoc
     */
    protected function findFileOrFail(): File
    {
        $name = $this->route('name');
        $size = static::$fileSize;
        $unit = static::$rangeUnit;

        $content = Str::random(
            Memory::from("{$size} {$unit}")->bytes()
        );

        return TestFile::createWithContent($name, $content);
    }
}
