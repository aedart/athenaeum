<?php

namespace Aedart\Support\Properties\Strings;

/**
 * @deprecated Since version 9.x. Component will be removed in next major version.
 *
 * Question Trait
 *
 * @see \Aedart\Contracts\Support\Properties\Strings\QuestionAware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Support\Properties\Strings
 */
trait QuestionTrait
{
    /**
     * A question that can be asked
     *
     * @var string|null
     */
    protected string|null $question = null;

    /**
     * Set question
     *
     * @param string|null $question A question that can be asked
     *
     * @return self
     */
    public function setQuestion(string|null $question): static
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * If no question value set, method
     * sets and returns a default question.
     *
     * @see getDefaultQuestion()
     *
     * @return string|null question or null if no question has been set
     */
    public function getQuestion(): string|null
    {
        if (!$this->hasQuestion()) {
            $this->setQuestion($this->getDefaultQuestion());
        }
        return $this->question;
    }

    /**
     * Check if question has been set
     *
     * @return bool True if question has been set, false if not
     */
    public function hasQuestion(): bool
    {
        return isset($this->question);
    }

    /**
     * Get a default question value, if any is available
     *
     * @return string|null Default question value or null if no default value is available
     */
    public function getDefaultQuestion(): string|null
    {
        return null;
    }
}
