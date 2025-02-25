<?php

namespace Aedart\Auth\Fortify\Responses;

use Aedart\Auth\Fortify\Exceptions\PasswordResetLinkFailure;
use Laravel\Fortify\Http\Responses\FailedPasswordResetLinkRequestResponse as BaseResponse;

/**
 * Failed Password Reset Link Request Response
 *
 * @see \Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse
 *
 * @author Alin Eugen Deac <ade@rspsystems.com>
 * @package Aedart\Auth\Fortify\Responses
 */
class FailedPasswordResetLinkApiResponse extends BaseResponse
{
    /**
     * @inheritdoc
     *
     * @throws PasswordResetLinkFailure
     */
    public function toResponse($request)
    {
        // In case that request was performed by an API Client (json), simply fail silently,
        // without any error messages. See the `PasswordResetLinkFailure` for details!

        if ($request->wantsJson()) {
            throw PasswordResetLinkFailure::withMessages([]);
        }

        // Otherwise, redirect to the previous URL (original behaviour...).
        // CAUTION: This can reveal that the user does not exist!
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($this->status)]);
    }
}
