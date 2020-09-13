<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidStatusCodeException;
use Aedart\Contracts\Http\Clients\Responses\Status;
use Psr\Http\Message\ResponseInterface;

/**
 * Concerns Response Status
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait ResponseStatus
{
    /**
     * Creates a new Http Response Status instance from given response
     *
     * @param ResponseInterface $response
     * @return Status
     *
     * @throws InvalidStatusCodeException
     */
    protected function makeResponseStatus(ResponseInterface $response): Status
    {
        return \Aedart\Http\Clients\Responses\ResponseStatus::fromResponse($response);
    }
}
