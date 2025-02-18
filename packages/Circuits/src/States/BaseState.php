<?php

namespace Aedart\Circuits\States;

use Aedart\Circuits\Concerns;
use Aedart\Contracts\Circuits\Exceptions\UnknownStateException;
use Aedart\Contracts\Circuits\State;
use DateTimeInterface;
use Illuminate\Support\Facades\Date;

/**
 * Base State
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Circuits\States
 */
abstract class BaseState implements State
{
    use Concerns\Identifiers;
    use Concerns\Dates;
    use Concerns\Importable;
    use Concerns\Exportable;

    /**
     * Previous state identifier
     *
     * @var int|null
     */
    protected int|null $previous = null;

    /**
     * Date and time of when this state was created
     *
     * @var DateTimeInterface
     */
    protected DateTimeInterface $createdAt;

    /**
     * Date and time of when this state expires
     *
     * @var DateTimeInterface|null
     */
    protected DateTimeInterface|null $expiresAt = null;

    /**
     * BaseState constructor.
     *
     * @param array $data [optional]
     *
     * @throws UnknownStateException
     */
    public function __construct(array $data = [])
    {
        $this->populate($data);
    }

    /**
     * @inheritdoc
     */
    public static function make(array $data = []): static
    {
        return new static($data);
    }

    /**
     * @inheritDoc
     *
     * @throws UnknownStateException
     */
    public function name(): string
    {
        return $this->getIdentifierName(
            $this->id()
        );
    }

    /**
     * @inheritDoc
     */
    public function createdAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @inheritDoc
     */
    public function expiresAt(): DateTimeInterface|null
    {
        return $this->expiresAt;
    }

    /**
     * @inheritDoc
     */
    public function hasExpired(): bool
    {
        $expiresAt = $this->expiresAt();
        if (!isset($expiresAt)) {
            return false;
        }

        return Date::now($this->timezone)->gt($expiresAt);
    }

    /**
     * @inheritDoc
     */
    public function previous(): int|null
    {
        return $this->previous;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id(),
            'name' => $this->name(),
            'created_at' => $this->formatDate($this->createdAt()),
            'expires_at' => $this->formatDate($this->expiresAt()),
            'previous' => $this->previous()
        ];
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * @inheritdoc
     *
     * @throws UnknownStateException
     */
    protected function populate(array $data): static
    {
        return $this
            ->setPrevious($data['previous'] ?? null)
            ->setCreatedAt($data['created_at'] ?? null)
            ->setExpiresAt($data['expires_at'] ?? null);
    }

    /**
     * Set previous state identifier
     *
     * @param int|null $id [optional]
     *
     * @return self
     *
     * @throws UnknownStateException
     */
    protected function setPrevious(int|null $id = null): static
    {
        $this->assertStateIdentifier($id);

        $this->previous = $id;

        return $this;
    }

    /**
     * Set created at
     *
     * @param  DateTimeInterface|string|null  $createdAt [optional] Date and time of when this state was created
     *
     * @return self
     */
    protected function setCreatedAt(DateTimeInterface|string|null $createdAt = null): static
    {
        $this->createdAt = $this->resolveDate($createdAt);

        return $this;
    }

    /**
     * Set expires at
     *
     * @param  DateTimeInterface|string|null  $expiresAt [optional] Date and time of when this state expires
     *
     * @return self
     */
    protected function setExpiresAt(DateTimeInterface|string|null $expiresAt = null): static
    {
        $this->expiresAt = $this->resolveDate($expiresAt, null);

        return $this;
    }
}
