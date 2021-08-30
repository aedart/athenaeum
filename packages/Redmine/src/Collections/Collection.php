<?php

namespace Aedart\Redmine\Collections;

use Aedart\Contracts\Redmine\Resource;
use Illuminate\Support\Collection as BaseCollection;

/**
 * Resource Collection
 *
 * Contains one or more Redmine API Resources.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Collections
 */
class Collection extends BaseCollection
{
    /**
     * Class path to the type of resource this collection
     * contains
     *
     * @var string|null
     */
    public ?string $resourceClass = null;

    /**
     * @inheritDoc
     */
    public function __construct($items = [], ?string $resourceClass = null)
    {
        parent::__construct($items);

        $this->resourceClass = $resourceClass;
    }

    /**
     * Creates a new collection of Redmine API Resources, from given response payload
     *
     * @param array $payload Decoded response payload
     * @param Resource $resource The type of resource new collection must consist of
     *
     * @return Collection<Resource>
     *
     * @throws \Throwable
     */
    public static function fromResponsePayload(array $payload, Resource $resource): Collection
    {
        $list = $resource->extractFromPayload($resource->resourceName(), $payload);

        $resources = array_map(function ($item) use ($resource) {
            return $resource::make($item, $resource->getConnection());
        }, $list);

        return new static($resources, get_class($resource));
    }
}
