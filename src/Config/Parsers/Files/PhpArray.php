<?php

namespace Aedart\Config\Parsers\Files;

use Aedart\Config\Parsers\Exceptions\UnableToParseFile;
use Throwable;

/**
 * PHP-Array Configuration File Parser
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Parsers\Files
 */
class PhpArray extends ParserBase
{
    /**
     * {@inheritdoc}
     */
    public static function getFileType(): string
    {
        return 'php';
    }

    /**
     * @inheritdoc
     */
    public function loadAndParse() : array
    {
        if (!$this->hasFilePath()) {
            throw new UnableToParseFile('No file path has been specified');
        }

        return $this->parse($this->getFilePath());
    }

    /**
     * @inheritdoc
     */
    public function parse(string $content) : array
    {
        try{
            $fileContent = require $content;

            if (!is_array($fileContent)) {
                throw new UnableToParseFile(sprintf('Cannot parse %s, content is not a PHP array', $content));
            }

            return $fileContent;
        } catch (Throwable $e) {
            throw new UnableToParseFile(sprintf('Unable to load and parse %s', $content));
        }
    }
}
