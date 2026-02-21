<?php

namespace Aedart\Contracts\Http\Clients\Requests\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammars\GrammarAware;
use DateTimeInterface;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Http Query Builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests\Query
 */
interface Builder extends Identifiers,
    GrammarAware,
    Arrayable
{
    /**
     * Select the fields to be returned
     *
     * Examples:
     *
     * ```php
     * // Select single field
     * $query->select('name');
     *
     * // Select multiple fields
     * $query->select(['name', 'age']);
     *
     * // Select field from a resource
     * $query->select('name', 'person');
     *
     * // Select multiple fields from resources
     * $query->select([
     *      // field => from resource
     *      'name' => 'person',
     *      'income' => 'job'
     * ]);
     * ```
     *
     * @see https://jsonapi.org/format/1.1/#fetching-sparse-fieldsets
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionselect
     *
     * @param string|string[] $field Field or list of fields to select
     * @param string|null $resource [optional] Name of resource from which the fields should be selected.
     *                              Note: this value might be ignored, depending on what {@see Grammar} is
     *                              used.
     *
     * @return self
     */
    public function select(string|array $field, string|null $resource = null): static;

    /**
     * Select a raw expression
     *
     * Examples:
     *
     * ```php
     * // Injects binding values into expression,
     * // e.g. ":number" becomes 42
     * $query->selectRaw('account(:number)', [ 'number' => 42]);
     * ```
     *
     * @param string $expression
     * @param array $bindings [optional] Evt. values to be injected into the raw query string
     *
     * @return self
     */
    public function selectRaw(string $expression, array $bindings = []): static;

    /**
     * Add a "where" condition or filter
     *
     * Examples:
     *
     * ```php
     * // field = value
     * $query->where('name', 'john');
     *
     * // Specific operator
     * $query->where('year', 'gt', 2020);
     *
     * // Multiple where conditions
     * $query->where([
     *      'name' => 'john'
     *      'year' => [ 'gt' => 2020 ]
     * ]);
     * ```
     *
     * @see https://jsonapi.org/format/1.1/#fetching-filtering
     * @see https://jsonapi.org/format/1.1/#query-parameters
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_CommonExpressionSyntax
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionfilter
     *
     * @param string|array $field Name of field or filter. If an array is given, then every entry is treated as a where
     *                            condition.
     * @param mixed $operator [optional] Operator or value
     * @param mixed $value [optional] Value. If omitted, then second argument is considered
     *                      to act as the value.
     *
     * @return self
     */
    public function where(string|array $field, mixed $operator = null, mixed $value = null): static;

    /**
     * Add an "or where" condition or filter
     *
     * CAUTION: Many APIs do not support "or" conjunctions via Http Query strings.
     *
     * @param string|array $field Name of field or filter. If an array is given, then every entry is treated as a where
     *                            condition.
     * @param mixed $operator [optional] Operator or value
     * @param mixed $value [optional] Value. If omitted, then second argument is considered
     *                      to act as the value.
     *
     * @return self
     */
    public function orWhere(string|array $field, mixed $operator = null, mixed $value = null): static;

    /**
     * Add a raw "where" condition or filter
     *
     * Examples:
     *
     * ```php
     * // Injects binding values into expression,
     * // e.g. ":amount" becomes 10
     * $query->whereRaw('filter=Users eq :amount', [ 'amount' => 10]);
     * ```
     *
     * @param string $query Raw query string or filter
     * @param array $bindings [optional] Evt. values to be injected into the raw query string.
     *
     * @return self
     */
    public function whereRaw(string $query, array $bindings = []): static;

    /**
     * Add a raw "or where" condition or filter
     *
     * CAUTION: Many APIs do not support "or" conjunctions via Http Query strings.
     *
     * @param string $query Raw query string or filter
     * @param array $bindings [optional] Evt. values to be injected into the raw query string.
     *
     * @return self
     */
    public function orWhereRaw(string $query, array $bindings = []): static;

    /**
     * Add a "where datetime" condition or filter
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function whereDatetime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Add an "or where datetime" condition or filter
     *
     * CAUTION: Many APIs do not support "or" conjunctions via Http Query strings.
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function orWhereDatetime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Add a "where date" condition or filter
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function whereDate(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Add a "or where date" condition or filter
     *
     * CAUTION: Many APIs do not support "or" conjunctions via Http Query strings.
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function orWhereDate(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Add a "where year" condition or filter
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function whereYear(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Add an "or where year" condition or filter
     *
     * CAUTION: Many APIs do not support "or" conjunctions via Http Query strings.
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function orWhereYear(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Add a "where month" condition or filter
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function whereMonth(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Add an "or where month" condition or filter
     *
     * CAUTION: Many APIs do not support "or" conjunctions via Http Query strings.
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function orWhereMonth(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Add a "where day" condition or filter
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function whereDay(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Add an "or where day" condition or filter
     *
     * CAUTION: Many APIs do not support "or" conjunctions via Http Query strings.
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function orWhereDay(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Add a "where time" condition or filter
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function whereTime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Add a "or where time" condition or filter
     *
     * CAUTION: Many APIs do not support "or" conjunctions via Http Query strings.
     *
     * @param string $field Name of field or filter
     * @param mixed $operator [optional] Operator or value
     * @param string|DateTimeInterface|null $value [optional] If no value given, then current date ('now') is used
     *
     * @return self
     */
    public function orWhereTime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static;

    /**
     * Include one or more related resources in the response
     *
     * Examples:
     *
     * ```php
     * // Include single resource
     * $query->include('job');
     *
     * // Include multiple fields
     * $query->include(['job', 'posts']);
     * ```
     *
     * @see https://jsonapi.org/format/1.1/#fetching-includes
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionexpand
     *
     * @param string|string[] $resource
     *
     * @return self
     */
    public function include(string|array $resource): static;

    /**
     * Limit the amount of results to be returned
     *
     * @see page Page-based pagination
     * @see https://jsonapi.org/format/1.1/#fetching-pagination
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionstopandskip
     *
     * @param int $amount
     *
     * @return self
     */
    public function limit(int $amount): static;

    /**
     * Skip over given amount of results
     *
     * @see page Page-based pagination
     * @see https://jsonapi.org/format/1.1/#fetching-pagination
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionstopandskip
     *
     * @param int $offset
     *
     * @return self
     */
    public function offset(int $offset): static;

    /**
     * Alias for {@see limit}
     *
     * @param int $amount
     *
     * @return self
     */
    public function take(int $amount): static;

    /**
     * Alias for {@see offset}
     *
     * @param int $offset
     *
     * @return self
     */
    public function skip(int $offset): static;

    /**
     * Return result for requested page number
     *
     * Depending on {@see Grammar}, this method might be converted
     * to limit / offset, if page-based pagination isn't supported.
     * Otherwise, it might be omitted.
     *
     * @see https://jsonapi.org/format/1.1/#fetching-pagination
     *
     * @param int $number Page number
     * @param int|null $size [optional] Amount to show per page.
     *                       Must use {@see show} to set page size, if given.
     *
     * @return self
     */
    public function page(int $number, int|null $size = null): static;

    /**
     * Set amount of results to be returned per page
     *
     * Depending on {@see Grammar}, this method might be converted
     * to limit / offset, if page-based pagination isn't supported.
     * Otherwise, it might be omitted.
     *
     * @see https://jsonapi.org/format/1.1/#fetching-pagination
     *
     * @param int|null $amount [optional] Amount of results per page
     *
     * @return self
     */
    public function show(int|null $amount = null): static;

    /**
     * Order results by given field or fields
     *
     * Examples:
     *
     * ```php
     * // Order by name, ascending
     * $query->orderBy('name');
     *
     * // Order by name, descending
     * $query->orderBy('name', 'desc');
     *
     * // Order by multiple fields, each with own sorting order
     * $query->orderBy([
     *      'name' => 'desc',
     *      'age' => 'asc'
     * ]);
     * ```
     *
     * @see https://jsonapi.org/format/1.1/#fetching-sorting
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionorderby
     *
     * @param string|string[] $field Field to order results by
     * @param string $direction [optional] Ascending or descending order
     *
     * @return self
     */
    public function orderBy(string|array $field, string $direction = self::ASCENDING): static;

    /**
     * Add a raw expression
     *
     * Unlike {@see selectRaw} or {@see whereRaw}, this method does NOT prefix,
     * affix or in any way process the expression. The only exception to this,
     * is that binding values MUST be injected into the expression, if any are
     * given.
     *
     * @param string $expression
     * @param array $bindings [optional] Evt. values to be injected into the raw query string
     *
     * @return self
     */
    public function raw(string $expression, array $bindings = []): static;

    /**
     * Build this http query
     *
     * Method MUST use {@see Grammar} provided by the {@see getGrammar}
     * to build an http query, which can be applied on a request
     *
     * @return string Http query string.
     *
     * @throws HttpQueryBuilderException If unable to build http query
     */
    public function build(): string;
}
