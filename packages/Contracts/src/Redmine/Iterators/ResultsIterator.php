<?php

namespace Aedart\Contracts\Redmine\Iterators;

use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Redmine\ApiResource;
use Countable;
use Iterator;

/**
 * Results Iterator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Redmine\Iterators
 */
interface ResultsIterator extends Iterator,
    Countable
{
    /**
     * The API Resource in question
     *
     * @return ApiResource
     */
    public function resource(): ApiResource;

    /**
     * The request builder used by this iterator
     *
     * @return Builder
     */
    public function request(): Builder;
}
