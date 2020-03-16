<?php


namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Psr\Http\Message\ResponseInterface;

/**
 * B0_MethodTest
 *
 * @group http-clients
 * @group http-clients-b0
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
class B0_MethodTest extends HttpClientsTestCase
{
    /**
     * @test
     * @dataProvider providesClientProfiles
     *
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    public function canSetRequestMethod(string $profile)
    {
        $client = $this->getHttpClientsManager()->profile($profile);

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
        $this->assertSame(200, $response->getStatusCode());
    }
}
