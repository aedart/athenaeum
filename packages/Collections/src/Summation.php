<?php

namespace Aedart\Collections;

use Aedart\Collections\Exceptions\KeyNotFound;
use Aedart\Collections\Exceptions\UnsupportedArithmeticOperator;
use Aedart\Contracts\Collections\Summation as SummationInterface;
use Aedart\Utils\Arr;
use Aedart\Utils\Json;
use ArrayIterator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use JsonSerializable;
use Symfony\Component\VarDumper\VarDumper;
use Traversable;

/**
 * Summation Collection
 *
 * @see \Aedart\Contracts\Collections\Summation
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Collections
 */
class Summation implements SummationInterface
{
    /**
     * Results
     *
     * @var array Key-value pairs
     */
    protected array $results = [];

    /**
     * Summation constructor.
     *
     * @param  Arrayable|iterable  $results  [optional]
     */
    public function __construct(Arrayable|iterable $results = [])
    {
        $this->results = $this->retrieveResultsFrom($results);
    }

    /**
     * @inheritDoc
     */
    public static function make(Arrayable|iterable $results = []): static
    {
        return new static($results);
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, mixed $value): static
    {
        if (is_callable($value)) {
            return $this->apply($key, $value);
        }

        Arr::set($this->results, $key, $value);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($this->results, $key, $default);
    }

    /**
     * @inheritDoc
     */
    public function increase(string $key, callable|float|int $amount = 1): static
    {
        return $this->add($key, $amount);
    }

    /**
     * @inheritDoc
     */
    public function decrease(string $key, callable|float|int $amount = 1): static
    {
        return $this->subtract($key, $amount);
    }

    /**
     * @inheritDoc
     */
    public function add(string $key, callable|float|int $amount): static
    {
        return $this->arithmeticOperation($key, $amount, '+');
    }

    /**
     * @inheritDoc
     */
    public function subtract(string $key, callable|float|int $amount): static
    {
        return $this->arithmeticOperation($key, $amount, '-');
    }

    /**
     * @inheritDoc
     */
    public function multiply(string $key, callable|float|int $amount): static
    {
        return $this->arithmeticOperation($key, $amount, '*');
    }

    /**
     * @inheritDoc
     */
    public function divide(string $key, callable|float|int $amount): static
    {
        return $this->arithmeticOperation($key, $amount, '/');
    }

    /**
     * @inheritDoc
     */
    public function apply(string $key, callable $callback): static
    {
        $original = $this->get($key);

        return $this->applyCallback($key, $callback, $original);
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        return Arr::has($this->results, $key);
    }

    /**
     * @inheritDoc
     */
    public function hasValue(string $key): bool
    {
        if (!$this->has($key)) {
            return false;
        }

        $value = $this->get($key);

        return !empty($value);
    }

    /**
     * @inheritDoc
     */
    public function hasNoValue(string $key): bool
    {
        return !$this->hasValue($key);
    }

    /**
     * @inheritDoc
     */
    public function isEmpty(): bool
    {
        return empty($this->results);
    }

    /**
     * @inheritDoc
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * @inheritDoc
     */
    public function remove(string $key): bool
    {
        if ($this->has($key)) {
            Arr::forget($this->results, $key);
            return true;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->results);
    }

    /**
     * @inheritDoc
     */
    public function dd(): void
    {
        $this->dump();

        exit(1);
    }

    /**
     * @inheritDoc
     */
    public function dump(): static
    {
        VarDumper::dump($this->results);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->results);
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return array_map(function ($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, $this->results);
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0): string
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): mixed
    {
        return array_map(function ($value) {
            if ($value instanceof JsonSerializable) {
                return $value->jsonSerialize();
            } elseif ($value instanceof Arrayable) {
                return $value->toArray();
            }

            return $value;
        }, $this->toArray());
    }

    /**
     * @inheritDoc
     */
    public function __toString(): string
    {
        return $this->toJson();
    }

    /**
     * @inheritDoc
     */
    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset(mixed $offset): void
    {
        $this->remove($offset);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Retrieve results from given source
     *
     * @param  mixed  $source  [optional]
     *
     * @return array
     */
    protected function retrieveResultsFrom(Arrayable|iterable $source = []): array
    {
        // Use Laravel's Collection to resolve results.
        return Arr::undot(
            Collection::make($source)->all()
        );
    }

    /**
     * Performs an arithmetic operation on key's value.
     *
     * @param  string  $key
     * @param  callable|float|int  $amount If amount is a callback, then
     *                                    callback is invoked with key's value and this
     *                                    Summation as arguments. The resulting output is
     *                                    set as key's new value.
     * @param  string  $operator  [optional] Operator symbol: '+', '-', '*', or '/'
     *
     * @return self
     *
     * @throws KeyNotFound
     * @throws UnsupportedArithmeticOperator
     */
    protected function arithmeticOperation(string $key, callable|float|int $amount, string $operator = '+'): static
    {
        $value = $this
            ->assertKeyExists($key)
            ->get($key);

        if (is_callable($amount)) {
            return $this->applyCallback($key, $amount, $value);
        }

        $result = match ($operator) {
            '+' => $value + $amount,
            '-' => $value - $amount,
            '*' => $value * $amount,
            '/' => $value / $amount,
            default => throw new UnsupportedArithmeticOperator(sprintf('Operator %s is not supported', $operator))
        };

        return $this->set($key, $result);
    }

    /**
     * Applies given callback and sets key's value
     *
     * @param  string  $key
     * @param  callable  $callback
     * @param  mixed  $value  [optional] If provided, then this value is passed on as
     *                        callback's argument, along with this Summation instance
     *
     * @return self
     */
    protected function applyCallback(string $key, callable $callback, mixed $value = null): static
    {
        return $this->set($key, $callback($value, $this));
    }

    /**
     * Assert that given key exists
     *
     * @param  string  $key
     *
     * @return self
     *
     * @throws KeyNotFound
     */
    protected function assertKeyExists(string $key): static
    {
        if (!$this->has($key)) {
            throw new KeyNotFound(sprintf('Key %s does not exist', $key));
        }

        return $this;
    }
}
