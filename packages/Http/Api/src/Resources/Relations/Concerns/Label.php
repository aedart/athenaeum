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
     * Name of attribute to be used as reference's
     * display name
     *
     * @var string|null
     */
    protected string|null $labelKeyName = null;

    /**
     * Display name of the key to show relation's label
     *
     * @var string
     */
    protected string $labelDisplayName = 'name';

    /**
     * Set the attribute to use as relations display name or label
     *
     * @param  string|null  $attribute  [optional]
     *
     * @return self
     */
    public function withLabel(string|null $attribute = null): static
    {
        $this->labelKeyName = $attribute;

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
        return isset($this->labelKeyName);
    }

    /**
     * Returns attribute name to be used as display name or label
     *
     * @return string|null
     */
    public function getLabelKeyName(): string|null
    {
        return $this->labelKeyName;
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

        $labelKey = $relationReference->getLabelKeyName();
        $output[$relationReference->getLabelDisplayName()] = $relation->{$labelKey};

        return $output;
    }
}