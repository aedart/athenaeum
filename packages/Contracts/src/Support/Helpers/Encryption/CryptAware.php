<?php

namespace Aedart\Contracts\Support\Helpers\Encryption;

use Illuminate\Contracts\Encryption\Encrypter;

/**
 * Crypt Aware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Helpers\Encryption
 */
interface CryptAware
{
    /**
     * Set crypt
     *
     * @param Encrypter|null $encrypter Encrypter instance
     *
     * @return self
     */
    public function setCrypt(Encrypter|null $encrypter): static;

    /**
     * Get crypt
     *
     * If no crypt has been set, this method will
     * set and return a default crypt, if any such
     * value is available
     *
     * @see getDefaultCrypt()
     *
     * @return Encrypter|null crypt or null if none crypt has been set
     */
    public function getCrypt(): Encrypter|null;

    /**
     * Check if crypt has been set
     *
     * @return bool True if crypt has been set, false if not
     */
    public function hasCrypt(): bool;

    /**
     * Get a default crypt value, if any is available
     *
     * @return Encrypter|null A default crypt value or Null if no default value is available
     */
    public function getDefaultCrypt(): Encrypter|null;
}
