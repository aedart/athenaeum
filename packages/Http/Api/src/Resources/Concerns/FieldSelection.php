<?php

namespace Aedart\Http\Api\Resources\Concerns;

use Aedart\Contracts\Http\Api\SelectedFieldsCollection as SelectedFieldsCollectionInterface;
use Aedart\Http\Api\Resources\SelectedFieldsCollection;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Utils\Arr;

/**
 * Concerns Field Selection
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Concerns
 */
trait FieldSelection
{
    /**
     * Returns only selected fields from given payload
     *
     * @param  array  $payload
     * @param  string[]|null  $fieldsToSelect  [optional] Defaults to captured "select" fields from
     *                                          request's query parameters, when none given
     *
     * @return array
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
            if (Arr::has($payload, $key)) {
                $value = Arr::get($payload, $key);
                Arr::set($output, $key, $value);
            }
        }

        return $output;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

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