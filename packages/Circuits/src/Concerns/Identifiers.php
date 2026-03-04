<?php


namespace Aedart\Circuits\Concerns;

use Aedart\Circuits\Exceptions\UnknownState;
use Aedart\Contracts\Circuits\CircuitBreaker;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\States\Identifier;

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
     *
     * @deprecated Avoid using, will be removed in next major version, since v10.x
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
     *
     * @deprecated use {@see \Aedart\Contracts\Circuits\States\Identifier} instead, since v10.x
     */
    #[\Deprecated(message: "use \Aedart\Contracts\Circuits\States\Identifier instead", since: "10.x")]
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
     *
     * @deprecated use {@see \Aedart\Contracts\Circuits\States\Identifier::name()} instead, since v10.x
     */
    #[\Deprecated(message: "use \Aedart\Contracts\Circuits\States\Identifier::name() instead", since: "10.x")]
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
     *
     * @deprecated use {@see resolveStateIdentifier()} instead, since v10.x
     */
    #[\Deprecated(message: "use \Aedart\Circuits\Concerns\Identifiers::resolveStateIdentifier() instead", since: "10.x")]
    protected function assertStateIdentifier(int|null $id = null): void
    {
        $id = $id ?? CircuitBreaker::CLOSED;

        if (!isset($this->validStates[$id])) {
            throw new UnknownState(sprintf('%s is not a valid state identifier.', $id));
        }
    }

    /**
     * Resolve state identifier
     *
     * @param int|Identifier|null $id [optional]
     *
     * @return Identifier {@see Identifier::default()} if `null` is given
     *
     * @throws UnknownStateException
     */
    protected function resolveStateIdentifier(int|Identifier|null $id = null): Identifier
    {
        $resolved = match (true) {
            is_null($id) => Identifier::default(),
            $id instanceof Identifier => $id,
            default => identifier::tryFrom($id)
        };

        if (!isset($resolved)) {
            throw new UnknownState(sprintf('%s is not a valid state identifier.', var_export($id, true)));
        }

        return $resolved;
    }
}
