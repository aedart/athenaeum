<?php

namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use GuzzleHttp\RequestOptions;

/**
 * Concerns Data Format
 *
 * @see Builder
 * @see Builder::useDataFormat
 * @see Builder::getDataFormat
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait DataFormat
{
    /**
     * The data format to use
     *
     * @var string
     */
    protected string $dataFormat = RequestOptions::FORM_PARAMS;

    /**
     * Use the given data format for the next request
     *
     * @param string $format Driver specific format identifier
     *
     * @return self
     */
    public function useDataFormat(string $format): Builder
    {
        $this->dataFormat = $format;

        return $this;
    }

    /**
     * Get the data format to use for the next request
     *
     * @return string Driver specific format identifier
     */
    public function getDataFormat(): string
    {
        return $this->dataFormat;
    }
}
