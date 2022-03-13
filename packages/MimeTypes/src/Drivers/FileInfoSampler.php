<?php

namespace Aedart\MimeTypes\Drivers;

use finfo;

/**
 * File-Info Sampler
 *
 * @see https://www.php.net/manual/en/class.finfo.php
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

        return explode('/', $extension);
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
        return new finfo(FILEINFO_NONE, $this->magicDatabase());
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
