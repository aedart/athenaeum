<?php

namespace Aedart\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

/**
 * Transforms Request Middleware
 *
 * Abstraction is heavily inspired by Laravel's `TransformsRequest` middleware.
 * @see \Illuminate\Foundation\Http\Middleware\TransformsRequest
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Http\Middleware
 */
abstract class TransformsRequest
{
    /**
     * Transforms the given request
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldTransform($request)) {
            $this->clean($request);
        }

        return $next($request);
    }

    /**
     * Clean or transform given value
     *
     * @param string $key Parameter name
     * @param mixed $value
     *
     * @return mixed
     */
    abstract public function transform(string $key, $value);

    /**
     * Determines if value cleaning or transformation should be
     * skipped for given key-value pair
     *
     * @param string $key
     * @param mixed $value
     *
     * @return bool
     */
    public function shouldIgnore(string $key, $value): bool
    {
        // Overwrite this method with your own ignore logic
        return false;
    }

    /**
     * Determines if this middleware should transform
     * request or not
     *
     * @param Request $request
     *
     * @return bool
     */
    public function shouldTransform(Request $request): bool
    {
        // Overwrite this method with your own apply or skip logic.
        // This can be used to skip requests that are of a specific
        // nature, e.g. all GET requests should be ignored...
        return true;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Clean or transform request's data
     *
     * @param Request $request
     *
     * @return void
     */
    protected function clean(Request $request): void
    {
        $this->cleanParameters($request->query);

        if ($request->isJson()) {
            $this->cleanParameters($request->json());
        } else if ($request->request !== $request->query) {
            $this->cleanParameters($request->request);
        }
    }

    /**
     * Clean or transform parameters
     *
     * @param ParameterBag $parameters
     *
     * @return void
     */
    protected function cleanParameters(ParameterBag $parameters)
    {
        $parameters->replace(
            $this->cleanArray($parameters->all())
        );
    }

    /**
     * Clean or transform values in given array
     *
     * @param array $data
     * @param string $keyPrefix [optional]
     *
     * @return array Key-value pairs
     */
    protected function cleanArray(array $data, string $keyPrefix = ''): array
    {
        $output = [];

        foreach ($data as $key => $value) {
            $output[$key] = $this->cleanValue("{$keyPrefix}{$key}", $value);
        }

        return collect($output)->all();
    }

    /**
     * Processes given key-value pair.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    protected function cleanValue(string $key, $value)
    {
        if (is_array($value)) {
            return $this->cleanArray($value, "{$key}.");
        }

        if ($this->shouldIgnore($key, $value)) {
            return $value;
        }

        return $this->transform($key, $value);
    }
}