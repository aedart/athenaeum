<?php

namespace Aedart\Tests\Integration\Auth\Fortify;

use Aedart\Auth\Fortify\Exceptions\PasswordResetLinkFailure;
use Aedart\Auth\Fortify\Responses\FailedPasswordResetLinkApiResponse;
use Aedart\Tests\TestCases\Auth\FortifyTestCase;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Request;

/**
 * FailedPasswordResetLinkApiResponseTest
 *
 * @group auth
 * @group fortify
 * @group failed-password-reset-link-api-response
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Tests\Integration\Auth\Fortify
 */
class FailedPasswordResetLinkApiResponseTest extends FortifyTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function throwsPasswordResetLinkFailureWhenRequestIsJson(): void
    {
        $this->expectException(PasswordResetLinkFailure::class);

        $request = Request::create(
            uri: 'https://acme.com/api/v1/password-reset',
            method: 'POST',
            server:  [
                'HTTP_ACCEPT' => 'application/json'
            ],
        );

        (new FailedPasswordResetLinkApiResponse(PasswordBroker::INVALID_USER))
            ->toResponse($request);
    }
}
