<?php

namespace Aedart\Contracts\Support\Helpers\Hashing;

use Illuminate\Contracts\Hashing\Hasher;

/**
 * Hash Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Hashing
 */
interface HashAware
{
    /**
     * Set hash
     *
     * @param Hasher|null $hasher Hasher instance
     *
     * @return self
     */
    public function setHash(Hasher|null $hasher): static;

    /**
     * Get hash
     *
     * If no hash has been set, this method will
     * set and return a default hash, if any such
     * value is available
     *
     * @see getDefaultHash()
     *
     * @return Hasher|null hash or null if none hash has been set
     */
    public function getHash(): Hasher|null;

    /**
     * Check if hash has been set
     *
     * @return bool True if hash has been set, false if not
     */
    public function hasHash(): bool;

    /**
     * Get a default hash value, if any is available
     *
     * @return Hasher|null A default hash value or Null if no default value is available
     */
    public function getDefaultHash(): Hasher|null;
}
