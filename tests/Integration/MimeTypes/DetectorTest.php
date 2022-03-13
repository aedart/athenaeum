<?php

namespace Aedart\Tests\Integration\MimeTypes;

use Aedart\Contracts\MimeTypes\Detector;
use Aedart\Contracts\MimeTypes\Exceptions\MimeTypeDetectionException;
use Aedart\Contracts\MimeTypes\Sampler;
use Aedart\MimeTypes\Exceptions\ProfileNotFound;
use Aedart\Tests\TestCases\MimeTypes\MimeTypesTestCase;

/**
 * DetectorTest
 *
 * @group mime-types
 * @group mime-types-detector
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\MimeTypes
 */
class DetectorTest extends MimeTypesTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canObtainDetector()
    {
        $detector = $this->getMimeTypeDetector();

        $this->assertNotNull($detector);
        $this->assertInstanceOf(Detector::class, $detector);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    public function canMakeSamplerInstance()
    {
        $sampler = $this
            ->getMimeTypeDetector()
            ->makeSampler('');

        $this->assertNotNull($sampler);
        $this->assertInstanceOf(Sampler::class, $sampler);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws MimeTypeDetectionException
     */
    public function failsWhenSamplerProfileDoesNotExist()
    {
        $this->expectException(ProfileNotFound::class);

        $this
            ->getMimeTypeDetector()
            ->makeSampler('', 'unknown_profile');
    }
}
