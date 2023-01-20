<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

/**
 * Concerns Record Existence
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Http\Api\Requests\Concerns
 */
trait RecordExistence
{
    /**
     * Verifies that all requested records are found or fails
     *
     * @param string[]|int[] $requested List of unique identifiers
     * @param Collection<Model> $found Collection of found records
     * @param string $matchKey Key to match from found records (model key)
     * @param string $targetsKey Property in requested payload that contain
     *                           "targets" (unique identifiers) to match
     *
     * @return Collection<Model>
     *
     * @throws ValidationException
     */
    public function verifyAllRecordsFound(
        array $requested,
        Collection $found,
        string $matchKey,
        string $targetsKey
    ): Collection {
        // When the amount found matches amount requested, then we assume that all were
        // found. Might not be the most correct, but should be fast...
        if ($found->count() === count($requested)) {
            return $found;
        }

        // Otherwise, the difference must be identified and exception thrown.
        $foundValues = $found->pluck($matchKey)->toArray();
        $difference = array_diff($requested, $foundValues);

        $errors = [];
        foreach ($difference as $notFound) {
            $index = array_search($notFound, $requested);
            if ($index === false) {
                $index = $notFound;
            }

            $errors["{$targetsKey}.{$index}"] = $this->makeRecordNotFoundMessage($notFound, $index);
        }

        throw ValidationException::withMessages($errors);
    }

    /**
     * Returns a "record not found" error message
     *
     * @param string|int $target
     * @param string|int $index
     *
     * @return string
     */
    protected function makeRecordNotFoundMessage(string|int $target, string|int $index): string
    {
        $key = 'athenaeum-http-api::api-resources.record_not_found';

        return Lang::get($key, [ 'record' => $target ]);
    }
}