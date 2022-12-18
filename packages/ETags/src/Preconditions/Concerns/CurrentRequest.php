<?php

namespace Aedart\ETags\Preconditions\Concerns;

use Illuminate\Http\Request;

/**
 * Concerns Current Precondition Request
 *
 * @see \Aedart\Contracts\ETags\Preconditions\HasRequest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Preconditions\Concerns
 */
trait CurrentRequest
{
    /**
     * The current request
     *
     * @var Request
     */
    protected Request $request;

    /**
     * Set the request
     *
     * @param Request $request
     *
     * @return self
     */
    public function setRequest($request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the request
     *
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Alias for {@see getRequest()}
     *
     * @return Request
     */
    public function request()
    {
        return $this->getRequest();
    }
}