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
     * @inheritdoc
     */
    public function useDataFormat(string $format): static
    {
        $this->dataFormat = $format;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDataFormat(): string
    {
        return $this->dataFormat;
    }
}
