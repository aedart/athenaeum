<?php

namespace Aedart\Http\Api\Requests\Concerns;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

/**
 * Concerns Record Existence
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
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
     * @param string $targetsKey [optional] Property in requested payload that contain
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
        string $targetsKey = 'targets'
    ): Collection {

        // If by any change nothing is requested, then just skip the rest and
        // return what was found, if anything at all...
        if (empty($requested)) {
            return $found;
        }

        // Obtain the found records' identifiers - the matching key
        $foundIdentifiers = $found
            ->pluck($matchKey)
            ->toArray();

        // Compute the difference between requested and found. If there is no
        // difference, then all requested records are found...
        $difference = array_diff($requested, $foundIdentifiers);
        if ($found->count() === count($requested) && empty($difference)) {
            return $found;
        }

        // Otherwise it means that at least one requested identifier was not
        // part of the found identifiers list. A validation exception must
        // therefore be thrown, with not found identifier(s).

        $errors = [];
        foreach ($difference as $notFound) {
            $index = array_search($notFound, $requested);

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
