<?php

namespace Aedart\Tests\Integration\MimeTypes;

use Aedart\Contracts\MimeTypes\Detector;
use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\Contracts\MimeTypes\MimeType;
use Aedart\Contracts\MimeTypes\Sampler;
use Aedart\MimeTypes\Exceptions\FileNotFound;
use Aedart\MimeTypes\Exceptions\ProfileNotFound;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\MimeTypes\MimeTypesTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * DetectorTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\MimeTypes
 */
#[Group(
    'mime-types',
    'mime-types-detector',
)]
class DetectorTest extends MimeTypesTestCase
{
    /**
     * @return void
     */
    #[Test]
    public function canObtainDetector()
    {
        $detector = $this->getMimeTypeDetector();

        $this->assertNotNull($detector);
        $this->assertInstanceOf(Detector::class, $detector);
    }

    /**
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    #[Test]
    public function canMakeSamplerInstance()
    {
        $sampler = $this
            ->getMimeTypeDetector()
            ->makeSampler('');

        $this->assertNotNull($sampler);
        $this->assertInstanceOf(Sampler::class, $sampler);
    }

    /**
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    #[Test]
    public function failsWhenSamplerProfileDoesNotExist()
    {
        $this->expectException(ProfileNotFound::class);

        $this
            ->getMimeTypeDetector()
            ->makeSampler('', 'unknown_profile');
    }

    /**
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    #[Test]
    public function canDetectMimeTypeUsingFilePath()
    {
        $file = $this->filePath('txt');
        $mimeType = $this
            ->getMimeTypeDetector()
            ->detectForFile($file);

        ConsoleDebugger::output($mimeType);

        $this->assertInstanceOf(MimeType::class, $mimeType);
        $this->assertSame('text/plain', $mimeType->type());
    }

    /**
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    #[Test]
    public function failsIfFileNotFound()
    {
        $this->expectException(FileNotFound::class);

        $this
            ->getMimeTypeDetector()
            ->detectForFile('some_unknown_file.txt');
    }

    /**
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    #[Test]
    public function hasSampleSizeSetInSample(): void
    {
        // When using inside Laravel, a default sample size SHOULD be
        // set automatically.
        // @see https://github.com/aedart/athenaeum/issues/191
        $stream = $this->getFileStream('txt');
        $sampler = $this->getMimeTypeDetector()->makeSampler($stream);

        $this->assertGreaterThan(0, $sampler->getSampleSize());
    }
}
