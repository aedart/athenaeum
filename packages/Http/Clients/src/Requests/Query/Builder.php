<?php

namespace Aedart\Http\Clients\Requests\Query;

use Aedart\Contracts\Http\Clients\Exceptions\HttpQueryBuilderException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Requests\Query\Builder as QueryBuilder;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammars\GrammarManagerAware;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammars\Manager;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Aedart\Http\Clients\Requests\Query\Grammars\Dates\DateValue;
use Aedart\Http\Clients\Traits\GrammarManagerTrait;
use Aedart\Http\Clients\Traits\GrammarTrait;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Aedart\Utils\Arr;
use DateTimeInterface;
use Illuminate\Contracts\Container\Container;
use Stringable;

/**
 * Http Query Builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Query
 */
class Builder implements
    QueryBuilder,
    ContainerAware,
    GrammarManagerAware,
    Stringable
{
    use ContainerTrait;
    use GrammarManagerTrait;
    use GrammarTrait;

    /**
     * The fields to be selected
     *
     * @var array
     */
    protected array $selects = [];

    /**
     * Where conditions
     *
     * @var array
     */
    protected array $wheres = [];

    /**
     * Includes
     *
     * @var array
     */
    protected array $includes = [];

    /**
     * Limit
     *
     * @var int|null
     */
    protected int|null $limit = null;

    /**
     * Offset
     *
     * @var int|null
     */
    protected int|null $offset = null;

    /**
     * Page number
     *
     * @var int|null
     */
    protected int|null $pageNumber = null;

    /**
     * Page size
     *
     * @var int|null
     */
    protected int|null $pageSize = null;

    /**
     * Sorting order criteria
     *
     * @var array
     */
    protected array $orderBy = [];

    /**
     * Raw expressions
     *
     * @var array
     */
    protected array $rawExpressions = [];

    /**
     * Builder constructor.
     *
     * @param string|Grammar|null $grammar [optional] String profile name, {@see Grammar} instance or null.
     *                          If null is given, then a default Grammar is resolved
     * @param Container|null $container [optional]
     *
     * @throws ProfileNotFoundException
     */
    public function __construct(string|Grammar|null $grammar = null, Container|null $container = null)
    {
        $this
            ->setContainer($container)
            ->resolveGrammar($grammar);
    }

    /**
     * @inheritDoc
     */
    public function select(string|array $field, string|null $resource = null): static
    {
        if (is_array($field)) {
            return $this->addSelect($field);
        }

        return $this->addSelect([ $field => $resource ]);
    }

    /**
     * @inheritDoc
     */
    public function selectRaw(string $expression, array $bindings = []): static
    {
        return $this->addSelect([$expression], $bindings, self::SELECT_TYPE_RAW);
    }

    /**
     * @inheritDoc
     */
    public function where(string|array $field, mixed $operator = null, mixed $value = null): static
    {
        // When field is an array, we assume that multiple where conditions are
        // desired added
        if (is_array($field)) {
            return $this->addMultipleWhere($field);
        }

        // Resolve arguments...
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = self::EQUALS;
        }

        // In case only a field is provided.
        $operator = $operator ?? self::EQUALS;

        // Finally, add a regular where condition
        return $this->addRegularWhere($field, $operator, $value);
    }

    /**
     * @inheritdoc
     */
    public function orWhere(string|array $field, mixed $operator = null, mixed $value = null): static
    {
        // When field is an array, we assume that multiple where conditions are
        // desired added
        if (is_array($field)) {
            return $this->addMultipleWhere($field, self::OR_CONJUNCTION);
        }

        // Resolve arguments...
        if (func_num_args() === 2) {
            $value = $operator;
            $operator = self::EQUALS;
        }

        // In case only a field is provided.
        $operator = $operator ?? self::EQUALS;

        // Finally, add a regular where condition
        return $this->addRegularWhere($field, $operator, $value, self::OR_CONJUNCTION);
    }

    /**
     * @inheritDoc
     */
    public function whereRaw(string $query, array $bindings = []): static
    {
        return $this->addRawWhere($query, $bindings);
    }

    /**
     * @inheritdoc
     */
    public function orWhereRaw(string $query, array $bindings = []): static
    {
        return $this->addRawWhere($query, $bindings, self::OR_CONJUNCTION);
    }

    /**
     * @inheritdoc
     */
    public function whereDatetime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(self::DATETIME_FORMAT, $field, $operator, $value);
    }

    /**
     * @inheritdoc
     */
    public function orWhereDatetime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(
            self::DATETIME_FORMAT,
            $field,
            $operator,
            $value,
            self::OR_CONJUNCTION
        );
    }

    /**
     * @inheritdoc
     */
    public function whereDate(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(self::DATE_FORMAT, $field, $operator, $value);
    }

    /**
     * @inheritdoc
     */
    public function orWhereDate(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(
            self::DATE_FORMAT,
            $field,
            $operator,
            $value,
            self::OR_CONJUNCTION
        );
    }

    /**
     * @inheritdoc
     */
    public function whereYear(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(self::YEAR_FORMAT, $field, $operator, $value);
    }

    /**
     * @inheritdoc
     */
    public function orWhereYear(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(
            self::YEAR_FORMAT,
            $field,
            $operator,
            $value,
            self::OR_CONJUNCTION
        );
    }

    /**
     * @inheritdoc
     */
    public function whereMonth(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(self::MONTH_FORMAT, $field, $operator, $value);
    }

    /**
     * @inheritdoc
     */
    public function orWhereMonth(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(
            self::MONTH_FORMAT,
            $field,
            $operator,
            $value,
            self::OR_CONJUNCTION
        );
    }

    /**
     * @inheritdoc
     */
    public function whereDay(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(self::DAY_FORMAT, $field, $operator, $value);
    }

    /**
     * @inheritdoc
     */
    public function orWhereDay(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(
            self::DAY_FORMAT,
            $field,
            $operator,
            $value,
            self::OR_CONJUNCTION
        );
    }

    /**
     * @inheritdoc
     */
    public function whereTime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(self::TIME_FORMAT, $field, $operator, $value);
    }

    /**
     * @inheritdoc
     */
    public function orWhereTime(string $field, mixed $operator = null, string|DateTimeInterface|null $value = null): static
    {
        return $this->addWhereDateExpression(
            self::TIME_FORMAT,
            $field,
            $operator,
            $value,
            self::OR_CONJUNCTION
        );
    }

    /**
     * @inheritDoc
     */
    public function include(string|array $resource): static
    {
        if (!is_array($resource)) {
            $resource = [$resource];
        }

        $this->includes = array_merge($this->includes, $resource);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function limit(int $amount): static
    {
        $this->limit = $amount;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function offset(int $offset): static
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function take(int $amount): static
    {
        return $this->limit($amount);
    }

    /**
     * @inheritDoc
     */
    public function skip(int $offset): static
    {
        return $this->offset($offset);
    }

    /**
     * @inheritdoc
     */
    public function page(int $number, int|null $size = null): static
    {
        $this->pageNumber = $number;

        return $this->show($size);
    }

    /**
     * @inheritdoc
     */
    public function show(int|null $amount = null): static
    {
        $this->pageSize = $amount;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function orderBy(string|array $field, string $direction = QueryBuilder::ASCENDING): static
    {
        if (is_array($field)) {
            return $this->addMultipleOrderBy($field);
        }

        return $this->addOrderBy($field, $direction);
    }

    /**
     * @inheritdoc
     */
    public function raw(string $expression, array $bindings = []): static
    {
        $this->rawExpressions[] = [
            self::EXPRESSION => $expression,
            self::BINDINGS => $bindings
        ];

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            self::SELECTS => $this->selects,
            self::WHERES => $this->wheres,
            self::INCLUDES => $this->includes,
            self::LIMIT => $this->limit,
            self::OFFSET => $this->offset,
            self::PAGE_NUMBER => $this->pageNumber,
            self::PAGE_SIZE => $this->pageSize,
            self::ORDER_BY => $this->orderBy,
            self::RAW => $this->rawExpressions
        ];
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        return $this->getGrammar()->compile($this);
    }

    /**
     * Builds this http query
     *
     * @return string
     *
     * @throws HttpQueryBuilderException
     */
    public function __toString(): string
    {
        return $this->build();
    }

    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * @inheritdoc
     */
    public function getDefaultGrammarManager(): Manager|null
    {
        // We have to respect the IoC container instance
        // that MIGHT have been set via the constructor or
        // mutator.
        return $this->getContainer()->make(Manager::class);
    }

    /**
     * @inheritdoc
     */
    public function getDefaultGrammar(): Grammar|null
    {
        return $this->getGrammarManager()->profile();
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Resolve the given http query grammar
     *
     * @param string|Grammar|null $grammar [optional] String profile name, {@see Grammar} instance or null.
     *                          If null is given, then a default Grammar is resolved
     *
     * @return self
     *
     * @throws ProfileNotFoundException
     */
    protected function resolveGrammar(string|Grammar|null $grammar = null): static
    {
        // If no grammar has been given, then abort and allow the
        // default to be set via "getDefaultGrammar" ~ default profile.
        if (!isset($grammar)) {
            return $this;
        }

        // If identifier (profile) has been given, obtain it via the
        // manager, so it can be used.
        if (is_string($grammar)) {
            $grammar = $this->getGrammarManager()->profile($grammar);
        }

        return $this->setGrammar($grammar);
    }

    /**
     * Add a list of fields to be selected
     *
     * @param array $fields Key = field to select, value = from resource (optional)
     * @param array $bindings [optional] Evt. bindings
     * @param string $type [optional] Select type
     *
     * @return self
     */
    protected function addSelect(array $fields, array $bindings = [], string $type = self::SELECT_TYPE_REGULAR): static
    {
        $this->selects[] = [
            self::TYPE => $type,
            self::FIELDS => $fields,
            self::BINDINGS => $bindings
        ];

        return $this;
    }

    /**
     * Add multiple "where" conditions
     *
     * @param array $conditions [optional]
     * @param string $conjunction [optional]
     *
     * @return self
     */
    protected function addMultipleWhere(array $conditions = [], string $conjunction = self::AND_CONJUNCTION): static
    {
        foreach ($conditions as $field => $value) {
            // Determine if one or more operators has been given
            // via the value of the field. If so, then we consider these
            // to be multiple where conditions, with an operator.
            if (is_array($value) && Arr::isAssoc($value)) {
                $this->addMultipleWhereForField($field, $value, $conjunction);
                continue;
            }

            // Otherwise, we assume that an equals operator is intended
            // and add it as a regular "where" condition
            $this->addRegularWhere($field, self::EQUALS, $value, $conjunction);
        }

        return $this;
    }

    /**
     * Add multiple "where" conditions for a single field,
     *
     * @param string $field
     * @param array $operatorsAndValues Key-value pair, where key = operator
     * @param string $conjunction [optional]
     *
     * @return self
     */
    protected function addMultipleWhereForField(
        string $field,
        array $operatorsAndValues,
        string $conjunction = self::AND_CONJUNCTION
    ): static {
        foreach ($operatorsAndValues as $operator => $value) {
            $this->addRegularWhere($field, $operator, $value, $conjunction);
        }

        return $this;
    }

    /**
     * Add a regular "where" condition
     *
     * @param string $field
     * @param string $operator [optional]
     * @param mixed $value [optional]
     * @param string $conjunction [optional]
     *
     * @return QueryBuilder
     */
    protected function addRegularWhere(
        string $field,
        string $operator = self::EQUALS,
        mixed $value = null,
        string $conjunction = self::AND_CONJUNCTION
    ): QueryBuilder {
        return $this->appendWhereCondition([
            self::FIELD => $field,
            self::OPERATOR => $operator,
            self::VALUE => $value
        ], [], self::WHERE_TYPE_REGULAR, $conjunction);
    }

    /**
     * Add a raw "where" condition
     *
     * @param string $expression
     * @param array $bindings [optional]
     * @param string $conjunction [optional]
     *
     * @return self
     */
    protected function addRawWhere(
        string $expression,
        array $bindings = [],
        string $conjunction = self::AND_CONJUNCTION
    ): static {
        return $this->appendWhereCondition([
            self::FIELD => $expression,
            self::OPERATOR => null,
            self::VALUE => null,
        ], $bindings, self::WHERE_TYPE_RAW, $conjunction);
    }

    /**
     * Appends a "where" condition to builder's list of conditions
     *
     * @param array $where
     * @param array $bindings [optional]
     * @param string $type [optional]
     * @param string $conjunction [optional]
     *
     * @return self
     */
    protected function appendWhereCondition(
        array $where,
        array $bindings = [],
        string $type = self::WHERE_TYPE_REGULAR,
        string $conjunction = self::AND_CONJUNCTION
    ): static {
        // Add bindings, type, ...etc to where condition
        $where[self::BINDINGS] = $bindings;
        $where[self::TYPE] = $type;
        $where[self::CONJUNCTION] = $conjunction;

        // Finally, add the where condition to list of conditions
        $this->wheres[] = $where;

        return $this;
    }

    /**
     * Add a where date expression
     *
     * @param string $format Date format
     * @param string $field
     * @param mixed $operator [optional]
     * @param mixed $value [optional]
     * @param string $conjunction [optional]
     *
     * @return self
     */
    protected function addWhereDateExpression(
        string $format,
        string $field,
        mixed $operator = null,
        mixed $value = null,
        string $conjunction = self::AND_CONJUNCTION
    ): static {
        // Resolve arguments
        if (!isset($value)) {
            $value = $operator;
            $operator = self::EQUALS;
        }

        // In case only a field is provided.
        $operator = $operator ?? self::EQUALS;

        // Wrap the given value, so that the grammar is able to
        // distinguish between dates and other types of values.
        $dateValue = new DateValue($value, $format);

        return $this->addRegularWhere($field, $operator, $dateValue, $conjunction);
    }

    /**
     * Add multiple sorting order criteria
     *
     * @see addOrderBy
     *
     * @param array $criteria
     *
     * @return self
     */
    protected function addMultipleOrderBy(array $criteria): static
    {
        foreach ($criteria as $field => $direction) {
            if (is_int($field)) {
                $field = $direction;
                $direction = self::ASCENDING;
            }

            $this->addOrderBy($field, $direction);
        }

        return $this;
    }

    /**
     * Add sorting order criteria for a field
     *
     * @param string $field
     * @param string $direction
     *
     * @return self
     */
    protected function addOrderBy(string $field, string $direction): static
    {
        $this->orderBy[] = [
            self::FIELD => $field,
            self::DIRECTION => $direction
        ];

        return $this;
    }
}
