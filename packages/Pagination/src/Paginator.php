<?php

namespace Aedart\Pagination;

use Aedart\Contracts\Pagination\Paginator as PaginatorInterface;
use Aedart\Pagination\Concerns;

/**
 * Paginator
 *
 * A base class or abstraction for a results set that can be
 * paginated. By it-self, this component is not able to perform
 * actual results pagination - it is only able to provide information
 * about the amount of results, pages, limit and offsets.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Pagination
 */
class Paginator implements PaginatorInterface
{
    use Concerns\Pagination;

    /**
     * Paginator
     *
     * @param int $total
     * @param int $limit [optional]
     * @param int $offset [optional]
     */
    public function __construct(int $total, int $limit = 10, int $offset = 0)
    {
        $this
            ->setTotal($total)
            ->setLimit($limit)
            ->setOffset($offset);
    }
}