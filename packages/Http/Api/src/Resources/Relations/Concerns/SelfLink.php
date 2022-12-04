<?php

namespace Aedart\Http\Api\Resources\Relations\Concerns;

use Aedart\Contracts\Http\Api\Resources\Relations\Exceptions\RelationReferenceException as RelationReferenceExceptionInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Concerns Relation Reference Self Link
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Relations\Concerns
 */
trait SelfLink
{
    /**
     * When true, relation's self link is shown if available
     *
     * @var bool
     */
    protected bool $showSelfLink = false;

    /**
     * Display name of the key to show relation's self-link
     *
     * @var string
     */
    protected string $selfLinkDisplayName = 'self';

    /**
     * Set whether relation's self link should be included in
     * reference's value output, or not
     *
     * @param  bool  $show  [optional]
     *
     * @return self
     */
    public function withSelfLink(bool $show = true): static
    {
        $this->showSelfLink = $show;

        return $this;
    }

    /**
     * Ensures that relation's self link is not included in
     * reference's value output
     *
     * @return self
     */
    public function withoutSelfLink(): static
    {
        return $this->withSelfLink(false);
    }

    /**
     * Determine if relation's self link should be included in
     * reference's value output, or not
     *
     * @return bool
     */
    public function mustShowSelfLink(): bool
    {
        return $this->showSelfLink;
    }

    /**
     * Set the display name of the key to show relation's self-link
     *
     * @param  string  $name  [optional]
     *
     * @return self
     */
    public function setSelfLinkDisplayName(string $name = 'self'): static
    {
        $this->selfLinkDisplayName = $name;

        return $this;
    }

    /**
     * Returns the display name of the key to show relation's self-link
     *
     * @return string
     */
    public function getSelfLinkDisplayName(): string
    {
        return $this->selfLinkDisplayName;
    }

    /**
     * Adds self link in output for relation, if needed
     *
     * @param  array  $output
     * @param  Model  $relation
     * @param  static  $relationReference
     *
     * @return array
     *
     * @throws RelationReferenceExceptionInterface
     */
    protected function addSelfLink(array $output, Model $relation, $relationReference): array
    {
        if (!$relationReference->mustShowSelfLink()) {
            return $output;
        }

        // Obtain Api Resource instance that matches the related model
        $resource = $this->findApiResourceOrFail($relation, $relationReference);

        // Get display name for self link
        $displayName = $relationReference->getSelfLinkDisplayName();

        // Resolve self link if possible.
        $link = null;
        $request = $this->getRequest();
        if (isset($request)) {
            $link = $resource->makeSelfLink($request);
        }

        // Finally, add self link to output
        $output[$displayName] = $link;

        return $output;
    }
}
