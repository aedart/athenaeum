<?php

namespace Aedart\Streams\Locks;

use Aedart\Contracts\Streams\Locks\Factory;
use Aedart\Contracts\Streams\Locks\Lock;
use Aedart\Contracts\Streams\Stream;
use Aedart\Streams\Exceptions\Locks\ProfileNotFound;
use Aedart\Streams\Locks\Drivers\FLockDriver;

/**
 * Lock Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Streams\Locks
 */
class LockFactory implements Factory
{
    /**
     * Fallback profiles, when none given
     *
     * @var array
     */
    protected array $fallbackProfiles = [
        'default' => [
            'driver' => FLockDriver::class,
            'options' => [
                'sleep' => 10_000,
                'fail_on_timeout' => true
            ]
        ]
    ];

    /**
     * Creates a new lock factory instance
     *
     * @param  array  $profiles  [optional] List of available profiles
     * @param  string  $defaultProfile  [optional] Name of the default profile to use
     */
    public function __construct(
        protected array $profiles = [],
        protected string $defaultProfile = 'default'
    ) {
        // Set fallback profiles, when none available
        if (empty($this->profiles)) {
            $this->usingProfiles($this->fallbackProfiles);
        }
    }

    /**
     * @inheritDoc
     */
    public function create(Stream $stream, string|null $profile = null, array $options = []): Lock
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
