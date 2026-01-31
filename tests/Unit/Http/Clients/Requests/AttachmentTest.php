<?php

namespace Aedart\Tests\Unit\Http\Clients\Requests;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException;
use Aedart\Contracts\Http\Clients\Requests\Attachment as AttachmentInterface;
use Aedart\Http\Clients\Requests\Attachment;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use Codeception\Configuration;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * AttachmentTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Http\Clients\Requests
 */
#[Group(
    'http-clients',
    'attachment',
)]
class AttachmentTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new attachment instance
     *
     * @param array $data [optional]
     *
     * @return AttachmentInterface
     *
     * @throws Throwable
     */
    public function makeAttachment(array $data = []): AttachmentInterface
    {
        return new Attachment($data);
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/

    #[Test]
    public function canPopulateAttachment()
    {
        $attachment = $this->makeAttachment([ 'name' => $this->getFaker()->word() ])
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
     * @throws InvalidFilePathException
     * @throws Throwable
     */
    #[Test]
    public function canAttachFile()
    {
        $path = Configuration::dataDir() . 'http/clients/attachments/test.md';

        $contents = $this->makeAttachment()
                    ->name($this->getFaker()->word())
                    ->attachFile($path)
                    ->getContents();

        $this->assertIsResource($contents);
    }

    /**
     * @throws InvalidFilePathException
     * @throws Throwable
     */
    #[Test]
    public function failsIfPathToFileIsInvalid()
    {
        $this->expectException(InvalidFilePathException::class);

        $this->makeAttachment()
            ->attachFile('some_unknown_file_path.org');
    }
}
