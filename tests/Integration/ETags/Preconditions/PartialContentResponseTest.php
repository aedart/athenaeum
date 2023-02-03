<?php

namespace Aedart\Tests\Integration\ETags\Preconditions;

use Aedart\Contracts\Streams\Exceptions\StreamException;
use Aedart\ETags\Preconditions\Responses\DownloadStream;
use Aedart\Streams\FileStream;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\ETags\Requests\DownloadFileRequest;
use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Illuminate\Support\Facades\Route;
use Teapot\StatusCode\All as Status;

/**
 * RangeRequestTest
 *
 * @group etags
 * @group preconditions
 * @group partial-content-response
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions
 */
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

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     */
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
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
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
     * @test
     *
     * @return void
     *
     * @throws StreamException
     */
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
     * @test
     *
     * @return void
     */
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
}
