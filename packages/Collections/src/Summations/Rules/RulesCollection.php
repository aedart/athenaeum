<?php

namespace Aedart\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summations\Rules\Rules;
use ArrayIterator;
use Traversable;

/**
 * Rules Collection
 *
 * @see \Aedart\Contracts\Collections\Summations\Rules\Rules
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Collections\Summations\Rules
 */
class RulesCollection implements Rules
{
    /**
     * The item in question
     *
     * @var mixed
     */
    protected mixed $item;

    /**
     * The Summation Collection instance
     *
     * @var Summation|null
     */
    protected Summation|null $summation;

    /**
     * List of processing rules
     *
     * @var ProcessingRule[]
     */
    protected array $rules = [];

    /**
     * RulesCollection constructor.
     *
     * @param  mixed $item  [optional]
     * @param  ProcessingRule[]  $rules  [optional]
     * @param  Summation|null  $summation  [optional]
     */
    public function __construct(mixed $item = null, array $rules = [], Summation|null $summation = null)
    {
        $this->item = $item;
        $this->rules = $rules;
        $this->summation = $summation;
    }

    /**
     * @inheritDoc
     */
    public function process(): Summation
    {
        $item = $this->item();
        $rules = $this->rules();
        $summation = $this->summation();

        foreach ($rules as $rule) {
            $summation = $rule->process($item, $summation);
        }

        return $summation;
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return $this->rules;
    }

    /**
     * @inheritDoc
     */
    public function withRules(array $rules): static
    {
        return new static($this->item(), $rules, $this->summation());
    }

    /**
     * @inheritDoc
     */
    public function item(): mixed
    {
        return $this->item;
    }

    /**
     * @inheritDoc
     */
    public function withItem(mixed $item): static
    {
        return new static($item, $this->rules(), $this->summation());
    }

    /**
     * @inheritDoc
     */
    public function summation(): Summation|null
    {
        return $this->summation;
    }

    /**
     * @inheritDoc
     */
    public function withSummation(Summation $summation): static
    {
        return new static($this->item(), $this->rules(), $summation);
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
    public function toArray()
    {
        return $this->rules();
    }
}
