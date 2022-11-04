<?php

namespace Aedart\ETags\Generators;

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

        if (is_array($content)) {
            return serialize($content);
        } elseif ($content instanceof Arrayable) {
            return serialize($content->toArray());
        } elseif ($content instanceof Jsonable) {
            return $content->toJson();
        }

        return (string) $content;
    }
}