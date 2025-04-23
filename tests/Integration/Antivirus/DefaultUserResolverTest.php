<?php

namespace Aedart\Tests\Integration\Antivirus;

use Aedart\Contracts\Antivirus\UserResolver;
use Aedart\Support\Facades\IoCFacade;
use Aedart\Support\Helpers\Auth\AuthTrait;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Antivirus\AntivirusTestCase;
use Codeception\Attribute\Group;
use Illuminate\Auth\GenericUser;
use PHPUnit\Framework\Attributes\Test;

/**
 * DefaultUserResolverTest
 *
 * @group antivirus
 * @group antivirus-user-resolver
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Antivirus
 */
#[Group(
    'antivirus',
    'antivirus-user-resolver',
)]
class DefaultUserResolverTest extends AntivirusTestCase
{
    use AuthTrait;

    /*****************************************************************
     * Helper
     ****************************************************************/

    /**
     * Returns user resolver
     *
     * @return UserResolver
     */
    public function resolver(): UserResolver
    {
        return IoCFacade::tryMake(UserResolver::class);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainResolver(): void
    {
        $resolver = $this->resolver();

        $this->assertInstanceOf(UserResolver::class, $resolver);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsNullWhenNoUserAuthenticated(): void
    {
        $result = $this->resolver()->resolve();

        $this->assertNull($result);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function returnsIdentifierWhenUserAuthenticated(): void
    {
        $user = new GenericUser([
            'id' => $this->getFaker()->randomNumber(2, true)
        ]);

        $guard = $this->getAuth();
        $guard->setUser($user);

        // ------------------------------------------------------ //

        $result = $this->resolver()->resolve();

        ConsoleDebugger::output([
            'user identifier' => $result
        ]);

        $this->assertSame($user->getAuthIdentifier(), $result);
    }
}
