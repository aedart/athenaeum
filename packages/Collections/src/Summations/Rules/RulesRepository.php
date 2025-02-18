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
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Traversable;

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
    public function __construct(array $rules = [], Container|null $container = null)
    {
        $this->setContainer($container);
        $this->rules = $rules;
    }

    /**
     * @inheritDoc
     *
     * @throws BindingResolutionException
     */
    public function matching(mixed $item): Rules
    {
        // To ensure that processing rules are as "stateless" as possible,
        // we create new instances here. This will provide the cleanest
        // use-case for when processing an item.
        $rules = $this->resolveRules();

        // Determine if processing rule can process given
        // item. If the rule in question is not able to determine this,
        // we assume that the rule always can process given item.
        $matching = array_filter($rules, function (ProcessingRule $rule) use ($item) {
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
     *
     * @throws BindingResolutionException
     */
    public function all(): Rules
    {
        // Same principle here, as for with matching.
        // New instances are more favourable rather than
        // existing.
        $rules = $this->resolveRules();

        return $this->makeRulesCollection()->withRules($rules);
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->rules);
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->rules);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
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
     * @throws BindingResolutionException
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
     * @throws BindingResolutionException
     */
    protected function resolveRules(): array
    {
        $container = $this->getContainer();

        return (new ListResolver($container))->make($this->rules);
    }
}
