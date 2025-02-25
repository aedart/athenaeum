<?php

namespace Aedart\Auth\Fortify\Exceptions;

use Illuminate\Validation\ValidationException;
use Teapot\StatusCode\All as Status;

/**
 * Password Reset Link Failure Exception
 *
 * Intended to be thrown whenever an incorrect email is provided by the client, in the context
 * of attempting to reset a user's password.
 *
 * @see \Illuminate\Contracts\Auth\PasswordBroker::INVALID_USER
 * @see \Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse
 * @see \Aedart\Auth\Fortify\Responses\FailedPasswordResetLinkApiResponse
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Auth\Fortify\Exceptions
 */
class PasswordResetLinkFailure extends ValidationException
{
    /**
     * The status code to use for the response.
     *
     * Normally, a "422 Unprocessable Entity" error is returned to the client whenever an incorrect
     * email is requested. In an edge case, this could be used to determine if an email exists in
     * the application, by a malicious user. Therefore, here we simply switch to respond "200 Ok"!
     *
     * @var int
     */
    public $status = Status::OK;
}
