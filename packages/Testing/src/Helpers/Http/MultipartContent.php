<?php

namespace Aedart\Testing\Helpers\Http;

use Illuminate\Testing\Assert as PHPUnit;
use Symfony\Component\HttpFoundation\HeaderBag;

/**
 * Multipart Content
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Testing\Helpers\Http
 */
class MultipartContent
{
    /**
     * Creates a new multipart content
     *
     * @param HeaderBag $headers
     * @param string|false $content
     */
    public function __construct(
        public readonly HeaderBag $headers,
        public readonly string|false $content
    ) {
    }


    /**
     * Get the content length
     *
     * @return int Bytes
     */
    public function getLength(): int
    {
        $content = $this->content;

        if ($content === false) {
            return 0;
        }

        return strlen($content);
    }

    /**
     * Assert content length
     *
     * @param int $size
     *
     * @return self
     */
    public function assertContentLength(int $size): static
    {
        $this->assertHasContent();

        PHPUnit::assertSame($size, $this->getLength(), 'Multipart content length is not as expected');

        return $this;
    }

    /**
     * Assert that content has been set for this multipart
     *
     * (content must not equal false)
     *
     * @return self
     */
    public function assertHasContent(): static
    {
        $content = $this->content;

        PHPUnit::assertNotFalse($content, 'Multipart has no content');

        return $this;
    }

    /**
     * Assert Content-Type header matches given type
     *
     * @param string $type
     *
     * @return self
     */
    public function assertContentType(string $type): static
    {
        return $this->assertHeader('Content-Type', $type);
    }

    /**
     * Assert header value
     *
     * @param string $header
     * @param mixed $value
     *
     * @return self
     */
    public function assertHeader(string $header, mixed $value): static
    {
        $this->assertHasHeader($header);

        $result = $this->headers->get($header);

        PHPUnit::assertSame($value, $result, "Incorrect value for {$header}");

        return $this;
    }

    /**
     * Assert that a given header exists
     *
     * @param string $header
     *
     * @return self
     */
    public function assertHasHeader(string $header): static
    {
        $result = $this->headers->has($header);

        PHPUnit::assertTrue($result, "Missing {$header} header in multipart");

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function __debugInfo(): array
    {
        return [
            'headers' => $this->headers->all(),
            'content' => $this->content
        ];
    }
}
