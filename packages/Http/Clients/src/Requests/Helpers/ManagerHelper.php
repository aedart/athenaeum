<?php

namespace Aedart\Http\Clients\Requests\Helpers;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Http\Clients\Exceptions\ProfileNotFound;
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
    protected string|null $defaultProfileKey = null;

    /**
     * Location where "profiles" are found in
     * configuration
     *
     * @var string|null
     */
    protected string|null $profilesKey = null;

    /**
     * Resolve the requested profile
     *
     * @param string|null $profile [optional] If none given, then a default
     *                          profile name is resolved
     *
     * @return string
     */
    protected function resolveProfile(string|null $profile = null): string
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

    /**
     * Find profile configuration or fail
     *
     * @param string $profile
     * @param string|null $notFoundMsg [optional] Fail message.
     *
     * @return array
     *
     * @throws ProfileNotFoundException
     */
    protected function findOrFailConfiguration(string $profile, string|null $notFoundMsg = null): array
    {
        if (!isset($this->profilesKey)) {
            throw new ProfileNotFound('Missing profiles-key: location where profiles are found in configuration');
        }

        $config = $this->getConfig();
        $key = $this->profilesKey . '.' . $profile;

        if (!$config->has($key)) {
            $notFoundMsg = $notFoundMsg ?? 'Profile "%s" does not exist';
            throw new ProfileNotFound(sprintf($notFoundMsg, $profile));
        }

        return $config->get($key);
    }
}
