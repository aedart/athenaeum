<?php

namespace Aedart\MimeTypes\Drivers;

use Aedart\Contracts\MimeTypes\Sampler;
use Aedart\MimeTypes\Exceptions\FailedToReadStreamSample;
use Aedart\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\MimeTypes\Exceptions\UnsupportedSampleData;
use Aedart\Utils\Arr;
use InvalidArgumentException;

/**
 * Base Sampler
 *
 * Abstraction for Samplers (drivers).
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\MimeTypes\Drivers
 */
abstract class BaseSampler implements Sampler
{
    /**
     * Sample size in bytes
     *
     * @var int
     */
    protected int $sampleSize = 0;

    /**
     * Cached sample data
     *
     * @var string|null
     */
    protected string|null $cachedSample = null;

    /**
     * Creates a new sampler instance
     *
     * @param  string|resource $data
     * @param  array  $options  [optional]
     */
    public function __construct(
        protected $data,
        protected array $options = []
    )
    {}

    /**
     * @inheritDoc
     */
    public function getSampleData(): string
    {
        if (isset($this->cachedSample)) {
            return $this->cachedSample;
        }

        if ($this->mustUseFullDataSample()) {
            $sample = $this->takeSample($this->getRawData());
        } else {
            $sample = $this->takeSample($this->getRawData(), $this->getSampleSize());
        }

        return $this->cachedSample = $sample;
    }

    /**
     * @inheritDoc
     */
    public function getRawData(): mixed
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function setSampleSize(int $size): static
    {
        if ($this->sampleSize < 0) {
            throw new InvalidArgumentException('Negative sample size not allowed. %d provided', $size);
        }

        $this->sampleSize = $size;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSampleSize(): int
    {
        if (!isset($this->sampleSize)) {
            $this->setSampleSize($this->get('sample_size', 0));
        }

        return $this->sampleSize;
    }

    /**
     * Flush evt. previous taken sample
     *
     * @return self
     */
    public function flushSampleData(): static
    {
        $this->cachedSample = null;

        return $this;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Determine if entire data must be used as sample
     *
     * @return bool
     */
    protected function mustUseFullDataSample(): bool
    {
        return $this->getSampleSize() === 0;
    }

    /**
     * Take sample from given data
     *
     * @param  mixed  $data
     * @param  int|null  $length  [optional]
     *
     * @return string
     *
     * @throws MimeTypeDetectionException
     */
    protected function takeSample(mixed $data, int|null $length = null): string
    {
        return match(true) {
            is_string($data) => $this->takeSampleOfString($data, $length),
            is_resource($data) => $this->takeSampleOfStream($data, $length),
            default => throw new UnsupportedSampleData(sprintf('Cannot take sample. Type %s is not supported', gettype($data)))
        };
    }

    /**
     * Returns sample from given string
     *
     * @param  string  $data
     * @param  int|null  $length  [optional]
     *
     * @return string
     */
    protected function takeSampleOfString(string $data, int|null $length = null): string
    {
        return substr($data, 0, $length);
    }

    /**
     * Returns sample from given stream resource
     *
     * @param  resource  $data
     * @param  int|null  $length  [optional]
     * @return string
     *
     * @throws FailedToReadStreamSample
     */
    protected function takeSampleOfStream($data, int|null $length = null): string
    {
        // Ensure stream is seekable
        $seekable = stream_get_meta_data($data)['seekable'] ?? false;
        if (!$seekable) {
            throw new FailedToReadStreamSample('Resource must be seekable and readable');
        }

        // Obtain current position, so that cursor can be restored.
        $originalPosition = ftell($data);

        // Take the sample...
        $sample = stream_get_contents($data, $length, 0);
        if ($sample === false) {
            throw new FailedToReadStreamSample('Resource is either not readable or otherwise invalid');
        }

        // Restore original position
        $result = fseek($data, $originalPosition, SEEK_SET);
        if ($result === -1) {
            throw new FailedToReadStreamSample('Failed to restore resource position');
        }

        // Finally, return the sample
        return $sample;
    }

    /**
     * Get option value
     *
     * @param  string  $key
     * @param  mixed|null  $default  [optional]
     *
     * @return mixed
     */
    protected function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->options, $key, $default);
    }
}
