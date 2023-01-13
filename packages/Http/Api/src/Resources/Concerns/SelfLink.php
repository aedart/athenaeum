<?php

namespace Aedart\Http\Api\Resources\Concerns;

use Aedart\Support\Facades\IoCFacade;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Concerns Self Link
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Api\Resources\Concerns
 */
trait SelfLink
{
    /**
     * A callback responsible for creating resource's
     * self link.
     *
     * @var callable|null
     */
    protected $selfLinkCallback = null;

    /**
     * Set this resource's self link
     *
     * @param  string|callable  $link   When callback is provided, it will receive the
     *                                  {@see Request} and this {@see \Aedart\Http\Api\Resources\ApiResource} as
     *                                  arguments. Callback MUST return a string or null.
     *
     * @return self
     */
    public function withSelfLink(string|callable $link): static
    {
        if (is_string($link)) {
            $link = fn () => $link;
        }

        $this->selfLinkCallback = $link;

        return $this;
    }

    /**
     * Generates this resource's self link
     *
     * @param  Request  $request
     *
     * @return string|null
     */
    public function makeSelfLink(Request $request): string|null
    {
        // Generate self link via callback, if available
        if (isset($this->selfLinkCallback)) {
            $callback = $this->selfLinkCallback;

            return $callback($request, $this);
        }

        // Default to guessing this resource's self link.
        $name = $this->resourceRouteName();

        if (Route::has($name)) {
            return $this->urlGenerator()->route($name, $this->getResourceKey());
        }

        return null;
    }

    /**
     * Route name for viewing a single resource of this type
     *
     * @return string
     */
    public function resourceRouteName(): string
    {
        $type = $this->pluralType();

        return "{$type}.show";
    }

    /**
     * Returns the application's url generator
     *
     * @return UrlGenerator
     */
    public function urlGenerator(): UrlGenerator
    {
        return IoCFacade::make('url');
    }
}
