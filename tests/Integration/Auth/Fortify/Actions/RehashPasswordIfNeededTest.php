<?php

namespace Aedart\Tests\Integration\Auth\Fortify\Actions;

use Aedart\Auth\Fortify\Actions\RehashPasswordIfNeeded;
use Aedart\Auth\Fortify\Events\PasswordWasRehashed;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Auth\FortifyUser;
use Aedart\Tests\TestCases\Auth\FortifyTestCase;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

/**
 * @deprecated Since v8.x - See \Aedart\Auth\Fortify\Actions\RehashPasswordIfNeeded
 *
 * RehashPasswordIfNeededTest
 *
 * @group auth
 * @group auth-fortify
 * @group auth-fortify-actions
 * @group rehash-password-if-needed-action
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Auth\Fortify\Actions
 */
class RehashPasswordIfNeededTest extends FortifyTestCase
{
    /**
     * @inheritdoc
     */
    protected function _before()
    {
        $this->installMigrations = true;

        parent::_before();
    }

    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new user
     *
     * @param  array  $attributes  [optional]
     *
     * @return FortifyUser
     */
    public function createUser(array $attributes = []): FortifyUser
    {
        $faker = $this->getFaker();

        return FortifyUser::forceCreate(array_merge([
            'name' => $faker->name(),
            'email' => $faker->email(),
            'password' => Hash::make('secret')
        ], $attributes));
    }

    /*****************************************************************
     * Actual tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     */
    public function canAuthenticateUser(): void
    {
        // This is a similar test as Laravel Fortify's "can authentication"
        // test, without any modifications, custom pipelines, etc.
        // Here it serves as a baseline, to ensure that it works out-of-the-box.

        $user = $this->createUser();

        $response = $this->withoutExceptionHandling()->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertRedirect('/home');
    }

    /**
     * @test
     *
     * @return void
     */
    public function notifiesWhenPasswordWasRehashed(): void
    {
        // Create new user... were the default config `hashing.bcrypt.rounds` are used.
        $user = $this->createUser();

        // Disable "rehash_on_login" feature, so the "action" can be tested.
        config()->set('hashing.rehash_on_login', false);

        // Change Hasher (bcrypt) rounds. This must be done on the instance, because
        // the configuration was already read during boot.
        /** @var BcryptHasher $hasher */
        $hasher = Hash::getFacadeRoot()->driver();
        $hasher->setRounds(config('hashing.bcrypt.rounds') + 1);

        // Use custom pipeline with the desired action...
        Fortify::authenticateThrough(function () {
            return array_filter([
                config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
                Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
                AttemptToAuthenticate::class,
                PrepareAuthenticatedSession::class,

                RehashPasswordIfNeeded::class
            ]);
        });

        Event::fake();

        // ----------------------------------------------------------------------- //

        $response = $this->withoutExceptionHandling()->post('/login', [
            'email' => $user->email,
            'password' => 'secret',
        ]);

        $response->assertRedirect('/home');

        // ----------------------------------------------------------------------- //

        Event::assertDispatched(function (PasswordWasRehashed $event) {
            ConsoleDebugger::output([
                'user' => $event->user->toArray(),
                'hashed' => $event->hashed
            ]);

            // Ensure that new password hash isn't the same as current!
            return $event->user->getAuthPassword() !== $event->hashed;
        });
    }
}
