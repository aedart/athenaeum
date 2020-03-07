<?php

namespace Aedart\Http\Clients\Drivers;

use Aedart\Contracts\Http\Clients\Client;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Http\Clients\Requests\Builders\GuzzleRequestBuilder;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Default Http Client
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Drivers
 */
class DefaultHttpClient extends BaseClient
{
//    /**
//     * Options for the next request
//     *
//     * @var array
//     */
//    protected array $optionsForNextRequest = [];

    /**
     * The Guzzle Http Client
     *
     * @var GuzzleClient|null
     */
    protected ?GuzzleClient $client = null;

//    /**
//     * The data format to use
//     *
//     * @see http://docs.guzzlephp.org/en/stable/request-options.html#body
//     * @see http://docs.guzzlephp.org/en/stable/request-options.html#form-params
//     * @see http://docs.guzzlephp.org/en/stable/request-options.html#multipart
//     * @see http://docs.guzzlephp.org/en/stable/request-options.html#json
//     *
//     * @var string
//     */
//    protected string $dataFormat;
//
//    /**
//     * Default Accept header for json data format
//     *
//     * @var string
//     */
//    protected string $jsonAccept = 'application/json';
//
//    /**
//     * Default Content-Type header for json data format
//     *
//     * @var string
//     */
//    protected string $jsonContentType = 'application/json';
//
//    /**
//     * The default data format to use for requests
//     *
//     * @var string
//     */
//    protected string $defaultDataFormat = RequestOptions::FORM_PARAMS;

