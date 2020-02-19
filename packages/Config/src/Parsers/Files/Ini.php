<?php

namespace Aedart\Config\Parsers\Files;

use Aedart\Config\Parsers\Exceptions\UnableToParseFile;

/**
 * Ini Configuration File Parser
 *
 * @see http://php.net/manual/en/function.parse-ini-file.php
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Config\Parsers\Files
 */
class Ini extends ParserBase
{
    /**
     * If true, you get multidimensional array, with the
     * section names and settings included
     *
     * @see https://secure.php.net/manual/en/function.parse-ini-string.php
     *
     * @var bool
     */
    protected bool $processSections = true;

    /**
     * Scanner mode
     *
     * @see https://secure.php.net/manual/en/function.parse-ini-string.php
     *
     * @var int
     */
    protected int $scannerMode = INI_SCANNER_TYPED;

    /**
     * {@inheritdoc}
     */
    public static function getFileType(): string
    {
        return 'ini';
    }

    /**
     * {@inheritdoc}
     */
    public function parse(string $content): array
    {
        $result = parse_ini_string($content, $this->processSections, $this->scannerMode);

        if ($result === false) {
            throw new UnableToParseFile(sprintf('ini file "%s" contains errors', $this->getFilePath()));
        }

        return $result;
    }
}
