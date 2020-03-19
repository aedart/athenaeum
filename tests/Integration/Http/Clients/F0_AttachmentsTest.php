<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Http\Clients\Requests\Attachment;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Configuration;

/**
 * F0_AttachmentsTest
 *
 * @group http-clients
 * @group http-clients-f0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class F0_AttachmentsTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/



    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function extractsAttachmentsFromOptions(string $profile)
    {
        $pathPrefix = $this->attachmentsPath();
        $fileA = $pathPrefix . 'config.ini';
        $fileB = $pathPrefix . 'lipsum.txt';
        $data = 'Be soft.';
        $address = 'Somewhere Street 33 Ltd.';

        $attachments = [
            [
                'name' => 'setup',
                'contents' => fopen($fileA, 'r'),
                'headers' => [ 'X-Foo' => 'bar' ],
                'filename' => 'setup.ini'
            ],
            [
                'name' => 'text',
                'contents' => fopen($fileB, 'r'),
            ],
            [
                'name' => 'slogan',
                'contents' => $data,
            ],

            // Not an attachment (not sure if valid Guzzle option)
            'address' => $address
        ];

        $client = $this->client($profile, [
            'multipart' => $attachments
        ]);

        // ----------------------------------------------------------- //

        $this->assertTrue($client->hasAttachment('setup'), 'FileA not part of attachments');
        $this->assertSame($attachments[0]['contents'], $client->getAttachment('setup')->getContents(), 'FileA incorrect contents');
        $this->assertSame($attachments[0]['headers'], $client->getAttachment('setup')->getHeaders(), 'FileA incorrect headers');
        $this->assertSame($attachments[0]['filename'], $client->getAttachment('setup')->getFilename(), 'FileA incorrect filename');

        $this->assertTrue($client->hasAttachment('text'), 'FileB not part of attachments');
        $this->assertSame($attachments[1]['contents'], $client->getAttachment('text')->getContents(), 'FileB incorrect contents');

        $this->assertTrue($client->hasAttachment('slogan'), '"slogan" not part of attachments');
        $this->assertSame($attachments[2]['contents'], $client->getAttachment('slogan')->getContents(), 'Incorrect contents for "slogan" attachments');

        // ----------------------------------------------------------- //

        $dataFromBuilder = $client->getData();
        $this->assertSame([ 'address' => $address ], $dataFromBuilder, 'Additional data not set');
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     * @throws InvalidFilePathException
     */
    public function canAttachUsingAttachmentInstance(string $profile)
    {
        $file = $this->attachmentsPath() . 'config.ini';

        $attachment = $this->makeAttachment('fileA')
            ->attachFile($file)
            ->headers([ 'X-Foo' => 'bar' ])
            ->filename('setup.ini');

        $builder = $this->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withAttachment('setup', $attachment);

        $builder->post('/records');

        // --------------------------------------------------------------- //

        $this->assertTrue($builder->hasAttachment('setup'), 'file not in builder');

        // --------------------------------------------------------------- //

        $request = $this->lastRequest;
        $contents = $request->getBody()->getContents();
        ConsoleDebugger::output($contents);

        $this->assertAttachmentInPayload(
            $contents,
            'setup',
            file_get_contents($file),
            [ 'X-Foo' => 'bar' ],
            'setup.ini'
        );
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canAttachUsingCallback(string $profile)
    {
        $file = $this->attachmentsPath() . 'lipsum.txt';

        $attachment = function (Attachment $att) use ($file) {
            $att
                ->name('text.txt')
                ->contents(fopen($file, 'r'));
        };

        $builder = $this->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withAttachment('text', $attachment);

        $builder->post('/records');

        // --------------------------------------------------------------- //

        $this->assertTrue($builder->hasAttachment('text'), 'file not in builder');

        // --------------------------------------------------------------- //

        $request = $this->lastRequest;
        $contents = $request->getBody()->getContents();
        ConsoleDebugger::output($contents);

        $this->assertAttachmentInPayload(
            $contents,
            'text',
            file_get_contents($file),
            [],
            'lipsum.txt'
        );
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canAttachUsingOptions(string $profile)
    {
        $file = $this->attachmentsPath() . 'test.md';

        $attachment = [
            [
                'name' => 'help_file',
                'contents' => fopen($file, 'r'),
                'filename' => 'README.md'
            ]
        ];

        $client = $this->client($profile);
        $builder = $client
            ->withOption('handler', $this->makeRespondsOkMock())
            ->multipartFormat()
            ->withOption('multipart', $attachment);

        $builder->post('/records');

        // --------------------------------------------------------------- //

        $request = $this->lastRequest;
        $contents = $request->getBody()->getContents();
        ConsoleDebugger::output($contents);

        $this->assertAttachmentInPayload(
            $contents,
            'help_file',
            file_get_contents($file),
            [],
            'README.md'
        );
    }

    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws InvalidFilePathException
     * @throws ProfileNotFoundException
     */
    public function canAttachMultipleFiles(string $profile)
    {
        $pathPrefix = $this->attachmentsPath();
        $fileA = $pathPrefix . 'config.ini';
        $fileB = $pathPrefix . 'lipsum.txt';
        $fileC = $pathPrefix . 'data';

        // File as attachment instance
        $attachmentA = $this->makeAttachment('fileA')
            ->attachFile($fileA)
            ->headers([ 'X-Foo' => 'bar' ])
            ->filename('setup.ini');

        // File as callback
        $attachmentB = function (Attachment $file) use ($fileB) {
            $file
                ->name('text.txt')
                ->contents(fopen($fileB, 'r'));
        };

        // Form data (to test if arrays are merged correctly)
        $data = [ 'person' => 'Sine Oleson' ];

        // --------------------------------------------------------------- //

        $builder = $this->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())

            // Attachment instance
            ->withAttachment('setup', $attachmentA)

            // Callback
            ->withAttachment('text', $attachmentB)

            // Using attach-file method
            ->attachFile('data', $fileC, [ 'X-Swing' => 'sweet'], 'data.txt')

            // Additional form data
            ->withData($data);

        $builder->post('/records');

        // --------------------------------------------------------------- //

        $this->assertTrue($builder->hasAttachment('setup'), 'fileA not in builder');
        $this->assertTrue($builder->hasAttachment('text'), 'fileB not in builder');
        $this->assertTrue($builder->hasAttachment('data'), 'Attached file not in builder (via attach-file method)');

        // --------------------------------------------------------------- //

        $request = $this->lastRequest;
        $contents = $request->getBody()->getContents();
        ConsoleDebugger::output($contents);

        // Attachment A
        $this->assertAttachmentInPayload(
            $contents,
            'setup',
            file_get_contents($fileA),
            [ 'X-Foo' => 'bar' ],
            'setup.ini'
        );

        // Attachment B
        $this->assertAttachmentInPayload(
            $contents,
            'text',
            file_get_contents($fileB),
            [],
            'lipsum.txt'
        );

        // Attachment C
        $this->assertAttachmentInPayload(
            $contents,
            'data',
            file_get_contents($fileC),
            [ 'X-Swing' => 'sweet' ],
            'data.txt'
        );

        // Form input data
        $this->assertStringContainsString("name=\"person\"", $contents, 'Form input data name not part of payload');
        $this->assertStringContainsString('Sine Oleson', $contents, 'Form input data value not part of payload');
    }
}
