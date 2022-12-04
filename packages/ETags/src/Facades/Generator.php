<?php

namespace Aedart\ETags\Facades;

use Aedart\Contracts\ETags\Factory;
use Illuminate\Support\Facades\Facade;

/**
 * ETag Generator Facade
 *
 * @method static \Aedart\Contracts\ETags\ETag make(mixed $content, bool $weak = true)
 * @method static \Aedart\Contracts\ETags\ETag makeWeak(mixed $content)
 * @method static \Aedart\Contracts\ETags\ETag makeStrong(mixed $content)
 * @method static \Aedart\Contracts\ETags\Collection parse(string $rawHeaderValue)
 * @method static \Aedart\Contracts\ETags\ETag parseSingle(string $value)
 * @method static \Aedart\Contracts\ETags\ETag makeRaw(string $rawValue, bool $isWeak = false)
 * @method static \Aedart\Contracts\ETags\Generator profile(string|null $profile = null, array $options = [])
 * @method static \Aedart\Contracts\ETags\Generator generator(string|null $driver = null, array $options = [])
 * @method static string defaultGenerator()
 *
 * @see \Aedart\ETags\Factory
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Facades
 */
class Generator extends Facade
{
    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }
}
