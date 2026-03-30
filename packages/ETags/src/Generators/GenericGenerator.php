<?php

namespace Aedart\ETags\Generators;

use Aedart\ETags\Exceptions\UnableToGenerateETag;
use Aedart\Utils\Json;
use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use JsonSerializable;
use Stringable;

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
    public function resolveContent(mixed $content, bool $weak = true): string
    {
        // Note: This generator ignores the "weak" flag - it treats all content
        // in the same way; it attempts to convert all content into a string...

        return match (true) {
            is_array($content) => implode('', array_map(fn ($value) => $this->resolveContent($value, $weak), $content)),

            is_string($content),
            is_numeric($content),
            $content instanceof Stringable,
            empty($content) => (string) $content,

            is_bool($content) && $content => 'true',
            is_bool($content) && !$content => 'false',

            $content instanceof Arrayable => $this->resolveContent($content->toArray(), $weak),
            $content instanceof DateTimeInterface => $content->format(DateTimeInterface::RFC3339_EXTENDED),
            $content instanceof Jsonable => $content->toJson(),
            $content instanceof JsonSerializable => Json::encode($content->jsonSerialize()),

            default => throw new UnableToGenerateETag(sprintf('Unable to resolve content: %s', var_export($content, true)))
        };
    }
}
