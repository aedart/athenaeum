<?php

namespace Aedart\Contracts\Antivirus;

/**
 * User Resolver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Antivirus\Results
 */
interface UserResolver
{
    /**
     * Returns the user that caused a file scan, if possible
     *
     * @return string|int|null User identifier, e.g. username, email or database id,
     *                     if a user was identified.
     */
    public function resolve(): string|int|null;
}
