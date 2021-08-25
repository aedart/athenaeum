<?php

namespace Aedart\Redmine\Partials;

use Aedart\Contracts\Utils\Populatable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * List Of References
 *
 * @see \Aedart\Redmine\Partials\Reference
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Redmine\Partials
 */
class ListOfReferences implements Populatable,
    Arrayable
{
    /**
     * Actual list of references
     *
     * @var Reference[]
     */
    protected array $references = [];

    /**
     * ListOfReferences
     *
     * @param array|Reference[] $references
     */
    public function __construct(array $references = [])
    {
        $this->populate($references);
    }

    /**
     * @inheritDoc
     */
    public function populate(array $data = []): void
    {
        $this->references = array_map(function($reference) {
            if ($reference instanceof Reference) {
                return $reference;
            }

            return Reference::makeNew($reference);
        }, $data);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->references;
    }
}