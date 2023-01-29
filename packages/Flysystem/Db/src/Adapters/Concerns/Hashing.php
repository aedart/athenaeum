<?php

namespace Aedart\Flysystem\Db\Adapters\Concerns;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Streams\Hashing\Hashable;
use League\Flysystem\Config;

/**
 * Concerns Hashing
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Flysystem\Db\Adapters\Concerns
 */
trait Hashing
{
    /**
     * Hashing algorithm to use
     *
     * @var string
     */
    protected string $hashAlgo = 'sha256';

    /**
     * Set the hashing algorithm to be used for file content
     *
     * @see https://www.php.net/manual/en/function.hash
     *
     * @param string $name
     *
     * @return self
     */
    public function setHashAlgorithm(string $name): static
    {
        $this->hashAlgo = $name;

        return $this;
    }

    /**
     * Set the hashing algorithm to be used for file content
     *
     * @see https://www.php.net/manual/en/function.hash
     *
     * @return string
     */
    public function getHashAlgorithm(): string
    {
        return $this->hashAlgo;
    }

    /**
     * Resolve file content's hashing
     *
     * If "hash" is given via `$config`, then that value is returned.
     * Otherwise, the stream content is hashed using adapter's specified
     * hashing algorithm.
     *
     * NOTE: If the config contains a `checksum_algo` (League's default option),
     * then this hashing algorithm will be used instead of this adapter's default.
     *
     * @see setHashAlgorithm
     * @see getHashAlgorithm
     *
     * @param Hashable $stream
     * @param Config|null $config [optional]
     *
     * @return string
     *
     * @throws StreamException
     */
    protected function resolveContentHash(Hashable $stream, Config|null $config = null): string
    {
        $config = $config ?? new Config();

        $hash = $config->get('hash');
        if (isset($hash)) {
            return $hash;
        }

        $algo = $config->get('checksum_algo', $this->getHashAlgorithm());

        return $stream->hash($algo);
    }
}
