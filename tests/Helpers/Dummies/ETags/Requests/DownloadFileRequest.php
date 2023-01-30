<?php

namespace Aedart\Tests\Helpers\Dummies\ETags\Requests;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Facades\Generator;
use Aedart\ETags\Preconditions\Evaluator;
use Aedart\ETags\Preconditions\Resources\GenericResource;
use Codeception\Configuration;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\File;
use Illuminate\Support\Carbon;

/**
 * Download File Request
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\ETags\Requests
 */
class DownloadFileRequest extends FormRequest
{
    /**
     * The requested resource
     *
     * @var ResourceContext
     */
    public ResourceContext $resource;

    /**
     * Filepath
     *
     * @var string
     */
    public string $path;

    /**
     * Returns validation rules for request
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            // N/A
        ];
    }

    /**
     * @inheritdoc
     */
    protected function prepareForValidation()
    {
        // 1) Find requested file or fail.
        $file = $this->findFileOrFail();

        // 2) Wrap it inside a Resource Context
        $resource = $this->makeResourceContext($file);

        // 3) Evaluate request's preconditions against resource...
        $this->resource = Evaluator::make($this)
            ->evaluate($resource);
    }

    /**
     * Wraps the file into a resource context
     *
     * @param  File  $file
     *
     * @return ResourceContext
     *
     * @throws ETagGeneratorException
     */
    protected function makeResourceContext(File $file): ResourceContext
    {
        $checksum = hash('xxh3', $file->getContent());
        $etag = Generator::makeRaw($checksum);

        return new GenericResource(
            data: $file,
            etag: $etag,
            lastModifiedDate: Carbon::createFromTimestamp($file->getMTime()),
            size: $file->getSize()
        );
    }

    /**
     * Finds requested model or fails
     *
     * @return File
     */
    protected function findFileOrFail(): File
    {
        $requested = $this->route('name');

        $path = static::fullFilePath($requested);

        if (!file_exists($path)) {
            throw new ModelNotFoundException(sprintf('File %s not found', $requested));
        }

        $this->path = $path;

        return new File($path);
    }

    /**
     * Returns full path to test-file
     *
     * @param string $file
     *
     * @return string
     */
    public static function fullFilePath(string $file): string
    {
        $dir = Configuration::dataDir() . 'etags/files';

        return $dir . DIRECTORY_SEPARATOR . $file;
    }
}
