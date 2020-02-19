<?php

namespace Aedart\Config\Parsers\Files;

use Aedart\Config\Parsers\Exceptions\UnableToParseFile;
use Symfony\Component\Yaml\Yaml as SymfonyYamlParser;
use Throwable;

/**
 * Yaml Configuration File Parser
 *
 * @see https://en.wikipedia.org/wiki/YAML
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Parsers\Files
 */
class Yaml extends ParserBase
{
    /**
     * {@inheritdoc}
     */
    public static function getFileType(): string
    {
        return 'yml';
    }

    /**
     * {@inheritdoc}
     */
    public function parse(string $content): array
    {
        try {
            return SymfonyYamlParser::parse($content, SymfonyYamlParser::PARSE_EXCEPTION_ON_INVALID_TYPE);
        } catch (Throwable $e) {
            throw new UnableToParseFile($e->getMessage(), $e->getCode(), $e);
        }
    }
}
