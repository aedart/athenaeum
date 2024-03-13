<?php

namespace Aedart\Tests\Helpers\Dummies\Translation;

use Codeception\Configuration;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Deferrable Translations Service Provider
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Translation
 */
class DeferrableTranslationsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    // Here we simulate a provider that ... well, has translations, but isn't booted
    // or hasn't published them.

    /**
     * Boot this service...
     *
     * @return void
     */
    //    public function boot(): void
    //    {
    //        $dataDir = Configuration::dataDir();
    //
    //        $this->loadTranslationsFrom($dataDir . 'translation/deferrable', 'deferrable');
    //
    //        $this->loadJsonTranslationsFrom($dataDir . 'translation/deferrable');
    //    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return [ 'deferrable.translations' ];
    }
}
