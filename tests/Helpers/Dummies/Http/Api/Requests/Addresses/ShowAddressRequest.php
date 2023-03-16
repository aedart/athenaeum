<?php

namespace Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Addresses;

use Aedart\Http\Api\Requests\Concerns;
use Aedart\Http\Api\Requests\Resources\ShowSingleResourceRequest;
use Aedart\Tests\Helpers\Dummies\Http\Api\Models\Address;
use Illuminate\Database\Eloquent\Model;

/**
 * Show Address Request
 *
 * FOR TESTING PURPOSES ONLY!
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Http\Api\Requests\Addresses
 */
class ShowAddressRequest extends ShowSingleResourceRequest
{
    use Concerns\RouteParametersValidation;

    /**
     * The requested address
     *
     * @var Address
     */
    public Address $address;

    /**
     * @inheritDoc
     */
    public function routeParameterRules(): array
    {
        return [
            'address' => [ 'required', 'integer', 'gt:0' ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function findRecordOrFail(): Model
    {
        $identifier = $this->route('address');

        return $this->address = Address::findOrFail($identifier);
    }

    /**
     * @inheritDoc
     */
    public function authorizeFoundRecord(Model $record): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function mustEvaluatePreconditions(): bool
    {
        return false;
    }
}
