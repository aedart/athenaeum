<?php

namespace Aedart\Collections\Summations\Rules;

use Aedart\Container\ListResolver;
use Aedart\Contracts\Collections\Summations\Rules\Determinable;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summations\Rules\Repository;
use Aedart\Contracts\Collections\Summations\Rules\Rules;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Aedart\Support\Helpers\Container\ContainerTrait;
use ArrayIterator;
use Illuminate\Contracts\Container\Container;

/**
 * Processing Rules Repository
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Collections\Summations\Rules
 */
class RulesRepository implements
    Repository,
    ContainerAware
{
    use ContainerTrait;

    /**
     * List of processing rules
     *
     * @var ProcessingRule[]|string[]
     */
    protected array $rules = [];

    /**
     * Default Rules Collection class to use
     *
     * @var string
     */
    protected string $defaultCollection = RulesCollection::class;

    /**
     * RulesRepository constructor.
     *
     * @param  string[]|ProcessingRule[]  $rules  [optional] List of class paths or Processing Rules instances
     * @param  Container|null  $container  [optional]
     */
    public function __construct(array $rules = [], ?Container $container = null)
    {
        $this->setContainer($container);
        $this->rules = $rules;
    }

    /**
     * @inheritDoc
     */
    public function matching($item): Rules
    {
        $rules = $this->resolveRules();

        // Determine whether or not processing rule can process given
        // item. If the rule in question is not able to determine this,
        // we assume that the rule always can process given item.
        $matching = array_filter($rules, function(ProcessingRule $rule) use($item) {
            if ($rule instanceof Determinable) {
                return $rule->canProcess($item);
            }

            return true;
        });
        
        return $this->makeRulesCollection()
            ->withItem($item)
            ->withRules($matching);
    }

    /**
     * @inheritDoc
     */
    public function all(): Rules
    {
        $rules = $this->resolveRules();

        return $this->makeRulesCollection()->withRules($rules);
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->rules);
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->rules);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return $this->rules;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Creates a new Rules Collection instance
     *
     * @return Rules
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function makeRulesCollection(): Rules
    {
        $container = $this->getContainer();

        if ($container->bound(Rules::class)) {
            return $container->make(Rules::class);
        }

        return new $this->defaultCollection();
    }

    /**
     * Resolves the processing rules
     *
     * @return ProcessingRule[]
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function resolveRules(): array
    {
        $container = $this->getContainer();

        return (new ListResolver($container))->make($this->rules);
    }
}
