<?php

namespace Aedart\ETags\Generators;

/**
 * Generic ETag Generator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Generators
 */
class GenericGenerator extends BaseGenerator
{
    /**
     * @inheritDoc
     */
    public function resolveContent(mixed $content): string
    {
        // Whatever content is given, this generator assumes that
        // it can be cast to a string value...

        return (string) $content;
    }
}