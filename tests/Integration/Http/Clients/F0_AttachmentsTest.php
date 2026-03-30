<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidFilePathException;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Http\Clients\Requests\Attachment;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * F0_AttachmentsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-f0',
)]
class F0_AttachmentsTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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

        $this->assertTrue($client->hasData(), 'No additional data set on builder');
        $this->assertSame([ 'address' => $address ], $client->getData(), 'Additional data not set');
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     * @throws InvalidFilePathException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canAttachUsingAttachmentInstance(string $profile)
    {
        $file = $this->attachmentsPath() . 'config.ini';

        $attachment = $this->makeAttachment()
            ->name('setup')
            ->attachFile($file)
            ->headers([ 'X-Foo' => 'bar' ])
            ->filename('setup.ini');

        $builder = $this->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withAttachment($attachment);

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
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canAttachUsingCallback(string $profile)
    {
        $file = $this->attachmentsPath() . 'lipsum.txt';

        $attachment = function (Attachment $att) use ($file) {
            $att
                ->name('text')
                ->contents(fopen($file, 'r'));
        };

        $builder = $this->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withAttachment($attachment);

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
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canAttachUsingArray(string $profile)
    {
        $file = $this->attachmentsPath() . 'lipsum.txt';

        $attachment = [
            'name' => 'arr',
            'contents' => fopen($file, 'r')
        ];

        $builder = $this->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->withAttachment($attachment);

        $builder->post('/records');

        // --------------------------------------------------------------- //

        $this->assertTrue($builder->hasAttachment('arr'), 'file not in builder');

        // --------------------------------------------------------------- //

        $request = $this->lastRequest;
        $contents = $request->getBody()->getContents();
        ConsoleDebugger::output($contents);

        $this->assertAttachmentInPayload(
            $contents,
            'arr',
            file_get_contents($file),
            [],
            'lipsum.txt'
        );
    }

    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
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
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canAttachUsingStream(string $profile)
    {
        $file = $this->attachmentsPath() . 'lipsum.txt';

        $stream = fopen($file, 'r');

        $builder = $this->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->attachStream('arr', $stream);

        $builder->post('/records');

        // --------------------------------------------------------------- //

        $this->assertTrue($builder->hasAttachment('arr'), 'file not in builder');

        // --------------------------------------------------------------- //

        $request = $this->lastRequest;
        $contents = $request->getBody()->getContents();
        ConsoleDebugger::output($contents);

        $this->assertAttachmentInPayload(
            $contents,
            'arr',
            file_get_contents($file),
            [],
            'lipsum.txt'
        );
    }

    /**
     * @param string $profile
     *
     * @throws InvalidFilePathException
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canAttachMultipleFiles(string $profile)
    {
        $pathPrefix = $this->attachmentsPath();
        $fileA = $pathPrefix . 'config.ini';
        $fileB = $pathPrefix . 'lipsum.txt';
        $fileC = $pathPrefix . 'data';

        // File as attachment instance
        $attachmentA = $this->makeAttachment()
            ->name('setup')
            ->attachFile($fileA)
            ->headers([ 'X-Foo' => 'bar' ])
            ->filename('setup.ini');

        // File as callback
        $attachmentB = function (Attachment $file) use ($fileB) {
            $file
                ->name('text')
                ->contents(fopen($fileB, 'r'));
        };

        // Form data (to test if arrays are merged correctly)
        $data = [ 'person' => 'Sine Oleson' ];

        // --------------------------------------------------------------- //

        $builder = $this->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())

            // Attachment instance
            ->withAttachment($attachmentA)

            // Callback
            ->withAttachment($attachmentB)

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
