<?php

namespace Aedart\Support\Helpers\Encryption;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Support\Facades\Crypt;

/**
 * Crypt Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Encryption\CryptAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Encryption
 */
trait CryptTrait
{
    /**
     * Encrypter instance
     *
     * @var Encrypter|null
     */
    protected $crypt = null;

    /**
     * Set crypt
     *
     * @param Encrypter|null $encrypter Encrypter instance
     *
     * @return self
     */
    public function setCrypt(?Encrypter $encrypter)
    {
        $this->crypt = $encrypter;

        return $this;
    }

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
    public function getCrypt(): ?Encrypter
    {
        if (!$this->hasCrypt()) {
            $this->setCrypt($this->getDefaultCrypt());
        }
        return $this->crypt;
    }

    /**
     * Check if crypt has been set
     *
     * @return bool True if crypt has been set, false if not
     */
    public function hasCrypt(): bool
    {
        return isset($this->crypt);
    }

    /**
     * Get a default crypt value, if any is available
     *
     * @return Encrypter|null A default crypt value or Null if no default value is available
     */
    public function getDefaultCrypt(): ?Encrypter
    {
        return Crypt::getFacadeRoot();
    }
}
