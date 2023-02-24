<?php

namespace Aedart\Antivirus;

use Aedart\Contracts\Antivirus\UserResolver;
use Illuminate\Support\Facades\Auth;

/**
 * Default User Resolver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Antivirus
 */
class DefaultUserResolver implements UserResolver
{
    /**
     * @inheritDoc
     */
    public function resolve(): string|int|null
    {
        $manager = Auth::getFacadeRoot();
        if (!isset($manager)) {
            return null;
        }

        $guard = $manager->guard();

        return $guard?->user()?->getAuthIdentifier();
    }
}
