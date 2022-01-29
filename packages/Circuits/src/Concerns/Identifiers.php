<?php


namespace Aedart\Circuits\Concerns;

use Aedart\Circuits\Exceptions\UnknownState;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;

/**
 * Concerns State Identifiers
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\Concerns
 */
trait Identifiers
{
    /**
     * List of valid (known) states
     *
     * @var string[]
     */
    protected array $validStates = [
        CircuitBreaker::CLOSED => 'closed',
        CircuitBreaker::OPEN => 'open',
        CircuitBreaker::HALF_OPEN => 'half open'
    ];

    /**
     * Returns list of valid (known) state identifiers
     *
     * @return string[] key-value pair, key = identifier, value = name
     */
    public function validStates(): array
    {
        return $this->validStates;
    }

    /**
     * Get name of given identifier
     *
     * @param int $id
     *
     * @return string
     *
     * @throws UnknownStateException
     */
    protected function getIdentifierName(int $id): string
    {
        $this->assertStateIdentifier($id);

        return $this->validStates[$id];
    }

    /**
     * Assert given state identifier is allowed / known
     *
     * @param int|null $id [optional]
     *
     * @throws UnknownStateException
     */
    protected function assertStateIdentifier(int|null $id = null)
    {
        $id = $id ?? CircuitBreaker::CLOSED;

        if (!isset($this->validStates[$id])) {
            throw new UnknownState(sprintf('%s is not a valid state identifier.', $id));
        }
    }
}
