<?php

namespace Aedart\Collections\Summations\Rules;

use Aedart\Contracts\Collections\Summation;
use Aedart\Contracts\Collections\Summations\Rules\ProcessingRule;

/**
 * Base Processing Rule
 *
 * Abstraction for a processing rule
 *
 * @see \Aedart\Contracts\Collections\Summations\Rules\ProcessingRule
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Collections\Summations\Rules
 */
abstract class BaseProcessingRule implements ProcessingRule
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
     * BaseProcessingRule constructor.
     *
     * @param mixed $item
     * @param  Summation  $summation
     */
    public function __construct($item, Summation $summation)
    {
        $this->item = $item;
        $this->summation = $summation;
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
    public function summation(): Summation
    {
        return $this->summation;
    }
}
