<?php


namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Criteria;

/**
 * Concerns Request Criteria
 *
 * @see Builder
 * @see Builder::applyCriteria
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait RequestCriteria
{
    /**
     * @inheritdoc
     */
    public function applyCriteria(array|Criteria $criteria): static
    {
        if (!is_array($criteria)) {
            $criteria = [ $criteria ];
        }

        /** @var Criteria[] $criteria */
        foreach ($criteria as $criterion) {
            $criterion->apply($this);
        }

        return $this;
    }
}
