<?php

namespace Aedart\Testing\Helpers\Http;

use Aedart\Utils\Str;
use Illuminate\Support\Collection;
use Illuminate\Testing\Assert as PHPUnit;
use Illuminate\Testing\Concerns\AssertsStatusCodes;
use Symfony\Component\HttpFoundation\HeaderBag;
use Teapot\StatusCode\All as Status;

/**
 * Multipart Response
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Helpers\Http
 */
class MultipartResponse
{
    use AssertsStatusCodes;

    /**
     * Parsed content - collection of multipart content
     *
     * @var Collection<MultipartContent>|null
     */
    protected Collection|null $parts = null;

    public function __construct(
        public readonly int $status,
        public readonly HeaderBag $headers,
        protected string|false $body = false
    ) {
    }

    /**
     * Creates a new Multipart response from given response
     *
     * @param \Illuminate\Testing\TestResponse|\Symfony\Component\HttpFoundation\StreamedResponse $response
     *
     * @return static
     */
    public static function from($response): static
    {
        return new static(
            status: $response->getStatusCode(),
            headers: $response->headers,
            body: $response->streamedContent()
        );
    }

    /**
     * Get the boundary separator
     *
     * @return string|null
     */
    public function getBoundary(): string|null
    {
        $contentType = $this->headers->get('Content-Type');
        $parts = explode('=', $contentType);

        if (count($parts) !== 2) {
            return null;
        }

        return $parts[1];
    }

    /**
     * Assert that a boundary separator is available in response
     *
     * @return self
     */
    public function assertHasBoundary(): static
    {
        PHPUnit::assertNotEmpty($this->getBoundary(), 'No boundary separator available in response');

        return $this;
    }

    /**
     * Returns a collection of multipart content
     *
     * @return Collection<MultipartContent>
     */
    public function parts(): Collection
    {
        if (isset($this->parts)) {
            return $this->parts;
        }

        $this->assertHasBoundary();

        return $this->parts = Collection::make($this->parseBody(
            body: $this->getContent(),
            boundary: $this->getBoundary()
        ));
    }

    /**
     * Returns the response's content
     *
     * @return string|false
     */
    public function getContent(): string|false
    {
        return $this->body;
    }

    /**
     * Returns the Http Status code
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->status;
    }

    /**
     * Assert 206 "Partial Content"
     *
     * @return self
     */
    public function assertPartialContent()
    {
        return $this->assertStatus(Status::PARTIAL_CONTENT);
    }

    /**
     * Assert response has http status code
     *
     * @param  int  $status
     *
     * @return self
     */
    public function assertStatus($status)
    {
        $message = $this->statusMessageWithDetails($status, $actual = $this->getStatusCode());

        PHPUnit::assertSame($actual, $status, $message);

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function __debugInfo(): array|null
    {
        return [
            'status' => $this->getStatusCode(),
            'headers' => $this->headers->all(),
            'body' => $this->parts()->all()
        ];
    }

    /*****************************************************************
     * Internal
     ****************************************************************/

    /**
     * Get an assertion message for a status assertion containing extra details when available.
     *
     * @param  string|int  $expected
     * @param  string|int  $actual
     *
     * @return string
     */
    protected function statusMessageWithDetails(string|int $expected, string|int $actual): string
    {
        return "Expected http status code {$expected}, but received {$actual}.";
    }

    /**
     * Parse multipart response's body
     *
     * @param string $body
     * @param string $boundary
     *
     * @return MultipartContent[]
     */
    protected function parseBody(string $body, string $boundary): array
    {
        $separator = "--{$boundary}";

        // Remove evt. "close" delimiter - the "distinguished delimiter",
        // that signifies no further body parts.
        // @see https://www.rfc-editor.org/rfc/rfc2046.html#section-5.1.1
        $closeDelimiter = "{$separator}--";
        $body = Str::replaceLast($closeDelimiter, '', $body);

        // Split content by separator.
        $parts = explode($separator, $body);

        // Parse each body part and wrap inside a multipart content object.
        $output = [];
        foreach ($parts as $rawPart) {
            if (empty($rawPart)) {
                continue;
            }

            $output[] = $this->makeMultipartContent($rawPart);
        }

        return $output;
    }

    /**
     * Creates a new multipart content instance from given raw content
     *
     * @param string $rawPart
     *
     * @return MultipartContent
     */
    protected function makeMultipartContent(string $rawPart): MultipartContent
    {
        [$rawHeaders, $rawContent] = explode(PHP_EOL . PHP_EOL, $rawPart, 2);

        return new MultipartContent(
            headers: $this->parsePartHeaders($rawHeaders),
            content: $this->parsePartContent($rawContent)
        );
    }

    /**
     * Parse "part" headers
     *
     * @param string $rawHeaders
     *
     * @return HeaderBag
     */
    protected function parsePartHeaders(string $rawHeaders): HeaderBag
    {
        $bag = new HeaderBag();

        $rawHeaders = explode(PHP_EOL, trim($rawHeaders));
        foreach ($rawHeaders as $rawHeader) {
            [$key, $value] = explode(':', $rawHeader);

            $bag->set(trim($key), trim($value));
        }

        return $bag;
    }

    protected function parsePartContent(string $rawContent): string
    {
        $rawContent = ltrim($rawContent);
        if (empty($rawContent)) {
            return $rawContent;
        }

        // Remove the last character, if it matches end-of-line.
        // This SHOULD ensure that newline characters that were added in
        // a response are safely removed.
        $lastCharIndex = strlen($rawContent) - 1;
        if ($rawContent[$lastCharIndex] == PHP_EOL) {
            return Str::replaceLast(PHP_EOL, '', $rawContent);
        }

        return $rawContent;
    }
}
