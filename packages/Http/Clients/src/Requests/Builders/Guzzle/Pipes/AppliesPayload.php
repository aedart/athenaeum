<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Http\Clients\Requests\Attachment;
use Aedart\Http\Clients\Requests\Builders\Guzzle\PayloadData;
use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;
use GuzzleHttp\RequestOptions;

/**
 * Applies Payload onto the Request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class AppliesPayload
{
    /**
     * Sets the request's payload data, via the options
     *
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     */
    public function handle(ProcessedOptions $processed, mixed $next): mixed
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
        return match ($format) {
            RequestOptions::JSON, RequestOptions::FORM_PARAMS => $this->jsonOrFormInputData($options, $builder),
            RequestOptions::MULTIPART => $this->attachmentData($options, $builder),
            default => $this->rawPayloadData($options, $builder),
        };
    }

    /**
     * Obtains data json and form input data
     *
     * @param array $options
     * @param Builder $builder
     *
     * @return array
     */
    protected function jsonOrFormInputData(array $options, Builder $builder): array
    {
        return $this->mergeData($options, $builder);
    }

    /**
     * Obtains attachment data, merged with json or form input data
     *
     * @param array $options
     * @param Builder $builder
     *
     * @return array
     */
    protected function attachmentData(array $options, Builder $builder): array
    {
        // Attachments
        $data = array_map(function (Attachment $attachment) {
            return $attachment->toArray();
        }, $builder->getAttachments());

        // Append form input data
        $inputData = $this->mergeData($options, $builder);
        foreach ($inputData as $key => $value) {
            // In case that multipart option might have been used.
            if (!is_string($key)) {
                $data[] = $value;
                continue;
            }

            // Append regular form input data
            $data[] = [
                'name' => $key,
                'contents' => $value
            ];
        }

        // Finally, merge the attachments and form input data
        return $data;
    }

    /**
     * Obtains raw payload data (body)
     *
     * @param array $options
     * @param Builder $builder
     *
     * @return mixed
     */
    protected function rawPayloadData(array $options, Builder $builder)
    {
        // First, try to obtain "raw" payload from given options
        if (!empty($options[RequestOptions::BODY])) {
            return PayloadData::extract($options);
        }

        // Otherwise, default to raw payload from the builder.
        return $builder->getRawPayload();
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
