<?php


namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Psr\Http\Message\ResponseInterface;
use Teapot\StatusCode;

/**
 * B0_MethodTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-b0',
)]
class B0_MethodTest extends HttpClientsTestCase
{
    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canSetRequestMethod(string $profile)
    {
        $client = $this->client($profile);

        $method = $this->getFaker()->randomElement(array_keys(
            $this->providesHttpMethods()
        ));

        // --------------------------------------------- //

        $builder = $client->withMethod($method);
        $this->assertSame($method, $builder->getMethod(), 'Incorrect method in builder');

        // --------------------------------------------- //

        /** @var ResponseInterface $response */
        $response = $builder
            ->withOption('handler', $this->makeRespondsOkMock())
            ->request(null, '/somewhere');

        $methodsSent = $this->lastRequest->getMethod();
        $this->assertSame($method, $methodsSent, 'Request did not send correct Http method');
        $this->assertSame(StatusCode::OK, $response->getStatusCode());
    }
}
