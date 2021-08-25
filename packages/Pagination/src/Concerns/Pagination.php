<?php

namespace Aedart\Pagination\Concerns;

use LogicException;

/**
 * Concerns Pagination
 *
 * @see \Aedart\Contracts\Pagination\Paginator
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Pagination\Concerns
 */
trait Pagination
{
    /**
     * Total amount of results
     *
     * @var int
     */
    protected int $total = 0;

    /**
     * The results limit
     *
     * @var int
     */
    protected int $limit = 0;

    /**
     * Results offset
     *
     * @var int
     */
    protected int $offset = 0;

    /**
     * Set total amount of results
     *
     * @param int $total
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setTotal(int $total)
    {
        if ($total < 0) {
            throw new LogicException(sprintf('Total cannot be negative. %d provided', $total));
        }

        $this->total = $total;

        return $this;
    }

    /**
     * Set amount shown per page
     *
     * @param int $limit
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setLimit(int $limit)
    {
        if ($limit < 1) {
            throw new LogicException(sprintf('Limit cannot be less than 1. %d provided', $limit));
        }

        $this->limit = $limit;

        return $this;
    }

    /**
     * Set amount shown per page
     *
     * (Alias for {@see setLimit()})
     *
     * @param int $amount
     *
     * @return self
     *
     * @throws LogicException
     */
    public function show(int $amount)
    {
        return $this->setLimit($amount);
    }

    /**
     * Set offset
     *
     * @param int $offset
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setOffset(int $offset)
    {
        if ($offset < 0) {
            throw new LogicException(sprintf('Offset cannot be negative. %d provided', $offset));
        }

        $this->offset = $offset;

        return $this;
    }

    /**
     * Set the offset that corresponds to the given page number
     *
     * @param int $page
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setPage(int $page)
    {
        return $this->setOffset(
            $this->offsetForPage($page)
        );
    }

    /**
     * Total amount of results
     *
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * Amount of results per page
     *
     * @return int
     */
    public function limit(): int
    {
        return $this->limit;
    }

    /**
     * Alias for {@see limit()}
     *
     * @return int
     */
    public function perPage(): int
    {
        return $this->limit();
    }

    /**
     * Returns the results offset
     *
     * @return int
     */
    public function offset(): int
    {
        return $this->offset;
    }

    /**
     * Current page number
     *
     * @return int
     */
    public function currentPage(): int
    {
        return (int) floor($this->offset() / $this->limit()) + 1;
    }

    /**
     * First results page
     *
     * @return int
     */
    public function firstPage(): int
    {
        return 1;
    }

    /**
     * Last page number (total amount of pages)
     *
     * @return int
     */
    public function lastPage(): int
    {
        return (int) ceil($this->total() / $this->perPage());
    }

    /**
     * Previous page number
     *
     * @return int|null Page number or null if there is no previous page
     */
    public function previousPage(): ?int
    {
        if ($this->hasPreviousPage()) {
            return $this->currentPage() - 1;
        }

        return null;
    }

    /**
     * Next page number
     *
     * @return int|null Page number or null if there is no next page
     */
    public function nextPage(): ?int
    {
        if ($this->hasNextPage()) {
            return $this->currentPage() + 1;
        }

        return null;
    }

    /**
     * Determine if there is a previous page with results
     *
     * @return bool
     */
    public function hasPreviousPage(): bool
    {
        return $this->currentPage() - 1 >= $this->firstPage();
    }

    /**
     * Determine if there is a next page with results
     *
     * @return bool
     */
    public function hasNextPage(): bool
    {
        return $this->currentPage() + 1 <= $this->lastPage();
    }

    /**
     * Offset for the previous page
     *
     * If there is no previous page, then the first page's offset
     * is returned.
     *
     * @return int
     */
    public function previousPageOffset(): int
    {
        return $this->offsetForPage(max($this->currentPage() - 1, 1));
    }

    /**
     * Offset for the next page
     *
     * If there is no next page, then the last page's offset
     * is returned.
     *
     * @return int
     */
    public function nextPageOffset(): int
    {
        return $this->offsetForPage(min($this->currentPage() + 1, $this->lastPage()));
    }

    /**
     * Returns offset for given page number
     *
     * @param int $page
     *
     * @return int
     *
     * @throws LogicException
     */
    public function offsetForPage(int $page): int
    {
        if ($page < 1) {
            throw new LogicException(sprintf('page cannot be less than 1. %d provided', $page));
        }

        return ($page - 1) * $this->perPage();
    }
}
