<?php

namespace Aedart\Http\Api\Resources\Concerns;

use Aedart\Contracts\Http\Api\SelectedFieldsCollection as SelectedFieldsCollectionInterface;
use Aedart\Http\Api\Resources\SelectedFieldsCollection;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Utils\Arr;
use Illuminate\Validation\ValidationException;

/**
 * Concerns Field Selection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Concerns
 */
trait FieldSelection
{
    /**
     * State whether tho throw an exception whenever a
     * "select" field does not exist in the resource's
     * payload.
     *
     * @var bool
     */
    protected bool $shouldFailWhenFieldDoesNotExist = true;

    /**
     * Name of the query parameter that holds
     * fields to be selected
     *
     * @var string
     */
    protected string $selectKeyName = 'select';

    /**
     * Returns only selected fields from given payload
     *
     * @param  array  $payload
     * @param  string[]|null  $fieldsToSelect  [optional] Defaults to captured "select" fields from
     *                                          request's query parameters, when none given
     *
     * @return array
     *
     * @throws ValidationException
     */
    public function onlySelected(array $payload, array|null $fieldsToSelect = null): array
    {
        $fields = $fieldsToSelect ?? $this->fieldsToSelectCollection()->toArray();

        // Skip if no fields specified or captured
        if (empty($fields)) {
            return $payload;
        }

        $output = [];

        // A selected field can be stated using "dot syntax", in which case Laravel's
        // collect()->only() method will not help us. We need to loop through the fields
        // and use the array helpers to select desired fields, from the payload
        foreach ($fields as $key) {

            // When requested field exists, we add it to the output.
            // If not, then an exception is thrown when Api resource
            // requires such.

            $hasField = Arr::has($payload, $key);

            if (!$hasField && $this->shouldFailWhenFieldDoesNotExist) {
                $this->failWhenFieldDoesNotExist($key);
            } elseif ($hasField) {
                $this->addFieldToPayload($key, $payload, $output);
            }
        }

        return $output;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Add field to payload
     *
     * @param  string  $key Select field (or "dot" key)
     * @param  array  $from Payload to take key from
     * @param  array  $to Payload where key must be added to
     *
     * @return void
     */
    protected function addFieldToPayload(string $key, array $from, array &$to): void
    {
        $value = Arr::get($from, $key);

        Arr::set($to, $key, $value);
    }

    /**
     * Throws an exception regarding field that does not exist
     * in this resource's payload.
     *
     * @param  string  $field Field that does not exist
     *
     * @return void
     *
     * @throws ValidationException
     */
    protected function failWhenFieldDoesNotExist(string $field): void
    {
        throw ValidationException::withMessages([
            $this->selectKeyName => sprintf('Field %s does not exist', $field)
        ]);
    }

    /**
     * Returns a collection of captured fields to be selected
     *
     * @see \Aedart\Http\Api\Middleware\CaptureFieldsToSelect
     *
     * @return SelectedFieldsCollection
     */
    protected function fieldsToSelectCollection(): SelectedFieldsCollectionInterface
    {
        return IoCFacade::tryMake(SelectedFieldsCollectionInterface::class, function() {
            return new SelectedFieldsCollection([]);
        });
    }
}