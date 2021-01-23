<?php

namespace Aedart\Collections;

use Aedart\Collections\Exceptions\KeyNotFound;
use Aedart\Collections\Exceptions\UnsupportedArithmeticOperator;
use Aedart\Collections\Exceptions\ValueNotNumeric;
use Aedart\Contracts\Collections\Summation as SummationInterface;
use Aedart\Utils\Arr;
use Aedart\Utils\Json;
use ArrayIterator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use JsonSerializable;
use Symfony\Component\VarDumper\VarDumper;

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
     * @param  mixed  $results  [optional]
     */
    public function __construct($results = [])
    {
        $this->results = $this->retrieveResultsFrom($results);
    }

    /**
     * @inheritDoc
     */
    public static function make($results = []): SummationInterface
    {
        return new static($results);
    }

    /**
     * @inheritDoc
     */
    public function set(string $key, $value): SummationInterface
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
    public function get(string $key, $default = null)
    {
        return Arr::get($this->results, $key, $default);
    }

    /**
     * @inheritDoc
     */
    public function increase(string $key, $amount = 1): SummationInterface
    {
        return $this->add($key, $amount);
    }

    /**
     * @inheritDoc
     */
    public function decrease(string $key, $amount = 1): SummationInterface
    {
        return $this->subtract($key, $amount);
    }

    /**
     * @inheritDoc
     */
    public function add(string $key, $amount): SummationInterface
    {
        return $this->arithmeticOperation($key, $amount, '+');
    }

    /**
     * @inheritDoc
     */
    public function subtract(string $key, $amount): SummationInterface
    {
        return $this->arithmeticOperation($key, $amount, '-');
    }

    /**
     * @inheritDoc
     */
    public function multiply(string $key, $amount): SummationInterface
    {
        return $this->arithmeticOperation($key, $amount, '*');
    }

    /**
     * @inheritDoc
     */
    public function divide(string $key, $amount): SummationInterface
    {
        return $this->arithmeticOperation($key, $amount, '/');
    }

    /**
     * @inheritDoc
     */
    public function apply(string $key, callable $callback): SummationInterface
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

        return empty($value);
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
    public function count()
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
    public function dump(): SummationInterface
    {
        VarDumper::dump($this->results);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->results);
    }

    /**
     * @inheritDoc
     */
    public function toArray()
    {
        return array_map(function ($value) {
            return $value instanceof Arrayable ? $value->toArray() : $value;
        }, $this->results);
    }

    /**
     * @inheritDoc
     */
    public function toJson($options = 0)
    {
        return Json::encode($this->jsonSerialize(), $options);
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
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
    public function __toString()
    {
        return $this->toJson();
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
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
    protected function retrieveResultsFrom($source = []): array
    {
        // Use Laravel's Collection to resolve results.
        return Collection::make($source)->all();
    }

    /**
     * Performs an arithmetic operation on key's value.
     *
     * @param  string  $key
     * @param  int|float|callable $amount If amount is a callback, then
     *                                    callback is invoked with key's value and this
     *                                    Summation as arguments. The resulting output is
     *                                    set as key's new value.
     * @param  string  $operator  [optional] Operator symbol: '+', '-', '*', or '/'
     *
     * @return self
     *
     * @throws KeyNotFound
     * @throws ValueNotNumeric
     * @throws UnsupportedArithmeticOperator
     */
    protected function arithmeticOperation(string $key, $amount, string $operator = '+'): SummationInterface
    {
        $value = $this
            ->assertKeyExists($key)
            ->getNumericValue($key);

        if (is_callable($amount)) {
            return $this->applyCallback($key, $amount, $value);
        }

        $result = null;
        switch ($operator) {
            case '+':
                $result = $value + $amount;
                break;

            case '-':
                $result = $value - $amount;
                break;

            case '*':
                $result = $value * $amount;
                break;

            case '/':
                $result = $value / $amount;
                break;

            default:
                throw new UnsupportedArithmeticOperator(sprintf('Operator %s is not supported', $operator));
        }

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
    protected function applyCallback(string $key, callable $callback, $value = null): SummationInterface
    {
        return $this->set($key, $callback($value, $this));
    }

    /**
     * Returns the value for given key, if it is numeric.
     * Fails if key's value is not numeric.
     *
     * @see assertKeyExists
     *
     * @param  string  $key
     *
     * @return int|float
     *
     * @throws ValueNotNumeric
     */
    protected function getNumericValue(string $key)
    {
        $value = $this->get($key);
        if (!is_numeric($value)) {
            throw new ValueNotNumeric(sprintf('Value for key %s is not numeric.', $key));
        }

        return $value;
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
    protected function assertKeyExists(string $key): SummationInterface
    {
        if (!$this->has($key)) {
            throw new KeyNotFound(sprintf('Key %s does not exist', $key));
        }

        return $this;
    }
}
