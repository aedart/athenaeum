<?php

namespace Aedart\Contracts\Http\Clients\Requests\Query;

/**
 * Http Query Builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Clients\Requests\Query
 */
interface Builder extends Identifiers
{
    /**
     * Select the fields to be returned
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
    public function select($field, ?string $resource = null): self;

    /**
     * Select a raw expression
     *
     * @param string $expression
     * @param array $bindings [optional] Evt. values to be injected into the raw query string
     *
     * @return self
     */
    public function selectRaw($expression, array $bindings = []): self;

    /**
     * Add a "where" condition or filter
     *
     * @see https://jsonapi.org/format/1.1/#fetching-filtering
     * @see https://jsonapi.org/format/1.1/#query-parameters
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_CommonExpressionSyntax
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionfilter
     *
     * @param string|array $field Name of field or list of fields
     * @param mixed $operator [optional] Operator or value
     * @param mixed $value [optional] Value. If omitted, then second argument is considered
     *                      to act as the value.
     *
     * @return self
     */
    public function where($field, $operator = null, $value = null): self;

    /**
     * Add a "or where" condition or filter
     *
     * @see https://jsonapi.org/format/1.1/#fetching-filtering
     * @see https://jsonapi.org/format/1.1/#query-parameters
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_CommonExpressionSyntax
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionfilter
     *
     * @param string|array $field Name of field or list of fields
     * @param mixed $operator [optional] Operator or value
     * @param mixed $value [optional] Value. If omitted, then second argument is considered
     *                      to act as the value.
     *
     * @return self
     */
    public function orWhere($field, $operator = null, $value = null): self;

    /**
     * Add a raw "where" condition or filter
     *
     * @param string $query Raw query string. MUST NOT be url-encoded.
     * @param array $bindings [optional] Evt. values to be injected into the raw query string
     *
     * @return self
     */
    public function whereRaw($query, array $bindings = []): self;

    /**
     * Add a raw "or where" condition or filter
     *
     * @param string $query Raw query string. MUST NOT be url-encoded.
     * @param array $bindings [optional] Evt. values to be injected into the raw query string
     *
     * @return self
     */
    public function orWhereRaw($query, array $bindings = []): self;

    /**
     * Include one or more related resources in the response
     *
     * @see https://jsonapi.org/format/1.1/#fetching-includes
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionexpand
     *
     * @param string|array $resource
     *
     * @return self
     */
    public function include($resource): self;

    /**
     * Limit the amount of results to be returned
     *
     * @see https://jsonapi.org/format/1.1/#fetching-pagination
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionstopandskip
     *
     * @param int $amount
     *
     * @return self
     */
    public function limit(int $amount): self;

    /**
     * Skip over given amount of results
     *
     * @see https://jsonapi.org/format/1.1/#fetching-pagination
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionstopandskip
     *
     * @param int $offset
     *
     * @return self
     */
    public function offset(int $offset): self;

    /**
     * Alias for {@see limit}
     *
     * @param int $amount
     *
     * @return self
     */
    public function take(int $amount): self;

    /**
     * Alias for {@see offset}
     *
     * @param int $offset
     *
     * @return self
     */
    public function skip(int $offset): self;

    /**
     * Return results on given page number
     *
     * @param int $number
     *
     * @return self
     */
    public function page(int $number): self;

    /**
     * Limit the amount of results per page
     *
     * @see page
     *
     * @param int $amount
     *
     * @return self
     */
    public function show(int $amount): self;

    /**
     * Order results by given field or fields
     *
     * @see https://jsonapi.org/format/1.1/#fetching-sorting
     * @see http://docs.oasis-open.org/odata/odata/v4.01/odata-v4.01-part2-url-conventions.html#sec_SystemQueryOptionorderby
     *
     * @param string|string[] $field Field to order results by
     * @param string $direction [optional] Ascending or descending order
     *
     * @return self
     */
    public function orderBy($field, string $direction = self::ASCENDING): self;

    /**
     * Build this http query
     *
     * @return mixed
     */
    public function build();

    /**
     * Set the grammar responsible for building this http query
     *
     * @param Grammar $grammar
     *
     * @return self
     */
    public function setGrammar(Grammar $grammar): self;

    /**
     * Get the grammar responsible for building this http query
     *
     * @return Grammar
     */
    public function getGrammar(): Grammar;
}
