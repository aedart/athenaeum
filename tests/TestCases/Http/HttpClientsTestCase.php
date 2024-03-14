<?php

namespace Aedart\Tests\TestCases\Http;

use Aedart\Config\Providers\ConfigLoaderServiceProvider;
use Aedart\Config\Traits\ConfigLoaderTrait;
use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Requests\Attachment as AttachmentInterface;
use Aedart\Contracts\Http\Clients\Requests\Query\Builder as QueryBuilderInterface;
use Aedart\Contracts\Http\Clients\Requests\Query\Grammar;
use Aedart\Contracts\Http\Cookies\Cookie;
use Aedart\Contracts\Http\Cookies\SetCookie as SetCookieInterface;
use Aedart\Http\Clients\Providers\HttpClientServiceProvider;
use Aedart\Http\Clients\Requests\Attachment;
use Aedart\Http\Clients\Requests\Query\Builder as QueryBuilder;
use Aedart\Http\Clients\Traits\GrammarManagerTrait;
use Aedart\Http\Clients\Traits\HttpClientsManagerTrait;
use Aedart\Http\Clients\Traits\HttpClientTrait;
use Aedart\Http\Cookies\SetCookie;
use Aedart\Support\Helpers\Config\ConfigTrait;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\LaravelTestCase;
use Closure;
use Codeception\Configuration;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Teapot\StatusCode;

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
    use GrammarManagerTrait;

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
            HttpClientServiceProvider::class,
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
     * Returns the path where dummy attachments are located
     *
     * @return string
     */
    protected function attachmentsPath(): string
    {
        return Configuration::dataDir() . '/http/clients/attachments/';
    }

    /**
     * Creates or obtains Http Client that matches given profile
     *
     * @param string $profile [optional]
     * @param array $options [optional]
     *
     * @return Client
     *
     * @throws ProfileNotFoundException
     */
    public function client(?string $profile = null, array $options = []): Client
    {
        return $this->getHttpClientsManager()->profile($profile, $options);
    }

    /**
     * Creates a new Http Query instance
     *
     * @param string|Grammar|null $grammar [optional]
     *
     * @return QueryBuilderInterface
     *
     * @throws ProfileNotFoundException
     */
    public function query($grammar = null): QueryBuilderInterface
    {
        return new QueryBuilder($grammar);
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
     * Creates a handle stack that mocks a Http response,
     * with status 200 (Ok)
     *
     * @return HandlerStack
     */
    protected function makeRespondsOkMock()
    {
        return $this->makeResponseMock([ new Response(StatusCode::OK) ]);
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
     * @param array $data [optional]
     *
     * @return AttachmentInterface
     */
    protected function makeAttachment(array $data = []): AttachmentInterface
    {
        return new Attachment($data);
    }

    /**
     * Creates a new cookie instance
     *
     * @param array $data [optional]
     *
     * @return Cookie|SetCookieInterface
     */
    protected function makeCookie(array $data = []): Cookie
    {
        return new SetCookie($data);
    }

    /**
     * Creates a new Guzzle Cookie Jar instance
     *
     * @param array $cookies [optional]
     * @param string $domain [optional] A "0" is not a valid internet domain, but may
     *                          be used as server name in a private network. (source: Guzzle's SetCookie)
     *
     * @return CookieJarInterface
     */
    protected function makeCookieJar(array $cookies = [], string $domain = '0'): CookieJarInterface
    {
        return CookieJar::fromArray($cookies, $domain);
    }

    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Provides Http Client profile identifiers
     *
     * @return array
     */
    public function providesClientProfiles()
    {
        return [
            'default' => [ 'default' ],
            'json' => [ 'json' ],
        ];
    }

    /**
     * Provides Http methods
     *
     * @return array
     */
    public function providesHttpMethods()
    {
        return [
            'GET' => [ 'get' ],
            'HEAD' => [ 'head' ],
            'POST' => [ 'post' ],
            'PUT' => [ 'put' ],
            'DELETE' => [ 'delete' ],
            'OPTIONS' => [ 'options' ],
            'PATCH' => [ 'patch' ],
        ];
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
