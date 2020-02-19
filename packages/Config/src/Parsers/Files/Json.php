<?php

namespace Aedart\Config\Parsers\Files;

use Aedart\Config\Parsers\Exceptions\UnableToParseFile;
use Aedart\Utils\Json as JsonUtil;
use Throwable;

/**
 * Json Configuration File Parser
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Parsers\Files
 */
class Json extends ParserBase
{
    /**
     * {@inheritdoc}
     */
    public static function getFileType(): string
    {
        return 'json';
    }

    /**
     * {@inheritdoc}
     */
    public function parse(string $content): array
    {
        try {
            return JsonUtil::decode($content, true);
        } catch (Throwable $e) {
            throw new UnableToParseFile($e->getMessage(), $e->getCode(), $e);
        }
    }
}
