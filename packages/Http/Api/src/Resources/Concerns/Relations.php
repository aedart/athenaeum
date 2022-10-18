<?php

namespace Aedart\Http\Api\Resources\Concerns;

use Aedart\Contracts\Http\Api\Resources\Relations\Exceptions\RelationReferenceException;
use Aedart\Contracts\Http\Api\Resources\Relations\RelationReference;
use Aedart\Http\Api\Resources\Relations\BelongsTo;
use Illuminate\Http\Request;

/**
 * Concerns Relations
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Concerns
 */
trait Relations
{
    /**
     * Creates a new relation reference that formats a "belongs to" model relation
     *
     * @param  string  $relation
     *
     * @return BelongsTo
     */
    public function belongsToReference(string $relation): BelongsTo
    {
        return new BelongsTo($this, $relation);
    }

    /**
     * Resolves relation references in given payload
     *
     * @param  array  $payload
     * @param  Request  $request
     *
     * @return array
     *
     * @throws RelationReferenceException
     */
    protected function resolveRelations(array $payload, Request $request): array
    {
        $output = [];

        foreach ($payload as $key => $value) {

            if (is_array($value)) {
                $output[$key] = $this->resolveRelations($value, $request);
                continue;
            }

            if ($value instanceof RelationReference) {
                $output[$key] = $value
                    ->withRequest($request)
                    ->toValue();

                continue;
            }

            $output[$key] = $value;
        }

        return $output;
    }
}