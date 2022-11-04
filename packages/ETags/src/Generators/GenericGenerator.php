<?php

namespace Aedart\ETags\Generators;

use Aedart\ETags\Exceptions\UnableToGenerateETag;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

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

        return match (true) {
            is_string($content) => $content,
            is_numeric($content) || is_bool($content) => (string) $content,
            is_array($content) => serialize($content),
            $content instanceof Arrayable => serialize($content->toArray()),
            $content instanceof Jsonable => $content->toJson(),
            default => throw new UnableToGenerateETag(sprintf('Unable to resolve content: %s', var_export($content, true)))
        };
    }
}