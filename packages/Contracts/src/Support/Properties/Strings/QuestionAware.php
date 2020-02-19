<?php

namespace Aedart\Contracts\Support\Properties\Strings;

/**
 * Question Aware
 *
 * Component is aware of string "question"
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Support\Properties\Strings
 */
interface QuestionAware
{
    /**
     * Set question
     *
     * @param string|null $question A question that can be asked
     *
     * @return self
     */
    public function setQuestion(?string $question);

    /**
     * Get question
     *
     * If no "question" value set, method
     * sets and returns a default "question".
     *
     * @see getDefaultQuestion()
     *
     * @return string|null question or null if no question has been set
     */
    public function getQuestion(): ?string;

    /**
     * Check if "question" has been set
     *
     * @return bool True if "question" has been set, false if not
     */
    public function hasQuestion(): bool;

    /**
     * Get a default "question" value, if any is available
     *
     * @return string|null Default "question" value or null if no default value is available
     */
    public function getDefaultQuestion(): ?string;
}
