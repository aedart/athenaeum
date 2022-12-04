<?php

namespace Aedart\Http\Api\Responses;

use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Support\Collection;

/**
 * Api Resource Response
 *
 * Abstraction for Json based Api resource response
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Responses
 */
class ApiResourceResponse extends ResourceResponse
{
    /**
     * {@inheritdoc}
     *
     * @param array|Collection $data
     * @param array $with  [optional]
     * @param array $additional  [optional]
     */
    protected function wrap($data, $with = [], $additional = []): array
    {
        if ($data instanceof Collection) {
            $data = $data->all();
        }

        // Ensure that the out-most date is removed. This differs slightly from Laravel's
        // default way of handling wrapping of the payload
        if ($this->haveDefaultWrapperAndDataIsUnwrapped($data)) {
            $data = [ $this->wrapper() => $data ];
        }

        return array_merge_recursive($data, $with, $additional);
    }
}
