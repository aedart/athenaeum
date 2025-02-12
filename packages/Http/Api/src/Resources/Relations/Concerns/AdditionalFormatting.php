<?php

namespace Aedart\Http\Api\Resources\Relations\Concerns;

use Aedart\Contracts\Http\Api\Resources\Relations\Exceptions\RelationReferenceException as RelationReferenceExceptionInterface;
use Aedart\Contracts\Http\Api\Resources\Relations\RelationReference;
use Illuminate\Database\Eloquent\Model;

/**
 * Concerns Relation Reference Additional Formatter
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Relations\Concerns
 */
trait AdditionalFormatting
{
    /**
     * Callback that applies additional formatting
     * to the final relation reference value
     *
     * @var callable|null
     */
    protected $additionalFormattingCallback = null;

    /**
     * Set a callback that applies additional formatting to the final
     * relation reference value
     *
     * **Note**: _Given callback is applied as the last step, after primary key, resource type, self-link,...etc. has
     * been resolved._
     *
     * @param  callable|null  $callback  [optional] Formatted reference value, related {@see Model} and {@see RelationReference}
     *                                   are given as callback arguments. Return value of this callback will be used
     *                                   as this reference's final output value.
     *
     * @return self
     */
    public function withAdditionalFormatting(callable|null $callback = null): static
    {
        $this->additionalFormattingCallback = $callback;

        return $this;
    }

    /**
     * Determine if a callback that applies additional formatting to the final
     * relation reference value
     *
     * @return bool
     */
    public function hasAdditionalFormatting(): bool
    {
        return is_callable($this->additionalFormattingCallback);
    }

    /**
     * Returns evt. callback that applies additional formatting to the final
     * relation reference value
     *
     * @return callable|null
     */
    public function getAdditionalFormattingCallback(): callable|null
    {
        return $this->additionalFormattingCallback;
    }

    /**
     * Applies evt. additional formatting callback
     *
     * @param  array  $output
     * @param  Model  $relation
     * @param  static  $relationReference
     *
     * @return array
     *
     * @throws RelationReferenceExceptionInterface
     */
    protected function applyAdditionalFormatting(array $output, Model $relation, $relationReference): array
    {
        if (!$relationReference->hasAdditionalFormatting()) {
            return $output;
        }

        $callback = $this->getAdditionalFormattingCallback();

        return $callback($output, $relation, $relationReference);
    }
}
