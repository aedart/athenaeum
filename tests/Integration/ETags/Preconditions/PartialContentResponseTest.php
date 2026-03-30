<?php

namespace Aedart\Tests\Integration\ETags\Preconditions;

use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\Contracts\Utils\Dates\DateTimeFormats;
use Aedart\ETags\Facades\Generator;
use Aedart\ETags\Preconditions\Responses\DownloadStream;
use Aedart\Streams\FileStream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\ETags\Requests\DownloadFileRequest;
use Aedart\Tests\Helpers\Dummies\ETags\Requests\DownloadGenericFileRequest;
use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Codeception\Attribute\Group;
use DateTimeInterface;
use Illuminate\Support\Facades\Route;
use PHPUnit\Framework\Attributes\Test;
use Teapot\StatusCode\All as Status;

/**
 * RangeRequestTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions
 */
#[Group(
    'etags',
    'preconditions',
    'partial-content-response'
)]
class PartialContentResponseTest extends PreconditionsTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns test file's content
     *
     * @param string $file
     *
     * @return string
     */
    public function getOriginalFileContent(string $file): string
    {
        return file_get_contents(
            DownloadFileRequest::fullFilePath($file)
        );
    }

    /**
     * Generates etag for file
     *
     * @param string $file
     *
     * @return ETag
     */
    public function makeFileEtag(string $file): ETag
    {
        return DownloadFileRequest::fileEtag(
            DownloadFileRequest::fullFilePath($file)
        );
    }

    /**
     * Get file's last modified date
     *
     * @param string $file
     *
     * @return DateTimeInterface
     */
    public function fileLastModifiedDate(string $file): DateTimeInterface
    {
        return DownloadFileRequest::fileLastModifiedDate(
            DownloadFileRequest::fullFilePath($file)
        );
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     */
    #[Test]
    public function respondsWithEntireAttachmentWhenNoRangeRequested(): void
    {
        Route::get('/files/{name}', function (DownloadFileRequest $request) {
            return DownloadStream::for($request->resource)
                ->setName($request->route('name'));
        })->name('file.download');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------ //

        $file = 'my-document.txt';
        $url = route('file.download', [ 'name' => $file ]);
        $response = $this
            ->get($url)
            ->assertOk()
            ->assertDownload($file);

        $headers = $response->headers;
        $content = Response::streamResponse($response);

        // ------------------------------------------------------------ //

        $this->assertTrue($headers->has('Accept-Ranges'), 'Accept Ranges not set');
        $this->assertTrue($headers->has('Last-Modified'), 'Last Modified not set');
        $this->assertTrue($headers->has('ETag'), 'ETag not set');
        $this->assertTrue($headers->has('Content-Length'), 'Content Length not set');
        $this->assertTrue($headers->has('Content-Type'), 'Content Type not set');
        $this->assertTrue($headers->has('Content-Disposition'), 'Content Disposition not set');

        $this->assertNotEmpty($content, 'No content was streamed');

        $original = $this->getOriginalFileContent($file);
        $this->assertSame($original, $content, 'Stream content does not match original content!');
    }

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function respondsSinglePartWhenASingleRangeRequested(): void
    {
        Route::get('/files/{name}', function (DownloadFileRequest $request) {
            return DownloadStream::for($request->resource)
                ->setName($request->route('name'))
                ->withBufferSize(11);
        })->name('file.download');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------ //

        $file = 'my-document.txt';
        $url = route('file.download', [ 'name' => $file ]);
        $response = $this
            ->get($url, [
                'Range' => 'bytes=0-99'
            ])
            ->assertStatus(Status::PARTIAL_CONTENT)
            ->assertDownload($file);

        $headers = $response->headers;
        $content = Response::streamResponse($response);

        // ------------------------------------------------------------ //

        $this->assertTrue($headers->has('Accept-Ranges'), 'Accept Ranges not set');
        $this->assertTrue($headers->has('Last-Modified'), 'Last Modified not set');
        $this->assertFalse($headers->has('ETag'), 'ETag should NOT be set (default behaviour)');
        $this->assertTrue($headers->has('Content-Length'), 'Content Length not set');
        $this->assertTrue($headers->has('Content-Type'), 'Content Type not set');
        $this->assertTrue($headers->has('Content-Disposition'), 'Content Disposition not set');

        $this->assertNotEmpty($content, 'No content was streamed');

        $original = $this->getOriginalFileContent($file);
        $part = FileStream::openTemporary()
            ->put($original)
            ->positionToStart()
            ->read(100);

        $this->assertSame($part, $content, 'Stream content does not match requested range');
    }

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function respondsMultiplePartsWhenMultipleRangesRequested(): void
    {
        Route::get('/files/{name}', function (DownloadFileRequest $request) {
            return DownloadStream::for($request->resource)
                ->setName($request->route('name'));
        })->name('file.download');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------ //

        $file = 'my-document.txt';
        $url = route('file.download', [ 'name' => $file ]);
        $response = $this
            ->get($url, [
                'Range' => 'bytes=0-3,5-6,8-15'
            ])
            ->assertStatus(Status::PARTIAL_CONTENT)
            ->assertDownload($file);

        $headers = $response->headers;
        $content = Response::streamResponse($response);

        // ------------------------------------------------------------ //

        $this->assertTrue($headers->has('Accept-Ranges'), 'Accept Ranges not set');
        $this->assertTrue($headers->has('Last-Modified'), 'Last Modified not set');
        $this->assertFalse($headers->has('ETag'), 'ETag should NOT be set (default behaviour)');
        $this->assertTrue($headers->has('Content-Length'), 'Content Length not set');
        $this->assertTrue($headers->has('Content-Type'), 'Content Type not set');
        $this->assertTrue($headers->has('Content-Disposition'), 'Content Disposition not set');

        $this->assertNotEmpty($content, 'No content was streamed');

        // ------------------------------------------------------------ //

        ConsoleDebugger::output(str_repeat('- - ', 10));
        $multipartResponse = Response::multipartResponse($response);

        $original = $this->getOriginalFileContent($file);
        $stream = FileStream::openTemporary()
            ->put($original)
            ->positionToStart();

        $a = $stream
            ->positionAt(0)
            ->read(3 + 1);

        $b = $stream
            ->positionAt(5)
            ->read((6 - 5) + 1);

        $c = $stream
            ->positionAt(8)
            ->read((15 - 8) + 1);

        ConsoleDebugger::output(str_repeat('- - ', 10));
        ConsoleDebugger::output([
            'expected' => [
                'a' => $a,
                'b' => $b,
                'c' => $c
            ],
            'actual' => $multipartResponse->parts()->map(fn ($p) => $p->content)->all()
        ]);

        $collection = $multipartResponse->parts();
        $this->assertNotEmpty($collection, 'No parts part of response body');
        $this->assertCount(3, $collection);

        $this->assertSame($a, $collection[0]->content, '1st part has wrong content');
        $collection[0]->assertContentType('text/plain');
        $collection[0]->assertContentLength(4);

        $this->assertSame($b, $collection[1]->content, '2nd part has wrong content');
        $collection[1]->assertContentType('text/plain');
        $collection[1]->assertContentLength(2);

        $this->assertSame($c, $collection[2]->content, '3rd part has wrong content');
        $collection[2]->assertContentType('text/plain');
        $collection[2]->assertContentLength(8);
    }

    /**
     * @return void
     */
    #[Test]
    public function canCombinePartialsIntoSingleFile(): void
    {
        Route::get('/files/{name}', function (DownloadFileRequest $request) {
            return DownloadStream::for($request->resource)
                ->setName($request->route('name'));
        })->name('file.download');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------ //

        $file = 'my-document.txt';
        $url = route('file.download', [ 'name' => $file ]);

        // ------------------------------------------------------------ //

        // Single part
        $responseA = $this
            ->get($url, [
                'Range' => 'bytes=0-250'
            ])
            ->assertStatus(Status::PARTIAL_CONTENT)
            ->assertDownload($file);

        // Multiple parts
        $responseB = $this
            ->get($url, [
                'Range' => 'bytes=251-299,300-'
            ])
            ->assertStatus(Status::PARTIAL_CONTENT)
            ->assertDownload($file);

        // ------------------------------------------------------------ //

        $contentA = Response::streamResponse($responseA);

        ConsoleDebugger::output(str_repeat('- - ', 10));
        $multipartResponse = Response::multipartResponse($responseB);

        $result = $contentA;
        foreach ($multipartResponse->parts() as $part) {
            $part->assertHasContent();

            $result .= $part->content;
        }

        // ------------------------------------------------------------ //

        $expected = $this->getOriginalFileContent($file);

        $this->assertSame(strlen($expected), strlen($result), 'Length of content does match expected');
        $this->assertSame($expected, $result, 'Combination of multipart content does not match expected content!');
    }

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function respondsWithPartialContentWhenIfRangeEtagMatches(): void
    {
        Route::get('/files/{name}', function (DownloadFileRequest $request) {
            return DownloadStream::for($request->resource)
                ->setName($request->route('name'));
        })->name('file.download');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------ //

        $file = 'my-document.txt';
        $etag = $this->makeFileEtag($file);

        $url = route('file.download', [ 'name' => $file ]);
        $response = $this
            ->get($url, [
                'If-Range' => $etag->toString(),
                'Range' => 'bytes=0-9'
            ])
            ->assertStatus(Status::PARTIAL_CONTENT)
            ->assertDownload($file);

        $content = Response::streamResponse($response);

        // ------------------------------------------------------------ //

        $this->assertNotEmpty($content, 'No content was streamed');

        $original = $this->getOriginalFileContent($file);
        $stream = FileStream::openTemporary()
            ->put($original)
            ->positionToStart();

        $a = $stream
            ->positionAt(0)
            ->read(9 + 1);

        $this->assertSame($a, $content, 'Stream content does not match requested range');
    }

    /**
     * @return void
     */
    #[Test]
    public function respondsEntireAttachmentWhenIfRangeEtagDoesNotMatch(): void
    {
        Route::get('/files/{name}', function (DownloadFileRequest $request) {
            return DownloadStream::for($request->resource)
                ->setName($request->route('name'));
        })->name('file.download');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------ //

        $file = 'my-document.txt';
        $etag = Generator::makeStrong(1234); // Etag that does not match file's etag...

        $url = route('file.download', [ 'name' => $file ]);
        $response = $this
            ->get($url, [
                'If-Range' => $etag->toString(),
                'Range' => 'bytes=0-9'
            ])
            ->assertOk()
            ->assertDownload($file);

        $content = Response::streamResponse($response);

        // ------------------------------------------------------------ //

        $this->assertNotEmpty($content, 'No content was streamed');

        $original = $this->getOriginalFileContent($file);
        $this->assertSame($original, $content, 'Stream content does not match original content!');
    }

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function respondsWithPartialContentWhenIfRangeDateMatches(): void
    {
        Route::get('/files/{name}', function (DownloadFileRequest $request) {
            return DownloadStream::for($request->resource)
                ->setName($request->route('name'));
        })->name('file.download');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------ //

        $file = 'my-document.txt';
        $lastModified = $this->fileLastModifiedDate($file)->format(DateTimeFormats::RFC9110);

        $url = route('file.download', [ 'name' => $file ]);
        $response = $this
            ->get($url, [
                'If-Range' => $lastModified,
                'Range' => 'bytes=100-125'
            ])
            ->assertStatus(Status::PARTIAL_CONTENT)
            ->assertDownload($file);

        $content = Response::streamResponse($response);

        // ------------------------------------------------------------ //

        $this->assertNotEmpty($content, 'No content was streamed');

        $original = $this->getOriginalFileContent($file);
        $stream = FileStream::openTemporary()
            ->put($original)
            ->positionToStart();

        $a = $stream
            ->positionAt(100)
            ->read((125 - 100) + 1);

        $this->assertSame($a, $content, 'Stream content does not match requested range');
    }

    /**
     * @return void
     */
    #[Test]
    public function respondsEntireAttachmentWhenIfRangeDateDoesNotMatch(): void
    {
        Route::get('/files/{name}', function (DownloadFileRequest $request) {
            return DownloadStream::for($request->resource)
                ->setName($request->route('name'));
        })->name('file.download');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------ //

        $file = 'my-document.txt';
        $lastModified = now()->format(DateTimeFormats::RFC9110);

        $url = route('file.download', [ 'name' => $file ]);
        $response = $this
            ->get($url, [
                'If-Range' => $lastModified,
                'Range' => 'bytes=0-9'
            ])
            ->assertOk()
            ->assertDownload($file);

        $content = Response::streamResponse($response);

        // ------------------------------------------------------------ //

        $this->assertNotEmpty($content, 'No content was streamed');

        $original = $this->getOriginalFileContent($file);
        $this->assertSame($original, $content, 'Stream content does not match original content!');
    }

    /**
     * @return void
     *
     * @throws StreamException
     */
    #[Test]
    public function respondsWithCustomRangeUnit(): void
    {
        Route::get('/files/{name}', function (DownloadGenericFileRequest $request) {
            return DownloadStream::for($request->resource)
                ->setName($request->route('name'));
        })->name('file.download');

        Route::getRoutes()->refreshNameLookups();

        // ------------------------------------------------------------ //

        $file = 'contacts.txt';
        $url = route('file.download', [ 'name' => $file ]);
        $response = $this
            ->get($url, [
                'Range' => 'kilobytes=0-2'
            ])
            ->assertStatus(Status::PARTIAL_CONTENT)
            ->assertDownload($file);

        $headers = $response->headers;
        Response::streamResponse($response);

        // ------------------------------------------------------------ //

        $this->assertTrue($headers->has('Accept-Ranges'), 'Accept Ranges not set');
        $this->assertSame('kilobytes', $headers->get('Accept-Ranges'), 'Incorrect Accept Ranges header');

        $this->assertTrue($headers->has('Content-Range'), 'Content Range not set');
        $this->assertSame('kilobytes 0-2/6', $headers->get('Content-Range'), 'Incorrect Content Range header');

        // Funny part... Content-Length is always in bytes... (do not why standard is so strange)
        // @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Content-Length
        // @see https://httpwg.org/specs/rfc9110.html#field.content-length
        $this->assertTrue($headers->has('Content-Length'), 'Content Length not set');
        $this->assertSame('3000', $headers->get('Content-Length'), 'Incorrect Content Length header');
    }
}
