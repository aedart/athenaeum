<?php

namespace Aedart\Config\Parsers\Files;

use Aedart\Config\Parsers\Exceptions\UnableToParseFile;
use Throwable;
use Yosymfony\Toml\Toml as TomlParser;

/**
 * Toml (Tom's Obvious, Minimal Language) Configuration File Parser
 *
 * @see https://github.com/toml-lang/toml
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Parsers\Files
 */
class Toml extends ParserBase
{
    /**
     * @inheritDoc
     */
    public static function getFileType(): string
    {
        return 'toml';
    }

    /**
     * @inheritDoc
     */
    public function parse(string $content): array
    {
        try {
            return TomlParser::parse($content);
        } catch (Throwable $e) {
            throw new UnableToParseFile($e->getMessage(), $e->getCode(), $e);
        }
    }
}
