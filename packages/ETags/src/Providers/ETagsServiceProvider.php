<?php

namespace Aedart\ETags\Providers;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\Factory as ETagGeneratorFactory;
use Aedart\ETags\ETag;
use Aedart\ETags\ETagsCollection;
use Aedart\ETags\Factory;
//use Aedart\ETags\Mixins\RequestETagsMixin;
use Aedart\ETags\Mixins\ResponseETagsMixin;
use Illuminate\Contracts\Support\DeferrableProvider;
//use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;

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
        // Register the ETag class path that the generator factory
        // must use...
        // @see \Aedart\ETags\Factory::eTagClass
        $this->app->singleton('etag_class', fn() => ETag::class);

        $this->app->bind(Collection::class, function($app, array $etags = []) {
            return ETagsCollection::make($etags);
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

        // Install mixins / macros
//        Request::mixin(new RequestETagsMixin());
        Response::mixin(new ResponseETagsMixin());
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [
            ETagGeneratorFactory::class,
            Collection::class,
            'etag_class'
        ];
    }
}