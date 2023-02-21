<?php

namespace Aedart\Tests\Integration\Translation;

use Aedart\Contracts\Translation\TranslationsLoader;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Translation\TranslationTestCase;

/**
 * @deprecated 
 *
 * TranslationLoaderTest
 *
 * @group translations
 * @group translations-loader
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Translation
 */
class TranslationLoaderTest extends TranslationTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canObtainLoader(): void
    {
        $result = $this->getLoader();

        $this->assertInstanceOf(TranslationsLoader::class, $result);
    }

    /**
     * @test
     *
     * @return void
     */
    public function hasPathsSet(): void
    {
        $paths = $this->getLoader()->getPaths();

        ConsoleDebugger::output($paths);

        // We expect paths to application's lang dir, Illuminate Translation lang,
        // and at least one more path to a 3rd party package...
        $this->assertGreaterThanOrEqual(3, $paths);
    }

    /**
     * @test
     *
     * @return void
     */
    public function canDetectAvailableLocales(): void
    {
        $locales = $this->getLoader()->detectLocals();

        ConsoleDebugger::output($locales);

        $this->assertGreaterThanOrEqual(3, $locales);

        $this->assertTrue(in_array('en', $locales), 'en not detected');
        $this->assertTrue(in_array('en-uk', $locales), 'en-uk not detected');
        $this->assertTrue(in_array('da', $locales), 'da not detected');
    }

//    /**
//     * @test
//     *
//     * @return void
//     */
//    public function whatIsInTheTranslator(): void
//    {
//        $trans = $this->getTranslator();
//        $loader = $this->getTranslationLoader();
//
////        $trans->get('athenaeum-http-api::api-resources.record_not_found', [ 'record' => 'hmmm' ]);
////        $trans->get('auth.password');
////        $trans->get('translation-test::users.messages.c');
//
//        dump([
////            'attempt' => $loader->load('da', '*', '*')
//            'attempt' => $trans->get('*', [], 'en-uk')
//        ]);
//
//        dump([
//            'translator' => $trans,
//            '-----------------------------------------------------',
//            'namespaces' => $loader->namespaces(),
//            'json_paths' => $loader->jsonPaths(), // TODO: MIGHT BE ARRAY LOADER... SO this method does not exist!!!
//            'app_lang_path' => app()->langPath()
//        ]);
//    }
}
