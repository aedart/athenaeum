<?php

namespace Aedart\MimeTypes;

use Aedart\Contracts\MimeTypes\MimeType as MimeTypeInterface;
use Aedart\Contracts\MimeTypes\Sampler;
use Throwable;

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
     * Creates a new mime-type instances
     *
     * @param  Sampler  $sampler
     */
    public function __construct(protected Sampler $sampler)
    {}

    /**
     * @inheritDoc
     */
    public function type(): string|null
    {
        return $this->sampler()->detectMimetype();
    }

    /**
     * @inheritDoc
     */
    public function encoding(): string|null
    {
        return $this->sampler()->detectEncoding();
    }

    /**
     * @inheritDoc
     */
    public function mime(): string|null
    {
        return $this->sampler()->detectMime();
    }

    /**
     * @inheritDoc
     */
    public function knownFileExtensions(): array
    {
        return $this->sampler()->detectFileExtensions();
    }

    /**
     * @inheritDoc
     */
    public function sampler(): Sampler
    {
        return $this->sampler;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            'mime' => $this->mime(),
            'type' => $this->type(),
            'encoding' => $this->encoding(),
            'known_extensions' => $this->knownFileExtensions(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function __toString()
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
        $data = [
            'mime' => null,
            'type' => null,
            'encoding' => null,
            'known_extensions' => null,
        ];

        try {
            $data = $this->toArray();
        } catch (Throwable $e) {
            // Ignore evt. failure here, so that debug information can be
            // returned.
        }

        return array_merge($data, [
            'sampler' => $this->sampler()::class
        ]);
    }
}
