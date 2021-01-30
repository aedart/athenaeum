<?php

namespace Aedart\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;
use Aedart\Contracts\Collections\Summations\Rules\Rules;
use ArrayIterator;

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
    protected $item;

    /**
     * The Summation Collection instance
     *
     * @var Summation
     */
    protected Summation $summation;

    /**
     * List of processing rules
     *
     * @var ProcessingRule[]
     */
    protected array $rules = [];

    /**
     * RulesCollection constructor.
     *
     * @param  mixed $item
     * @param  ProcessingRule[]  $rules
     * @param  Summation  $summation
     */
    public function __construct($item, array  $rules, Summation $summation)
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
    public function withRules(array $rules): Rules
    {
        return new static($this->item(), $rules, $this->summation());
    }

    /**
     * @inheritDoc
     */
    public function item()
    {
        return $this->item;
    }

    /**
     * @inheritDoc
     */
    public function withItem($item): Rules
    {
        return new static($item, $this->rules(), $this->summation());
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
     */
    public function withSummation(Summation $summation): Rules
    {
        return new static($this->item(), $this->rules(), $summation);
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
        return $this->rules();
    }
}
