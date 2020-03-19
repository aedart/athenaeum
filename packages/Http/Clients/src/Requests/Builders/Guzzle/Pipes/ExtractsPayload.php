<?php

namespace Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidAttachmentFormatException;
use Aedart\Contracts\Http\Clients\Requests\Attachment;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Http\Clients\Requests\Builders\Guzzle\PayloadData;
use Aedart\Http\Clients\Requests\Builders\ProcessedOptions;
use GuzzleHttp\RequestOptions;
use Throwable;

/**
 * Extracts Payload from driver options
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Guzzle\Pipes
 */
class ExtractsPayload
{
    /**
     * Extracts payload from driver options and applies it onto
     * the builder.
     *
     * @param ProcessedOptions $processed
     * @param mixed $next
     *
     * @return mixed
     *
     * @throws Throwable
     */
    public function handle(ProcessedOptions $processed, $next)
    {
        $options = $processed->options();
        $builder = $processed->builder();

        // Determine format
        //$format = $options['data_format'] ?? $builder->getDataFormat();

        // Obtain data, based on format
        $this->extractAndApplyPayload($options, $builder);

        // Unset format and data from options
        unset(
            $options['data_format'],
            $options[RequestOptions::BODY],
            $options[RequestOptions::JSON],
            $options[RequestOptions::MULTIPART],
            $options[RequestOptions::FORM_PARAMS],
        );

        return $next(
            $processed->setOptions($options)
        );
    }

    /**
     * Extracts data from options and applies it on the
     * given request builder.
     *
     * @param array $options
     * @param Builder $builder
     *
     * @return Builder
     *
     * @throws Throwable
     */
    protected function extractAndApplyPayload(array $options, Builder $builder)
    {
        // Extract data from options
        $data = PayloadData::extract($options);

        // If "body" is populated, then we cannot use other formats and
        // must set the raw payload.
        if(isset($options[RequestOptions::BODY])){
            $builder->withRawPayload($data);
        }

        // Form input
        if(isset($options[RequestOptions::FORM_PARAMS])){
            $builder
                ->formFormat()
                ->withData($data);
        }

        // Json
        if(isset($options[RequestOptions::JSON])){
            $builder
                ->jsonFormat()
                ->withData($data);
        }

        // Multipart (attachments and data)
        if(isset($options[RequestOptions::MULTIPART])){
            $builder->multipartFormat();

            foreach ($data as $key => $entry){
                // Data
                if(is_string($key)){
                    $builder->withData([ $key => $entry ]);
                }

                // Attachment
                if(is_numeric($key) && is_array($entry)){
                    $this->addAttachment($entry, $builder);
                }

                // Otherwise we can't really do anything. It means that
                // kind of invalid format has been proved. For now, we
                // ignore this...
            }
        }

        // Finally, return the builder, with or without any data set,
        // e.g. when no data has been provided via the options.
        return $builder;
    }

    /**
     * Add attachment in builder
     *
     * @see http://docs.guzzlephp.org/en/stable/request-options.html#multipart
     *
     * @param array $entry
     * @param Builder $builder
     *
     * @throws InvalidAttachmentFormatException
     */
    protected function addAttachment(array $entry, Builder $builder)
    {
        $builder->withAttachment($entry['name'], function(Attachment $file) use($entry){
            $contents = $entry['contents'] ?? null;
            $headers = $entry['headers'] ?? [];
            $filename = $entry['filename'] ?? null;

            $file
                ->contents($contents)
                ->headers($headers)
                ->filename($filename);
        });
    }
}