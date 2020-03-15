<?php

namespace Aedart\Tests\Unit\Http\Clients\Requests;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException;
use Aedart\Contracts\Http\Clients\Requests\Attachment as AttachmentInterface;
use Aedart\Http\Clients\Requests\Attachment;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Configuration;

/**
 * AttachmentTest
 *
 * @group http-clients
 * @group attachment
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Http\Clients\Requests
 */
class AttachmentTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new attachment instance
     *
     * @param string|null $name [optional] If none given, a name will be generated
     *
     * @return AttachmentInterface
     */
    public function makeAttachment(?string $name = null): AttachmentInterface
    {
        $name = $name ?? $this->getFaker()->word;

        return new Attachment($name);
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/

    /**
     * @test
     */
    public function canPopulateAttachment()
    {
        $attachment = $this->makeAttachment()
            ->headers(['X-Foo' => 'bar'])
            ->contents('Hi there')
            ->filename('my_file.txt');

        $data = $attachment->toArray();

        $this->assertNotEmpty($data['name']);
        $this->assertSame(['X-Foo' => 'bar'], $data['headers']);
        $this->assertSame('Hi there', $data['contents']);
        $this->assertSame('my_file.txt', $data['filename']);
    }

    /**
     * @test
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException
     */
    public function canAttachFile()
    {
        $path = Configuration::dataDir() . 'http/clients/attachments/test.md';

        $contents = $this->makeAttachment()
                    ->attachFile($path)
                    ->getContents();

        $this->assertIsResource($contents);
    }

    /**
     * @test
     *
     * @throws \Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException
     */
    public function failsIfPathToFileIsInvalid()
    {
        $this->expectException(InvalidFilePathException::class);

        $this->makeAttachment()
            ->attachFile('some_unknown_file_path.org');
    }
}
