<?php

namespace Aedart\Tests\TestCases\Http;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\Http\Clients\Requests\Attachment as AttachmentInterface;
use Aedart\Http\Clients\Providers\HttpClientServiceProvider;
use Aedart\Http\Clients\Requests\Attachment;
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;
use Aedart\Http\Clients\Traits\HttpClientTrait;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\LaravelTestCase;
use Closure;
use Codeception\Configuration;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;

/**
 * Http Clients Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Http
 */
abstract class HttpClientsTestCase extends LaravelTestCase
{
    use ConfigLoaderTrait;
    use ConfigTrait;
    use HttpClientsManagerTrait;
    use HttpClientTrait;

    /**
     * Instance of the last request performed
     *
     * @var null|RequestInterface
     */
    protected ?RequestInterface $lastRequest = null;

    /*****************************************************************
     * Setup Methods
     ****************************************************************/

    /**
     * {@inheritdoc}
     */
    protected function _before()
    {
        parent::_before();

        $this->getConfigLoader()
            ->setDirectory($this->directory())
            ->load();
    }

    /**
     * {@inheritdoc}
     */
    protected function _after()
    {
        $this->lastRequest = null;

        parent::_after();
    }


    /**
     * {@inheritdoc}
     */
    protected function getPackageProviders($app)
    {
        return [
            ConfigLoaderServiceProvider::class,
            HttpClientServiceProvider::class
        ];
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns the path to configuration files
     *
     * @return string
     */
    public function directory(): string
    {
        return Configuration::dataDir() . 'configs/http/clients/';
    }

    /**
     * Creates a new response handler for Guzzle
     *
     * @param array $responses [optional]
     * @param bool $requestDebug [optional]
     *
     * @return HandlerStack
     */
    protected function makeResponseMock(array $responses = [], bool $requestDebug = true)
    {
        $handler = HandlerStack::create(new MockHandler($responses));

        if ($requestDebug) {
            $handler->push($this->makeRequestDebugMiddleware());
        }

        return $handler;
    }

    /**
     * Creates a debugger middleware for Guzzle
     *
     * @return Closure
     */
    protected function makeRequestDebugMiddleware()
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {

                // Set the last request
                $this->lastRequest = $request;

                $httpVersion = $request->getProtocolVersion();
                $method = $request->getMethod();
                $uri = (string) $request->getUri();
                $headers = $request->getHeaders();
                $body = $request->getBody()->getContents();

                // Rewind stream
                $request->getBody()->rewind();

                ConsoleDebugger::output('HTTP/' . $httpVersion . ' ' . $method . ' ' . $uri . PHP_EOL, $headers, $body);
                ConsoleDebugger::output('-----------------------------------------------------');

                return $handler($request, $options);
            };
        };
    }

    /**
     * Creates a new attachment instance
     *
     * @param string $name
     *
     * @return AttachmentInterface
     */
    protected function makeAttachment(string $name): AttachmentInterface
    {
        return new Attachment($name);
    }

    /*****************************************************************
     * Custom Asserts
     ****************************************************************/

    /**
     * Assert attachment in request payload
     *
     * @param string $body
     * @param string $name
     * @param string $value
     * @param array $headers [optional] A single header, key = name, value = header value
     * @param string|null $filename [optional]
     */
    protected function assertAttachmentInPayload(
        string $body,
        string $name,
        string $value,
        array $headers = [],
        ?string $filename = null
    ) {
        // Assert name
        $this->assertStringContainsString("name=\"{$name}\"", $body, "{$name} is not part of payload");

        // Assert value
        $this->assertStringContainsString($value, $body, "Payload does not contain value (for {$name} attachment)");

        // Assert headers
        foreach ($headers as $key => $value) {
            $this->assertStringContainsString("{$key}: {$value}", $body, "Header is not part of payload (for {$name} attachment)");
        }

        // Assert filename, if given
        if (isset($filename)) {
            $this->assertStringContainsString("filename=\"{$filename}\"", $body, "Filename is not part of payload (for {$name} attachment)");
        }
    }
}