    /**
     * DefaultHttpClient constructor.
     *
     * @param array $options [optional]
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);

        $this->client = new GuzzleClient($this->options);
    }

    /**
     * @inheritDoc
     */
    public function initialOptions(): array
    {
        return [
            'http_errors' => false,
            'connect_timeout' => 5,
            'timeout' => 10,
            'allow_redirects' => [
                'max' => 1,
                'strict' => true,
                'referer' => true,
                'protocols' => ['http', 'https'],
                'track_redirects' => false
            ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        // TODO: Implement sendRequest() method.
    }

//    /**
//     * {@inheritdoc}
//     */
//    public function get($uri): ResponseInterface
//    {
//        return $this->request('GET', $uri);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function head($uri): ResponseInterface
//    {
//        return $this->request('HEAD', $uri);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function post($uri, array $body = []): ResponseInterface
//    {
//        return $this->request('POST', $uri, [
//            $this->getDataFormat() => $body
//        ]);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function put($uri, array $body = []): ResponseInterface
//    {
//        return $this->request('PUT', $uri, [
//            $this->getDataFormat() => $body
//        ]);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function delete($uri, array $body = []): ResponseInterface
//    {
//        return $this->request('DELETE', $uri, [
//            $this->getDataFormat() => $body
//        ]);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function options($uri): ResponseInterface
//    {
//        return $this->request('OPTIONS', $uri);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function patch($uri, array $body = []): ResponseInterface
//    {
//        return $this->request('PATCH', $uri, [
//            $this->getDataFormat() => $body
//        ]);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function request(string $method, $uri, array $options = []): ResponseInterface
//    {
//        // Resolve options for request
//        $options = $this->withOptions($options)
//                        ->getOptions();
//
//        // Perform request
//        $response = $this->client->request($method, $uri, $options);
//
//        // Reset options for next request
//        $this->resetOptionsForNextRequest();
//
//        // Finally, return response
//        return $response;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function withHeaders(array $headers = []): Client
//    {
//        $this->optionsForNextRequest['headers'] = $this->optionsForNextRequest['headers'] ?? [];
//
//        $this->optionsForNextRequest['headers'] = array_merge_recursive($this->optionsForNextRequest['headers'], $headers);
//
//        return $this;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function withHeader(string $name, $value): Client
//    {
//        return $this->withHeaders([ $name => $value ]);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function withoutHeader(string $name): Client
//    {
//        $headers = $this->optionsForNextRequest['headers'] ?? [];
//
//        $name = $this->normaliseHeaderName($name);
//
//        $names = array_keys($headers);
//        foreach ($names as $header) {
//            if ($this->normaliseHeaderName($header) === $name) {
//                unset($this->optionsForNextRequest['headers'][$header]);
//                break;
//            }
//        }
//
//        return $this;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getHeaders(): array
//    {
//        return $this->optionsForNextRequest['headers'];
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getHeader(string $name)
//    {
//        $headers = $this->optionsForNextRequest['headers'] ?? [];
//
//        $name = $this->normaliseHeaderName($name);
//        foreach ($headers as $header => $value) {
//            if ($this->normaliseHeaderName($header) === $name) {
//                return $value;
//            }
//        }
//
//        return null;
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function withAccept(string $contentType): Client
//    {
//        return $this->withHeader('Accept', $contentType);
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function withContentType(string $contentType): Client
//    {
//        return $this->withHeader('Content-Type', $contentType);
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function formFormat(): Client
//    {
//        return $this
//            ->useDataFormat('form_params')
//            ->withContentType('application/x-www-form-urlencoded');
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function jsonFormat(): Client
//    {
//        return $this
//            ->useDataFormat('json')
//            ->withAccept($this->jsonAccept)
//            ->withContentType($this->jsonContentType);
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function multipartFormat(): Client
//    {
//        return $this
//            ->useDataFormat('multipart')
//            ->withContentType('multipart/form-data');
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function useDataFormat(string $format): Client
//    {
//        $this->dataFormat = $format;
//
//        return $this;
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function getDataFormat(): string
//    {
//        return $this->dataFormat;
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function useBasicAuth(string $username, string $password): Client
//    {
//        return $this->withOption('auth', [ $username, $password ]);
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function useDigestAuth(string $username, string $password): Client
//    {
//        return $this->withOption('auth', [ $username, $password, 'digest' ]);
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function useTokenAuth(string $token, string $scheme = 'Bearer'): Client
//    {
//        return $this->withHeader('Authorization', trim($scheme . ' ' . $token));
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function maxRedirects(int $amount): Client
//    {
//        if ($amount === 0) {
//            return $this->disableRedirects();
//        }
//
//        return $this->withOption('allow_redirects', [
//            'max' => $amount,
//            'strict' => true,
//            'referer' => true,
//            'protocols' => ['http', 'https'],
//            'track_redirects' => false
//        ]);
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function disableRedirects(): Client
//    {
//        return $this->withOption('allow_redirects', false);
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function withTimeout(float $seconds): Client
//    {
//        return $this->withOption('timeout', $seconds);
//    }
//
//    /**
//     * @inheritDoc
//     */
//    public function getTimeout(): float
//    {
//        return (float) $this->getOption('timeout');
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function withOptions(array $options = []): Client
//    {
//        $this->optionsForNextRequest = array_merge($this->optionsForNextRequest, $options);
//
//        return $this;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function withOption(string $name, $value): Client
//    {
//        return $this->withOptions([ $name => $value ]);
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function withoutOption(string $name): Client
//    {
//        unset($this->optionsForNextRequest[$name]);
//
//        return $this;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getOptions(): array
//    {
//        return $this->optionsForNextRequest;
//    }
//
//    /**
//     * {@inheritdoc}
//     */
//    public function getOption(string $name)
//    {
//        if (isset($this->optionsForNextRequest[$name])) {
//            return $this->optionsForNextRequest[$name];
//        }
//
//        return null;
//    }

    /**
     * @inheritDoc
     *
     * @return GuzzleClient
     */
    public function driver()
    {
        return $this->client;
    }

    /**
     * @inheritDoc
     */
    public function makeBuilder(): Builder
    {
        return new GuzzleRequestBuilder($this, $this->getClientOptions());
    }

//    /*****************************************************************
//     * Internals
//     ****************************************************************/
//
//    /**
//     * Resets the options back to the initial options
//     */
//    protected function resetOptionsForNextRequest()
//    {
//        $this->optionsForNextRequest = $this->initialOptions;
//
//        $this->resolveDataFormat();
//    }
//
//    /**
//     * Resolve the data format to use for the next request
//     */
//    protected function resolveDataFormat()
//    {
//        $dataFormat = $this->initialOptions['data_format'] ?? $this->defaultDataFormat;
//
//        switch ($dataFormat) {
//            case RequestOptions::FORM_PARAMS:
//                $this->formFormat();
//                break;
//
//            case RequestOptions::JSON:
//                $this->jsonFormat();
//                break;
//
//            case RequestOptions::MULTIPART:
//                $this->multipartFormat();
//                break;
//
//            default:
//                $this->useDataFormat($dataFormat);
//                break;
//        }
//    }
//
//    /**
//     * Normalises the header name
//     *
//     * @param string $name
//     *
//     * @return string
//     */
//    protected function normaliseHeaderName(string $name): string
//    {
//        return strtolower(trim($name));
//    }
//
//    /**
//     * Determine if a given header has been set in the initial options
//     *
//     * @param string $name Case-insensitive
//     *
//     * @return bool
//     */
//    protected function hasInitialHeader(string $name): bool
//    {
//        $headers = $this->initialOptions['headers'] ?? [];
//
//        $name = $this->normaliseHeaderName($name);
//
//        $names = array_keys($headers);
//        foreach ($names as $header) {
//            if ($this->normaliseHeaderName($header) === $name) {
//                return true;
//            }
//        }
//
//        return false;
//    }
}
