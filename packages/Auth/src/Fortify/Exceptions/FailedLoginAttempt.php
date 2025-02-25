<?php

namespace Aedart\Auth\Fortify\Exceptions;

use Illuminate\Validation\ValidationException;
use Teapot\StatusCode\All as Status;

/**
 * Failed Login Attempt Exception
 *
 * Should be thrown whenever a login attempt has failed.
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Auth\Fortify\Exceptions
 */
class FailedLoginAttempt extends ValidationException
{
    /**
     * The status code to use for the response.
     *
     * @var int
     */
    public $status = Status::UNAUTHORIZED;
}
