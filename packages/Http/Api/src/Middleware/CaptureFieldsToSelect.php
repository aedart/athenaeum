<?php

namespace Aedart\Http\Api\Middleware;

use Aedart\Contracts\Http\Api\SelectedFieldsCollection as SelectedFieldsCollectionInstance;
use Aedart\Http\Api\Resources\SelectedFieldsCollection;
use Aedart\Support\Helpers\Container\ContainerTrait;
use Aedart\Support\Helpers\Validation\ValidatorFactoryTrait;
use Aedart\Validation\Rules\AlphaDashDot;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Capture Fields To Select Middleware
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Middleware
 */
class CaptureFieldsToSelect
{
    use ValidatorFactoryTrait;
    use ContainerTrait;

    /**
     * Name of the query parameter that holds requested fields
     *
     * @var string
     */
    protected string $selectQueryKey;

    /**
     * Captures "select" query parameter
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string  $key  [optional] Name of the query parameter that holds fields to selected
     *
     * @return mixed
     *
     * @throws ValidationException
     */
    public function handle(Request $request, Closure $next, string $key = 'select'): mixed
    {
        $this->selectQueryKey = $key;

        $raw = $request->query($key);

        // When no "select" query parameter is received, skip to next...
        if (!isset($raw)) {
            return $next($request);
        }

        // Prepare, validate and save the fields to be selected
        $this->save(
            $this->prepareSelectedFields($raw)
        );

        // Process the request
        $response = $next($request);

        // Cleanup - remove evt. saved fields
        $this->cleanup();

        // Finally, return the response
        return $response;
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Save the fields to be selected
     *
     * @param  string[]  $fields
     *
     * @return void
     */
    protected function save(array $fields): void
    {
        $this->getContainer()->singleton(SelectedFieldsCollectionInstance::class, function () use ($fields) {
            return new SelectedFieldsCollection($fields);
        });
    }

    /**
     * Removes the fields to be selected, if any were saved
     *
     * @return void
     */
    protected function cleanup(): void
    {
        unset($this->getContainer()[SelectedFieldsCollectionInstance::class]);
    }

    /**
     * Prepares the selected fields
     *
     * @param mixed $input Raw query parameter value
     *
     * @return array
     *
     * @throws ValidationException
     * @throws BadRequestHttpException
     */
    protected function prepareSelectedFields(mixed $input): array
    {
        $input = match (true) {
            is_string($input) => explode(',', $input),
            is_array($input) => $input,
            default => throw new BadRequestHttpException(sprintf('Malformed %s query parameter', $this->selectQueryKey))
        };

        $fields = $this->validateSelectedFields($input);

        return array_map(function ($field) {
            return strtolower(trim($field));
        }, $fields);
    }

    /**
     * Validates requested fields
     *
     * @param  string[]  $fields
     * @return string[]
     *
     * @throws ValidationException
     */
    protected function validateSelectedFields(array $fields): array
    {
        $key = $this->selectQueryKey;

        $validator = $this->getValidatorFactory()->make([ $key => $fields ], [
            $key => 'array|min:1|max:20',
            "{$key}.*" => [
                'string',
                new AlphaDashDot(),
                'min:1',
                'max:50'
            ]
        ]);

        $data = $validator->validate();

        return $data[$key];
    }
}
