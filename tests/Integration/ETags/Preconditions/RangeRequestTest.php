<?php

namespace Aedart\Tests\Integration\ETags\Preconditions;

use Aedart\ETags\Preconditions\Responses\StreamDownload;
use Aedart\Testing\Helpers\Http\Response;
use Aedart\Tests\Helpers\Dummies\ETags\Requests\DownloadFileRequest;
use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Illuminate\Support\Facades\Route;

/**
 * RangeRequestTest
 *
 * @group etags
 * @group preconditions
 * @group range-request
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions
 */
class RangeRequestTest extends PreconditionsTestCase
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
    public function respondsFullFileContentWhenNoRangeRequested(): void
    {
        Route::get('/files/{name}', function (DownloadFileRequest $request) {
            return StreamDownload::make($request->resource, $request->route('name'));
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

        $this->assertTrue($headers->has('Accept-Ranges'), 'Accept Ranges not set');
        $this->assertTrue($headers->has('Last-Modified'), 'Last Modified not set');
        $this->assertTrue($headers->has('ETag'), 'ETag not set');
        $this->assertTrue($headers->has('Content-Length'), 'Content Length not set');
        $this->assertTrue($headers->has('Content-Disposition'), 'Content Disposition not set');

        $this->assertNotEmpty($content, 'No content was streamed');

        $original = $this->getOriginalFileContent($file);
        $this->assertSame($original, $content, 'Stream content does not match original content!');
    }
}
