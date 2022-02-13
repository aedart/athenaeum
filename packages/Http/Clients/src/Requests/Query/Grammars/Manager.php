<?php

namespace Aedart\Http\Clients\Requests\Query\Grammars;

use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammars\Manager as HttpQueryGrammarManager;
use Aedart\Contracts\Support\Helpers\Config\ConfigAware;
use Aedart\Http\Clients\Requests\Helpers\ManagerHelper;

/**
 * Http Query Grammar Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Query\Grammars
 */
class Manager implements
    HttpQueryGrammarManager,
    ConfigAware
{
    use ManagerHelper;

    /**
     * List of created Http Query Grammar instances
     *
     * @var Grammar[]
     */
    protected array $grammars = [];

    /**
     * Manager constructor.
     */
    public function __construct()
    {
        $this->defaultProfileKey = 'http-clients.grammars.default';
        $this->profilesKey = 'http-clients.grammars.profiles';
    }

    /**
     * @inheritDoc
     */
    public function profile(string|null $profile = null, array $options = []): Grammar
    {
        // Resolve requested profile name
        $profile = $this->resolveProfile($profile);

        // Return grammar if already created
        if (isset($this->grammars[$profile])) {
            return $this->grammars[$profile];
        }

        // Obtain profile configuration
        $configuration = $this->findOrFailConfiguration($profile, 'Http Query Grammar profile "%s" does not exist');
        $driver = $configuration['driver'];
        $options = array_merge_recursive($configuration['options'], $options);

        // Finally, create the Http Query Grammar
        return $this->grammars[$profile] = new $driver($options);
    }
}
