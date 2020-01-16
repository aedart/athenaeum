<?php

namespace Aedart\Support\Helpers\Http;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;

/**
 * Request Trait
 *
 * @see \Aedart\Contracts\Support\Helpers\Http\RequestAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Helpers\Http
 */
trait RequestTrait
{
    /**
     * Http Request instance
     *
     * @var Request|null
     */
    protected ?Request $request = null;

    /**
     * Set request
     *
     * @param Request|null $request Http Request instance
     *
     * @return self
     */
    public function setRequest(?Request $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get request
     *
     * If no request has been set, this method will
     * set and return a default request, if any such
     * value is available
     *
     * @see getDefaultRequest()
     *
     * @return Request|null request or null if none request has been set
     */
    public function getRequest(): ?Request
    {
        if (!$this->hasRequest()) {
            $this->setRequest($this->getDefaultRequest());
        }
        return $this->request;
    }

    /**
     * Check if request has been set
     *
     * @return bool True if request has been set, false if not
     */
    public function hasRequest(): bool
    {
        return isset($this->request);
    }

    /**
     * Get a default request value, if any is available
     *
     * @return Request|null A default request value or Null if no default value is available
     */
    public function getDefaultRequest(): ?Request
    {
        return RequestFacade::getFacadeRoot();
    }
}
