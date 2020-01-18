<?php

namespace Aedart\Http\Clients;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Manager as HttpClientsManager;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Http\Clients\Exceptions\ProfileNotFound;
use Aedart\Support\Helpers\Config\ConfigTrait;

/**
 * Http Clients Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients
 */
class Manager implements HttpClientsManager,
    ConfigAware
{
    use ConfigTrait;

    /**
     * List of created Http Clients
     *
     * @var Client[]
     */
    protected array $clients = [];

    /**
     * {@inheritdoc}
     */
    public function profile(?string $profile = null, array $options = []): Client
    {
        // Resolve requested profile name
        $profile = $profile ?? 'default';

        // Return client if already created
        if(isset($this->clients[$profile])){
            return $this->clients[$profile];
        }

        // Obtain profile configuration
        $configuration = $this->findOrFailConfiguration($profile);
        $driver = $configuration['driver'];
        $options = array_merge_recursive($configuration['options'], $options);

        // Finally, create the Http Client
        return $this->clients[$profile] = new $driver($options);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Find Http Client's profile configuration or fail
     *
     * @param string $profile
     *
     * @return array
     *
     * @throws ProfileNotFoundException
     */
    protected function findOrFailConfiguration(string $profile) : array
    {
        $config = $this->getConfig();
        $key = 'http-clients.profiles.' . $profile;

        if( ! $config->has($key)){
            throw new ProfileNotFound(sprintf('Http Client profile "%s" does not exist', $profile));
        }

        return $config->get($key);
    }
}
