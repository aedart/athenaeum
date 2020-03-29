<?php

namespace Aedart\Http\Clients\Requests\Helpers;

use Aedart\Support\Helpers\Config\ConfigTrait;

/**
 * Manager Helper
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Helpers
 */
trait ManagerHelper
{
    use ConfigTrait;

    /**
     * Location where "default" profile name is to be
     * found in configuration
     *
     * @var string|null
     */
    protected ?string $defaultProfileKey = null;

    /**
     * Resolve the requested profile
     *
     * @param string|null $profile [optional] If none given, then a default
     *                          profile name is resolved
     *
     * @return string
     */
    protected function resolveProfile(?string $profile = null): string
    {
        return $profile ?? $this->defaultProfile();
    }

    /**
     * Returns the "default" profile name from the
     * configuration.
     *
     * If no default is available in the configuration, then
     * method will return "default" as profile name
     *
     * @return string
     */
    protected function defaultProfile(): string
    {
        $fallback = 'default';

        if (!isset($this->defaultProfileKey)) {
            return $fallback;
        }

        return $this->getConfig()->get($this->defaultProfileKey, $fallback);
    }
}
