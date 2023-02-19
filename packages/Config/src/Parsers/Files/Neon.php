<?php

namespace Aedart\Config\Parsers\Files;

use Aedart\Config\Parsers\Exceptions\UnableToParseFile;
use Nette\Neon\Neon as NeonParser;
use Throwable;

/**
 * NEON (Nette Object Notation) Configuration File Parser
 *
 * @see https://ne-on.org/
 * @see https://github.com/nette/neon
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Parsers\Files
 */
class Neon extends ParserBase
{
    /**
     * @inheritDoc
     */
    public static function getFileType(): string
    {
        return 'neon';
    }

    /**
     * @inheritDoc
     */
    public function parse(string $content): array
    {
        try {
            return NeonParser::decode($content);
        } catch (Throwable $e) {
            throw new UnableToParseFile($e->getMessage(), $e->getCode(), $e);
        }
    }
}
