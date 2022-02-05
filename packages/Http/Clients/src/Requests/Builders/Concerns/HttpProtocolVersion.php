<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;

/**
 * Concerns Http Protocol Version
 *
 * @see Builder
 * @see Builder::useProtocolVersion
 * @see Builder::getProtocolVersion
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait HttpProtocolVersion
{
    /**
     * The Http protocol version
     *
     * @var string
     */
    protected string $httpProtocolVersion = '1.1';

    /**
     * @inheritdoc
     */
    public function useProtocolVersion(string $version): static
    {
        $this->httpProtocolVersion = $version;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getProtocolVersion(): string
    {
        return $this->httpProtocolVersion;
    }
}
