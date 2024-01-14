<?php

namespace Aedart\Tests\Integration\Redmine\Resources;

use Aedart\Contracts\Redmine\Exceptions\UnsupportedOperationException;
use Aedart\Redmine\User;
use Aedart\Tests\TestCases\Redmine\RedmineTestCase;

/**
 * UserTest
 *
 * @group redmine
 * @group redmine-resources
 * @group redmine-resources-user
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Redmine\Resources
 */
class UserTest extends RedmineTestCase
{
    /**
     * @test
     *
     * @throws UnsupportedOperationException
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canCreateUser()
    {
        // Debug
        //        user::$debug = true;

        // ----------------------------------------------------------------------- //

        $faker = $this->getFaker();

        $data = [
            'login' => $faker->userName,
            'password' => $faker->password(15),
            'firstname' => 'Test User',
            'lastname' => 'Athenaeum Redmine',
            'mail' => 'athenaeum-test-' . $faker->randomNumber(6, true) . '@example.org'
        ];

        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, User::class),
            $this->mockDeletedResourceResponse()
        ]);

        // ----------------------------------------------------------------------- //

        $user = User::create($data, [], $connection);

        $this->assertNotEmpty($user->id(), 'User was not created');

        // ----------------------------------------------------------------------- //
        // Cleanup

        $user->delete();
    }

    /**
     * @test
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canUpdateUser()
    {
        // Debug
        //        User::$debug = true;

        // ----------------------------------------------------------------------- //

        $faker = $this->getFaker();

        $data = [
            'login' => $faker->userName,
            'password' => $faker->password(15),
            'firstname' => 'Test User',
            'lastname' => 'Athenaeum Redmine',
            'mail' => 'athenaeum-test-' . $faker->randomNumber(6, true) . '@example.org'
        ];

        $changed = array_merge($data, [
            'firstname' => 'AED. updated'
        ]);

        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, 1234, User::class),
            $this->mockUpdatedResourceResponse(),
            $this->mockReloadedResourceResponse($changed, 1234, User::class),
            $this->mockDeletedResourceResponse()
        ]);

        // ----------------------------------------------------------------------- //
        // Prerequisites

        $user = User::create($data, [], $connection);

        $this->assertNotEmpty($user->id(), 'User was not created');

        // ----------------------------------------------------------------------- //
        // Update

        $result = $user->update($changed, true);

        $this->assertTrue($result, 'User was not updated');
        $this->assertSame($changed['firstname'], $user->firstname, 'User name was not changed');

        // ----------------------------------------------------------------------- //
        // Cleanup

        $user->delete();
    }

    /**
     * @test
     *
     * @throws \JsonException
     * @throws \Throwable
     */
    public function canListUsers()
    {
        // Debug
        //        User::$debug = true;

        // ----------------------------------------------------------------------- //

        $faker = $this->getFaker();
        $id = 1234;

        $data = [
            'login' => $faker->userName,
            'password' => $faker->password(15),
            'firstname' => 'Test User',
            'lastname' => 'Athenaeum Redmine',
            'mail' => 'athenaeum-test-' . $faker->randomNumber(6, true) . '@example.org'
        ];

        $list = [
            array_merge($data, [ 'id' => $id ]),
            [
                'id' => 4321,
                'login' => $faker->userName,
                'password' => $faker->password(15),
                'firstname' => 'Another Test User',
                'lastname' => 'Athenaeum Redmine',
                'mail' => 'athenaeum-test-' . $faker->randomNumber(6, true) . '@example.org'
            ],
            [
                'id' => 5555,
                'login' => $faker->userName,
                'password' => $faker->password(15),
                'firstname' => 'Last Test User',
                'lastname' => 'Athenaeum Redmine',
                'mail' => 'athenaeum-test-' . $faker->randomNumber(6, true) . '@example.org'
            ]
        ];

        $limit = 3;
        $connection = $this->liveOrMockedConnection([
            $this->mockCreatedResourceResponse($data, $id, User::class),
            $this->mockListOfResourcesResponse($list, User::class, 100, $limit),
            $this->mockDeletedResourceResponse()
        ]);

        // ----------------------------------------------------------------------- //
        // Prerequisites

        $user = User::create($data, [], $connection);

        $this->assertNotEmpty($user->id(), 'User was not created');

        // ----------------------------------------------------------------------- //
        // List Projects

        $users = User::list($limit, 0, [], $connection);

        $this->assertGreaterThanOrEqual(1, count($users->results()), 'Incorrect amount of users returned');

        // ----------------------------------------------------------------------- //
        // Cleanup

        $user->delete();
    }
}
