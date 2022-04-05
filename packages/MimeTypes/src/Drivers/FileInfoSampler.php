<?php

namespace Aedart\MimeTypes\Drivers;

use Aedart\MimeTypes\Exceptions\MimeTypeDetectionException;
use finfo;
use Throwable;

/**
 * File-Info Sampler
 *
 * On linux, using the PHP File Extension is almost the equivalent to invoking
 * the following commands in terminal:
 *
 * ```shell
 * # mime-type and encoding
 * file -i -p [your-file.txt]
 *
 * # list of known file extensions
 * file -p --extension [your-file.txt]
 * ```
 *
 * @see https://www.php.net/manual/en/class.finfo.php
 * @see https://manpages.debian.org/bullseye/file/file.1.en.html
 * @see https://github.com/file/file
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\MimeTypes\Drivers
 */
class FileInfoSampler extends BaseSampler
{
    /**
     * The File-Info instance
     *
     * @var finfo
     */
    protected finfo $driver;

    /**
     * @inheritDoc
     */
    public function getMimeTypeDescription(): string|null
    {
        return $this->fromBuffer($this->getSampleData(), FILEINFO_RAW);
    }

    /**
     * @inheritDoc
     */
    public function detectMimetype(): string|null
    {
        return $this->fromBuffer($this->getSampleData(), FILEINFO_MIME_TYPE);
    }

    /**
     * @inheritDoc
     */
    public function detectEncoding(): string|null
    {
        return $this->fromBuffer($this->getSampleData(), FILEINFO_MIME_ENCODING);
    }

    /**
     * @inheritDoc
     */
    public function detectMime(): string|null
    {
        return $this->fromBuffer($this->getSampleData(), FILEINFO_MIME);
    }

    /**
     * @inheritDoc
     */
    public function detectFileExtensions(): array
    {
        $extension = $this->fromBuffer($this->getSampleData(), FILEINFO_EXTENSION);

        $list = explode('/', $extension);

        // Abort if extensions cannot be determined.
        // `FILEINFO_EXTENSION` returns '???' when unable to detect supported extensions.
        // @see https://www.php.net/manual/en/fileinfo.constants.php
        if (count($list) === 1 && $list[0] === '???') {
            return [];
        }

        return $list;
    }

    /**
     * Returns the underlying driver of this sampler
     *
     * @return finfo
     */
    public function driver(): finfo
    {
        if (!isset($this->driver)) {
            $this->driver = $this->makeDriver();
        }

        return $this->driver;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Returns information about data buffer
     *
     * @see https://www.php.net/manual/en/function.finfo-buffer.php
     *
     * @param  string  $data
     * @param  int  $flags  [optional]
     *
     * @return string|null
     */
    protected function fromBuffer(string $data, int $flags = FILEINFO_NONE): string|null
    {
        $information = $this->driver()->buffer($data, $flags);
        if ($information === false) {
            return null;
        }

        return $information;
    }
    
    /**
     * Creates a new FileInfo instance
     *
     * @return finfo
     */
    protected function makeDriver(): finfo
    {
        try {
            return new finfo(FILEINFO_MIME, $this->magicDatabase());
        } catch (Throwable $e) {
            throw new MimeTypeDetectionException(sprintf('Unable to instantiate File Info: %s', $e->getMessage()), $e->getCode(), $e);
        }
    }

    /**
     * Returns the magic database to be used
     *
     * @see https://www.php.net/manual/en/function.finfo-open.php
     *
     * @return string|null
     */
    protected function magicDatabase(): string|null
    {
        return $this->get('magic_database');
    }
}
