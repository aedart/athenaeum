<?php

namespace Aedart\ETags\Providers;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\Factory as ETagGeneratorFactory;
use Aedart\Contracts\ETags\Preconditions\RangeValidator as RangeValidatorInterface;
use Aedart\ETags\ETag;
use Aedart\ETags\ETagsCollection;
use Aedart\ETags\Factory;
use Aedart\ETags\Mixins\RequestETagsMixin;
use Aedart\ETags\Mixins\ResponseETagsMixin;
use Aedart\ETags\Preconditions\Validators\RangeValidator;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use ReflectionException;

/**
 * ETags Service Provider
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\ETags\Providers
 */
class ETagsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        ETagGeneratorFactory::class => Factory::class,
    ];

    /**
     * @inheritdoc
     */
    public function register()
    {
        // Register ETag class path that generator factory must use...
        // @see \Aedart\ETags\Factory::eTagClass
        $this->app->singleton('etag_class', fn () => ETag::class);

        $this->app->bind(Collection::class, function ($app, array $etags = []) {
            return ETagsCollection::make($etags);
        });

        $this->app->bind(RangeValidatorInterface::class, function($app, array $arguments = []) {
            $rangeUnit = $arguments['rangeUnit'] ?? 'bytes';
            $maxRangeSets = $arguments['maxRangeSets'] ?? 5;

            return new RangeValidator($rangeUnit, $maxRangeSets);
        });
    }

    /**
     * Bootstrap this service
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../configs/etags.php' => config_path('etags.php')
        ], 'config');

        $this->installMixins();
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            ETagGeneratorFactory::class,
            Collection::class,
            'etag_class',
            RangeValidatorInterface::class
        ];
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Installs Request & Response mixins
     *
     * @return void
     *
     * @throws ReflectionException
     */
    protected function installMixins(): void
    {
        $requestMixin = new RequestETagsMixin();
        $responseMixin = new ResponseETagsMixin();

        Request::mixin($requestMixin);

        Response::mixin($responseMixin);
        JsonResponse::mixin($responseMixin);
    }
}
