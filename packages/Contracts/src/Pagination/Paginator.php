<?php

namespace Aedart\Contracts\Pagination;

use LogicException;

/**
 * Paginator
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Pagination
 */
interface Paginator
{
    /**
     * Set total amount of results
     *
     * @param int $total
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setTotal(int $total): static;

    /**
     * Set amount shown per page
     *
     * @param int $limit
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setLimit(int $limit): static;

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
    public function show(int $amount): static;

    /**
     * Set the offset that corresponds to the given page number
     *
     * @param int $page
     *
     * @return self
     *
     * @throws LogicException
     */
    public function setPage(int $page): static;

    /**
     * Total amount of results
     *
     * @return int
     */
    public function total(): int;

    /**
     * Amount of results per page
     *
     * @return int
     */
    public function limit(): int;

    /**
     * Alias for {@see limit()}
     *
     * @return int
     */
    public function perPage(): int;

    /**
     * Returns the results offset
     *
     * @return int
     */
    public function offset(): int;

    /**
     * Current page number
     *
     * @return int
     */
    public function currentPage(): int;

    /**
     * First results page
     *
     * @return int
     */
    public function firstPage(): int;

    /**
     * Last page number (total amount of pages)
     *
     * @return int
     */
    public function lastPage(): int;

    /**
     * Previous page number
     *
     * @return int|null Page number or null if there is no previous page
     */
    public function previousPage(): int|null;

    /**
     * Next page number
     *
     * @return int|null Page number or null if there is no next page
     */
    public function nextPage(): int|null;

    /**
     * Determine if there is a previous page with results
     *
     * @return bool
     */
    public function hasPreviousPage(): bool;

    /**
     * Determine if there is a next page with results
     *
     * @return bool
     */
    public function hasNextPage(): bool;

    /**
     * Offset for the previous page
     *
     * If there is no previous page, then the first page's offset
     * is returned.
     *
     * @return int
     */
    public function previousPageOffset(): int;

    /**
     * Offset for the next page
     *
     * If there is no next page, then the last page's offset
     * is returned.
     *
     * @return int
     */
    public function nextPageOffset(): int;

    /**
     * Returns offset for given page number
     *
     * @param int $page
     *
     * @return int
     *
     * @throws LogicException
     */
    public function offsetForPage(int $page): int;
}
