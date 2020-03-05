<?php

namespace Aedart\Http\Clients\Drivers;

use Psr\Http\Message\ResponseInterface;

/**
 * Json Http Client
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Drivers
 */
class JsonHttpClient extends DefaultHttpClient
{
    /**
     * @inheritdoc
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this
            ->jsonFormat()
            ->setInitialHeadersIfRequired();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Sets the Accept and Content-Type headers for next request,
     * if not already specified.
     *
     * @return self
     */
    protected function setInitialHeadersIfRequired()
    {
        $headers = [];

        if (!$this->hasInitialHeader('Accept')) {
            $headers['Accept'] = $this->jsonAccept;
        }

        if (!$this->hasInitialHeader('Content-Type')) {
            $headers['Content-Type'] = $this->jsonContentType;
        }

        // Merge into the initial options
        $this->initialOptions['headers'] = $this->initialOptions['headers'] ?? [];
        $this->initialOptions['headers'] = array_merge_recursive($this->initialOptions['headers'], $headers);

        // Ensure that next request has these initial headers set.
        $this->resetOptionsForNextRequest();

        return $this;
    }
}
