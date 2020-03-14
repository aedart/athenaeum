<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Http\Clients\Requests\Builders\Guzzle\PayloadData;
use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;
use GuzzleHttp\RequestOptions;

/**
 * Resolves Request Payload
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class ResolvesRequestPayload
{
    /**
     * Sets the request's payload data, via the options
     *
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(ProcessedOptions $processed, $next)
    {
        $options = $processed->options();
        $builder = $processed->builder();

        // Determine format
        $format = $options['data_format'] ?? $builder->getDataFormat();

        // Obtain data, based on format
        $data = $this->obtainData($format, $options, $builder);

        // Unset format and data from options
        unset(
            $options['data_format'],
            $options[RequestOptions::BODY],
            $options[RequestOptions::JSON],
            $options[RequestOptions::MULTIPART],
            $options[RequestOptions::FORM_PARAMS],
        );

        // Finally, apply the data
        $options[$format] = $data;
        $processed->setOptions($options);

        return $next($processed);
    }

    /**
     * Obtains the data to be used by the request.
     *
     * @param string $format
     * @param array $options
     * @param Builder $builder
     *
     * @return mixed
     */
    protected function obtainData(string $format, array $options, Builder $builder)
    {
        switch ($format){
            // Array formats
            case RequestOptions::JSON:
            case RequestOptions::FORM_PARAMS:
                return $this->mergeData($options, $builder);

            case RequestOptions::MULTIPART:
                // TODO: Files...
                return null;

            // None-array format, e.g. streams, plain text... etc.
            case RequestOptions::BODY:
            default:
                // First, try to obtain "raw" payload from given options
                if( ! empty($options[RequestOptions::BODY])){
                    return PayloadData::extract($options);
                }

                // Otherwise, default to raw payload from the builder.
                return $builder->getRawPayload();
        }
    }

    /**
     * Returns the array data from options and builder
     *
     * Method will merge the builder's data with that from
     * given options.
     *
     * @param array $options
     * @param Builder $builder
     *
     * @return array
     */
    protected function mergeData(array $options, Builder $builder): array
    {
        return array_merge(
            $builder->getData(),
            PayloadData::extract($options)
        );
    }
}
