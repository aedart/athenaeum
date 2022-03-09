<?php

namespace Aedart\Streams\Locks;

use Aedart\Contracts\Streams\Locks\Factory;
use Aedart\Contracts\Streams\Locks\Lock;
use Aedart\Contracts\Streams\Stream;
use Aedart\Streams\Exceptions\Locks\ProfileNotFound;

/**
 * Lock Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Locks
 */
class LockFactory implements Factory
{
    /**
     * Creates a new lock factory instance
     *
     * @param  array  $profiles  [optional] List of available profiles
     * @param  string  $defaultProfile  [optional] Name of the default profile to use
     */
    public function __construct(
        protected array $profiles = [],
        protected string $defaultProfile = 'default'
    )
    {}

    /**
     * @inheritDoc
     */
    public function create(Stream $stream, ?string $profile = null, array $options = []): Lock
    {
        $profile = $profile ?? $this->defaultProfile;

        // Abort if profile does not exist
        if (!isset($this->profiles[$profile])) {
            throw new ProfileNotFound(sprintf('Lock profile %s does not exist', $profile));
        }

        // Resolve driver class and options
        $driver = $this->profiles[$profile]['driver'];
        $options = array_merge($this->profiles[$profile]['options'], $options);
        
        // Build and return lock instance
        return new $driver($stream, $options);
    }

    /**
     * Set the available lock profiles
     *
     * @param  array  $profiles
     *
     * @return self
     */
    public function usingProfiles(array $profiles): static
    {
        $this->profiles = $profiles;

        return $this;
    }

    /**
     * Set the name of the default lock profile to use
     *
     * @param  string  $name
     *
     * @return self
     */
    public function defaultProfile(string $name): static
    {
        $this->defaultProfile = $name;

        return $this;
    }
}
