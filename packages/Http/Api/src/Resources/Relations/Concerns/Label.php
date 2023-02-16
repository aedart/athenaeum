<?php

namespace Aedart\Http\Api\Resources\Relations\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * Concerns Relation Reference Label
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Relations\Concerns
 */
trait Label
{
    /**
     * Ev.t label to show for relation.
     *
     * @var string|callable|null
     */
    protected $label = null;

    /**
     * Display name of the key to show relation's label
     *
     * @var string
     */
    protected string $labelDisplayName = 'name';

    /**
     * Set the attribute to use a relation's display name, or label.
     * Or specify a callback that creates a label.
     *
     * @param  string|callable|null  $attribute  [optional]
     *
     * @return self
     */
    public function withLabel(string|callable|null $attribute = null): static
    {
        $this->label = $attribute;

        return $this;
    }

    /**
     * Show this relation reference without any display name or label
     *
     * @return self
     */
    public function withoutLabel(): static
    {
        return $this->withLabel(null);
    }

    /**
     * Determine if a label must be shown for relation reference
     *
     * @return bool
     */
    public function mustShowLabel(): bool
    {
        return isset($this->label);
    }

    /**
     * Returns attribute name, or callback, to be used as display name or label
     *
     * @return string|callable|null
     */
    public function getLabel(): string|callable|null
    {
        return $this->label;
    }

    /**
     * Set label's display name
     *
     * @param  string  $name  [optional]
     *
     * @return self
     */
    public function setLabelDisplayName(string $name = 'name'): static
    {
        $this->labelDisplayName = $name;

        return $this;
    }

    /**
     * Get label's display name
     *
     * @return string
     */
    public function getLabelDisplayName(): string
    {
        return $this->labelDisplayName;
    }

    /**
     * Adds display label in output, if needed
     *
     * @param  array  $output
     * @param  Model  $relation
     * @param  static $relationReference
     *
     * @return array
     */
    protected function addLabel(array $output, Model $relation, $relationReference): array
    {
        if (!$relationReference->mustShowLabel()) {
            return $output;
        }

        $displayName = $relationReference->getLabelDisplayName();
        $label = $relationReference->getLabel();

        // When label is a string, we assume that it's an attribute in related model
        if (is_string($label)) {
            $output[$displayName] = $relation->{$label};
        } elseif (is_callable($label)) {
            $output[$displayName] = $label($relation, $relationReference);
        }

        return $output;
    }
}
