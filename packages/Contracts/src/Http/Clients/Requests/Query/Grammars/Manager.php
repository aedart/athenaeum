<?php

namespace Aedart\Contracts\Http\Clients\Requests\Query\Grammars;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;

/**
 * Http Query Grammar Manager
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests\Query\Grammars
 */
interface Manager
{
    /**
     * Create or obtain a Http Query Grammar
     *
     * @param string|null $profile [optional] Name of Http Query Grammar profile to obtain or create
     * @param array $options [optional] Options for Grammar
     *
     * @return Grammar
     *
     * @throws ProfileNotFoundException
     */
    public function profile(string|null $profile = null, array $options = []): Grammar;
}
