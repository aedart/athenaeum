<?php


namespace Aedart\Tests\Unit\Core\Helpers;

use Aedart\Contracts\Core\Helpers\NamespaceDetector as NamespaceDetectorInterface;
use Aedart\Core\Helpers\NamespaceDetector;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use Codeception\Configuration;
use PHPUnit\Framework\Attributes\Test;

/**
 * NamespaceDetectorTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Core\Helpers
 */
#[Group(
    'core',
    'application',
    'application-helpers',
    'namespace-detector'
)]
class NamespaceDetectorTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns a new application namespace detector instance
     *
     * @return NamespaceDetectorInterface
     */
    protected function makeDetector(): NamespaceDetectorInterface
    {
        return new NamespaceDetector();
    }

    /**
     * Returns full path to given composer file
     *
     * @param string $file
     *
     * @return string
     */
    protected function composerFile(string $file): string
    {
        return Configuration::dataDir() . 'core/helpers/detector/' . $file;
    }

    /**
     * Returns path to a valid composer.json file
     *
     * @return string
     */
    protected function validComposerFile(): string
    {
        return $this->composerFile('valid-composer.json');
    }

    /**
     * Returns path to an invalid composer.json file
     *
     * @return string
     */
    protected function invalidComposerFile(): string
    {
        return $this->composerFile('invalid-composer.json');
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @throws \RuntimeException
     */
    #[Test]
    public function canDetectNamespace()
    {
        $namespace = $this->makeDetector()->detect($this->validComposerFile());
        ConsoleDebugger::output($namespace);

        $this->assertSame('Aedart\\', $namespace);
    }

    /**
     * @throws \RuntimeException
     */
    #[Test]
    public function failsIfComposerFileDoesNotExist()
    {
        $this->expectException(\RuntimeException::class);

        $this->makeDetector()->detect($this->composerFile('uknown-composer-file.json'));
    }

    /**
     * @throws \RuntimeException
     */
    #[Test]
    public function failsIfComposerFileDoesNotHavePsr4()
    {
        $this->expectException(\RuntimeException::class);

        $this->makeDetector()->detect($this->invalidComposerFile());
    }
}
