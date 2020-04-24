<?php

namespace Aedart\Circuits\States;

use Aedart\Circuits\Concerns;
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
    use Concerns\Dates;
    use Concerns\Importable;
    use Concerns\Exportable;

    /**
     * State's name
     *
     * @var string
     */
    protected string $name;

    /**
     * Previous state identifier
     *
     * @var int|null
     */
    protected ?int $previous = null;

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
    protected ?DateTimeInterface $expiresAt = null;

    /**
     * BaseState constructor.
     *
     * @param array $data [optional]
     */
    public function __construct(array $data = [])
    {
        $this->populate($data);
    }

    /**
     * Create a new instance of this state
     *
     * @param array $data [optional]
     *
     * @return static
     */
    public static function make(array $data = [])
    {
        return new static($data);
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
    public function expiresAt(): ?DateTimeInterface
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
    public function previous(): ?int
    {
        return $this->previous;
    }

    /**
     * @inheritDoc
     */
    public function toArray()
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
     * Populate this state
     *
     * @param array $data
     */
    protected function populate(array $data)
    {
        $this
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
     */
    protected function setPrevious(?int $id = null)
    {
        $this->previous = $id;

        return $this;
    }

    /**
     * Set created at
     *
     * @param string|DateTimeInterface|null $createdAt [optional] Date and time of when this state was created
     *
     * @return self
     */
    protected function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $this->resolveDate($createdAt);

        return $this;
    }

    /**
     * Set expires at
     *
     * @param string|DateTimeInterface|null $expiresAt [optional] Date and time of when this state expires
     *
     * @return self
     */
    protected function setExpiresAt($expiresAt = null)
    {
        $this->expiresAt = $this->resolveDate($expiresAt, null);

        return $this;
    }
}
