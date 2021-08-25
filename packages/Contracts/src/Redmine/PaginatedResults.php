<?php

namespace Aedart\Contracts\Redmine;

use Aedart\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Enumerable;
use IteratorAggregate;
use JsonSerializable;
use Psr\Http\Message\ResponseInterface;
use Stringable;

/**
 * Paginated Results
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Contracts\Redmine
 */
interface PaginatedResults extends Paginator,
    IteratorAggregate,
    Arrayable,
    Jsonable,
    JsonSerializable,
    Stringable
{
    /**
     * Creates a new paginated results set, from given response
     *
     * @param ResponseInterface $response
     * @param \Aedart\Redmine\RedmineResource $resource
     *
     * @return static
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public static function fromResponse(ResponseInterface $response, $resource): PaginatedResults;

    /**
     * Returns the result set
     *
     * @return Enumerable
     */
    public function results(): Enumerable;
}
