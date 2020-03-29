<?php

namespace Aedart\Http\Clients\Requests\Query;

use Aedart\Contracts\Http\Clients\Requests\Query\Builder as QueryBuilder;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammars\GrammarManagerAware;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammars\Manager;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Aedart\Http\Clients\Traits\GrammarManagerTrait;
use Aedart\Http\Clients\Traits\GrammarTrait;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Illuminate\Contracts\Container\Container;

/**
 * Http Query Builder
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Query
 */
class Builder implements QueryBuilder,
    ContainerAware,
    GrammarManagerAware
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
     * Builder constructor.
     *
     * @param string|Grammar|null $grammar [optional] String profile name, {@see Grammar} instance or null.
     *                          If null is given, then a default Grammar is resolved
     * @param Container|null $container [optional]
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    public function __construct($grammar = null, ?Container $container = null)
    {
        $this
            ->setContainer($container)
            ->resolveGrammar($grammar);
    }
    
    /**
     * @inheritDoc
     */
    public function select($field, ?string $resource = null): QueryBuilder
    {
        if(is_array($field)){
            return $this->addSelect($field);
        }

        return $this->addSelect([ $field => $resource ]);
    }

    /**
     * @inheritDoc
     */
    public function selectRaw($expression, array $bindings = []): QueryBuilder
    {
        return $this->addSelect([$expression], $bindings, self::SELECT_TYPE_RAW);
    }

    /**
     * @inheritDoc
     */
    public function where($field, $operator = null, $value = null): QueryBuilder
    {
        // TODO: Implement where() method.
    }

    /**
     * @inheritDoc
     */
    public function orWhere($field, $operator = null, $value = null): QueryBuilder
    {
        // TODO: Implement orWhere() method.
    }

    /**
     * @inheritDoc
     */
    public function whereRaw($query, array $bindings = []): QueryBuilder
    {
        // TODO: Implement whereRaw() method.
    }

    /**
     * @inheritDoc
     */
    public function orWhereRaw($query, array $bindings = []): QueryBuilder
    {
        // TODO: Implement orWhereRaw() method.
    }

    /**
     * @inheritDoc
     */
    public function include($resource): QueryBuilder
    {
        // TODO: Implement include() method.
    }

    /**
     * @inheritDoc
     */
    public function limit(int $amount): QueryBuilder
    {
        // TODO: Implement limit() method.
    }

    /**
     * @inheritDoc
     */
    public function offset(int $offset): QueryBuilder
    {
        // TODO: Implement offset() method.
    }

    /**
     * @inheritDoc
     */
    public function take(int $amount): QueryBuilder
    {
        // TODO: Implement take() method.
    }

    /**
     * @inheritDoc
     */
    public function skip(int $offset): QueryBuilder
    {
        // TODO: Implement skip() method.
    }

    /**
     * @inheritDoc
     */
    public function page(int $number): QueryBuilder
    {
        // TODO: Implement page() method.
    }

    /**
     * @inheritDoc
     */
    public function show(int $amount): QueryBuilder
    {
        // TODO: Implement show() method.
    }

    /**
     * @inheritDoc
     */
    public function orderBy($field, string $direction = QueryBuilder::ASCENDING): QueryBuilder
    {
        // TODO: Implement orderBy() method.
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return [
            self::SELECTS => $this->selects
        ];
    }

    /**
     * @inheritDoc
     */
    public function build(): string
    {
        return $this->getGrammar()->compile($this);
    }

    /*****************************************************************
     * Defaults
     ****************************************************************/

    /**
     * @inheritdoc
     */
    public function getDefaultGrammarManager(): ?Manager
    {
        // We have to respect the IoC container instance
        // that MIGHT have been set via the constructor or
        // mutator.
        return $this->getContainer()->make(Manager::class);
    }

    /**
     * @inheritdoc
     */
    public function getDefaultGrammar(): ?Grammar
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
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException
     */
    protected function resolveGrammar($grammar = null)
    {
        // If no grammar has been given, then abort and allow the
        // default to be set via "getDefaultGrammar" ~ default profile.
        if (!isset($grammar)){
            return $this;
        }

        // If identifier (profile) has been given, obtain it via the
        // manager, so it can be used.
        if(is_string($grammar)){
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
     * @return QueryBuilder
     */
    protected function addSelect(array $fields, array $bindings = [], string $type = self::SELECT_TYPE_REGULAR): QueryBuilder
    {
        $this->selects[] = [
            self::TYPE => $type,
            self::FIELDS => $fields,
            self::BINDINGS => $bindings
        ];

        return $this;
    }
}
