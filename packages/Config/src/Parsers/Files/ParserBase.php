<?php

namespace Aedart\Config\Parsers\Files;

use Aedart\Config\Parsers\Exceptions\FileDoesNotExist;
use Aedart\Config\Parsers\Exceptions\UnableToParseFile;
use Aedart\Contracts\Config\Parsers\Exceptions\FileDoesNotExistException;
use Aedart\Contracts\Config\Parsers\FileParser;
use Aedart\Support\Helpers\Filesystem\FileTrait;
use Throwable;

/**
 * File Parser Base
 *
 * <br />
 *
 * Abstraction for a File Parser.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Parsers\Files
 */
abstract class ParserBase implements FileParser
{
    use FileTrait;

    /**
     * File path that holds configuration
     *
     * @var null|string
     */
    protected string|null $filePath = null;

    /**
     * ParserBase constructor.
     *
     * @param string|null $filePath [optional]
     *
     * @throws FileDoesNotExistException
     */
    public function __construct(string|null $filePath = null)
    {
        if (isset($filePath)) {
            $this->setFilePath($filePath);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setFilePath(string $filePath): static
    {
        if (!is_file($filePath)) {
            throw new FileDoesNotExist(sprintf('%s does not exist', $filePath));
        }

        $this->filePath = $filePath;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilePath(): string|null
    {
        return $this->filePath;
    }

    /**
     * {@inheritdoc}
     */
    public function hasFilePath(): bool
    {
        return isset($this->filePath);
    }

    /**
     * {@inheritdoc}
     */
    public function loadAndParse(): array
    {
        if (!$this->hasFilePath()) {
            throw new UnableToParseFile('No file path has been specified');
        }

        try {
            $content = $this->getFile()->get($this->getFilePath());
        } catch (Throwable $e) {
            throw new UnableToParseFile($e->getMessage(), $e->getCode(), $e);
        }

        return $this->parse($content);
    }
}
