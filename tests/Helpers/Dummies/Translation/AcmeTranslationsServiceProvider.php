<?php

namespace Aedart\Tests\Helpers\Dummies\Translation;

use Codeception\Configuration;
use Illuminate\Support\ServiceProvider;

/**
 * Acme Translations Service Provider
 *
 * FOR TESTING PURPOSES ONLY
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Helpers\Dummies\Translation
 */
class AcmeTranslationsServiceProvider extends ServiceProvider
{
    /**
     * Boots this provider
     *
     * @return void
     */
    public function boot(): void
    {
        $dataDir = Configuration::dataDir();

        $this->loadTranslationsFrom($dataDir . 'translation/lang', 'translation-test');

        $this->loadJsonTranslationsFrom($dataDir . 'translation/lang');

        // Not needed for tests...
        //        $this->publishes([
        //            $dataDir => $this->app->langPath('vendor/translation-test'),
        //        ]);
    }
}
