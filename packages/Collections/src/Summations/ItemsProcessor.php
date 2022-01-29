<?php

namespace Aedart\Collections\Summations;

use Aedart\Collections\Exceptions\NotTraversable;
use Aedart\Collections\Summation as SummationCollection;
use Aedart\Collections\Summations\Rules\RulesRepository;
use Aedart\Contracts\Collections\Exceptions\SummationCollectionException;
use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\ItemsProcessor as ItemsProcessorInterface;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summations\Rules\Repository;
use Aedart\Contracts\Support\Helpers\Container\ContainerAware;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use Traversable;

/**
 * Item Processor
 *
 * @see \Aedart\Contracts\Collections\Summations\ItemsProcessor
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Collections\Summations
 */
class ItemsProcessor implements
    ItemsProcessorInterface,
    ContainerAware
{
    use ContainerTrait;

    /**
     * The Rules Repository
     *
     * @var Repository
     */
    protected Repository $rules;

    /**
     * The Summation Collection
     *
     * @var Summation
     */
    protected Summation $summation;

    /**
     * Default Rules Repository class to use
     *
     * @var string
     */
    protected string $defaultRepository = RulesRepository::class;

    /**
     * Before callback
     *
     * @var callable|null
     */
    protected $before = null;

    /**
     * After callback
     *
     * @var callable|null
     */
    protected $after = null;

    /**
     * ItemProcessor constructor.
     *
     * @param  ProcessingRule[]|Repository|string[]  $rules Processing Rules instances, class paths or Repository of
     *                                                processing rules.
     * @param  Summation|null  $summation  [optional]
     * @param  Container|null  $container  [optional]
     *
     * @throws BindingResolutionException
     */
    public function __construct(array|Repository $rules, Summation|null $summation = null, Container|null $container = null)
    {
        $this->setContainer($container);
        $this->rules = $this->resolveRulesRepository($rules);
        $this->summation = $this->resolveSummation($summation);
    }

    /**
     * @inheritDoc
     */
    public function process($items): Summation
    {
        // Abort if unable to traverse
        if (!(is_array($items) || $items instanceof Traversable)) {
            throw new NotTraversable('Unable to process items. List is not an array or traversable.');
        }

        // Apply the "before" callback, if required
        $summation = $this->applyCallback($this->summation(), $this->before);

        // Process items
        $rules = $this->rules();
        foreach ($items as $item) {
            $summation = $this->processSingleItem($item, $rules, $summation);
        }

        // Apply "after" callback, if required and return summation.
        return $this->applyCallback($summation, $this->after);
    }

    /**
     * @inheritDoc
     */
    public function before(callable|null $callback = null): static
    {
        $this->before = $callback;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function after(callable|null $callback = null): static
    {
        $this->after = $callback;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function rules(): Repository
    {
        return $this->rules;
    }

    /**
     * @inheritDoc
     *
     * @throws BindingResolutionException
     */
    public function withRules(array|Repository $rules): static
    {
        return (new static($rules, $this->summation(), $this->getContainer()))
            ->before($this->before)
            ->after($this->after);
    }

    /**
     * @inheritDoc
     */
    public function summation(): Summation
    {
        return $this->summation;
    }

    /**
     * @inheritDoc
     *
     * @throws BindingResolutionException
     */
    public function withSummation(Summation $summation): static
    {
        return (new static($this->rules(), $summation, $this->getContainer()))
            ->before($this->before)
            ->after($this->after);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Process a single item
     *
     * @param  mixed $item
     * @param  Repository  $rules
     * @param  Summation  $summation
     *
     * @return Summation
     *
     * @throws SummationCollectionException
     */
    protected function processSingleItem(mixed $item, Repository $rules, Summation $summation): Summation
    {
        return $rules
            ->matching($item)
            ->withSummation($summation)
            ->process();
    }

    /**
     * Applies given callback and returns resulting Summation
     *
     * @param  Summation  $summation
     * @param  callable|null  $callback  [optional]
     *
     * @return Summation
     */
    protected function applyCallback(Summation $summation, callable|null $callback = null): Summation
    {
        if (!isset($callback)) {
            return $summation;
        }

        return $callback($summation);
    }

    /**
     * Resolves the Rules Repository
     *
     * @param  ProcessingRule[]|Repository|string[]  $rules
     *
     * @return Repository
     *
     * @throws BindingResolutionException
     */
    protected function resolveRulesRepository(array|Repository $rules): Repository
    {
        if ($rules instanceof Repository) {
            return $rules;
        }

        $container = $this->getContainer();
        if ($container->bound(Repository::class)) {
            $repository = $container->make(Repository::class, ['rules' => $rules]);
        }

        /** @var Repository $repository */
        return $repository ?? new $this->defaultRepository($rules);
    }

    /**
     * Resolve the Summation Collection
     *
     * @param  Summation|null  $summation  [optional]
     *
     * @return Summation
     *
     * @throws BindingResolutionException
     */
    protected function resolveSummation(Summation|null $summation = null): Summation
    {
        if (isset($summation)) {
            return $summation;
        }

        $container = $this->getContainer();
        if ($container->bound(Summation::class)) {
            return $container->make(Summation::class);
        }

        return new SummationCollection();
    }
}
