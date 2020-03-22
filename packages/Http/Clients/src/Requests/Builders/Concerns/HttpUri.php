<?php


namespace Aedart\Http\Clients\Requests\Builders\Concerns;

use Aedart\Contracts\Http\Clients\Exceptions\InvalidUriException;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Http\Clients\Exceptions\InvalidUri;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

use function GuzzleHttp\Psr7\parse_query;

/**
 * Concerns Http Uri
 *
 * @see Builder
 * @see Builder::withUri
 * @see Builder::getUri
 * @see Builder::from
 * @see Builder::into
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Http\Clients\Requests\Builders\Concerns
 */
trait HttpUri
{
    /**
     * The Uri to send to
     *
     * @var UriInterface|null
     */
    protected ?UriInterface $uri;

    /**
     * Set the Uri for the next request
     *
     * If the given uri string of {@see UriInterface} contain a
     * http query, then it is extracted and applied onto this
     * builder, via the {@see Builder::withQuery} method.
     *
     * @param string|UriInterface $uri
     *
     * @return self
     *
     * @throws InvalidUriException If given Uri argument is invalid
     */
    public function withUri($uri): Builder
    {
        // Build a new query, if a string uri has been provided.
        if (is_string($uri)) {
            $uri = new Uri($uri);
        }

        // Abort if uri wasn't a string or Psr-7 Uri.
        if (!($uri instanceof UriInterface)) {
            throw new InvalidUri('Provided Uri must either be a string or Psr-7 UriInterface');
        }

        // Extract http query, if uri contains such and apply
        // it onto this builder.
        $this->withQuery(
            $this->extractQueryFromUri($uri)
        );

        // Remove the http query on the uri instance, so that it
        // does not cause issues when the request is performed.
        $this->uri = $uri->withQuery('');

        return $this;
    }

    /**
     * Get Uri for the next request
     *
     * @return UriInterface|null
     */
    public function getUri(): ?UriInterface
    {
        return $this->uri;
    }

    /**
     * Alias for {@see withUri}
     *
     * @param string|UriInterface $uri
     *
     * @return self
     *
     * @throws InvalidUriException If given Uri argument is invalid
     */
    public function from($uri): Builder
    {
        return $this->withUri($uri);
    }

    /**
     * Alias for {@see withUri}
     *
     * @param string|UriInterface $uri
     *
     * @return self
     *
     * @throws InvalidUriException If given Uri argument is invalid
     */
    public function into($uri): Builder
    {
        return $this->withUri($uri);
    }

    /*****************************************************************
     * Internals
     ****************************************************************/

    /**
     * Extracts the Http query fragment from given Uri
     *
     * @param UriInterface $uri
     *
     * @return array Empty if Uri does not contain a Http query
     */
    protected function extractQueryFromUri(UriInterface $uri): array
    {
        $query = $uri->getQuery();
        if (!empty($query)) {
            return parse_query($query);
        }

        return [];
    }
}
