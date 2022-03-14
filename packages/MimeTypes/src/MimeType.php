<?php

namespace Aedart\MimeTypes;

use Aedart\Contracts\MimeTypes\MimeType as MimeTypeInterface;
use Aedart\Contracts\MimeTypes\Sampler;
use Aedart\Utils\Arr;
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
     * In-memory cache of information
     *
     * @var array
     */
    protected array $cache;

    /**
     * Creates a new mime-type instances
     *
     * @param  Sampler  $sampler
     */
    public function __construct(
        protected Sampler $sampler
    ) {
        $this->flush();
    }

    /**
     * @inheritDoc
     */
    public function type(): string|null
    {
        return $this->remember('type', fn() => $this->sampler()->detectMimetype());
    }

    /**
     * @inheritDoc
     */
    public function encoding(): string|null
    {
        return $this->remember('encoding', fn() => $this->sampler()->detectEncoding());
    }

    /**
     * @inheritDoc
     */
    public function mime(): string|null
    {
        return $this->remember('mime', fn() => $this->sampler()->detectMime());
    }

    /**
     * @inheritDoc
     */
    public function knownFileExtensions(): array
    {
        return $this->remember('known_extensions', fn() => $this->sampler()->detectFileExtensions());
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
            dump($e->getMessage());
        }

        return array_merge($data, [
            'sampler' => $this->sampler()::class
        ]);
    }

    /**
     * Flush internal cached values
     *
     * @return self
     */
    public function flush(): static
    {
        $this->cache = [];

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Get value from cache, or execute callback and store value
     *
     * @param  string  $key
     * @param  callable  $callback
     *
     * @return mixed
     */
    protected function remember(string $key, callable $callback): mixed
    {
        $value = Arr::get($this->cache, $key);
        if (isset($value)) {
            return $value;
        }

        $value = $callback($this);

        Arr::set($this->cache, $key, $value);

        return $value;
    }
}
