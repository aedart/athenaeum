<?php

namespace Aedart\MimeTypes;

use Aedart\Contracts\MimeTypes\MimeType as MimeTypeInterface;

/**
 * Mime-Type
 *
 * @see \Aedart\Contracts\MimeTypes\MimeType
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\MimeTypes
 */
class MimeType implements MimeTypeInterface
{
    /**
     * Creates a new Mime-Type instance
     *
     * @param  string|null  $description  [optional]
     * @param  string|null  $type  [optional]
     * @param  string|null  $encoding  [optional]
     * @param  string|null  $mime  [optional]
     * @param  array  $extensions  [optional]
     */
    public function __construct(
        protected string|null $description = null,
        protected string|null $type = null,
        protected string|null $encoding = null,
        protected string|null $mime = null,
        protected array $extensions = []
    ) {
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        return !empty($this->type);
    }

    /**
     * @inheritDoc
     */
    public function description(): string|null
    {
        if (is_string($this->description) && empty(trim($this->description))) {
            return null;
        }

        return trim($this->description);
    }

    /**
     * @inheritDoc
     */
    public function type(): string|null
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function encoding(): string|null
    {
        return $this->encoding;
    }

    /**
     * @inheritDoc
     */
    public function mime(): string|null
    {
        return $this->mime;
    }

    /**
     * @inheritDoc
     */
    public function knownFileExtensions(): array
    {
        return $this->extensions;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'description' => $this->description(),
            'mime' => $this->mime(),
            'type' => $this->type(),
            'encoding' => $this->encoding(),
            'known_extensions' => $this->knownFileExtensions(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->type() ?? '';
    }

    /**
     * Debug information
     *
     * @return array
     */
    public function __debugInfo(): array
    {
        return $this->toArray();
    }
}
