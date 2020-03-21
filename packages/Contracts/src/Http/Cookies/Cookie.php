<?php

namespace Aedart\Contracts\Http\Cookies;

use Aedart\Contracts\Utils\Populatable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Http Cookie
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Cookie
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Contracts\Http\Cookies
 */
interface Cookie extends Populatable,
    Arrayable
{
    /**
     * Set the cookie-name
     *
     * @param string $name
     *
     * @return self
     */
    public function name(string $name);

    /**
     * Returns the cookie-name
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Set the cookie-value
     *
     * @param string|null $value [optional]
     *
     * @return self
     */
    public function value(?string $value = null);

    /**
     * Returns the cookie-value
     *
     * @return string|null
     */
    public function getValue(): ?string;
}
