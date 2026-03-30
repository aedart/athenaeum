<?php


namespace Aedart\Tests\Integration\Audit;

use Aedart\Audit\Events\ModelHasChanged;
use Aedart\Audit\Models\AuditTrail;
use Aedart\Contracts\Audit\Types;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Audit\AuditTestCase;
use Codeception\Attribute\Group;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Attributes\Test;

/**
 * AuditTrailTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Audit
 */
#[Group(
    'audit',
    'audit-trail',
    'audit-b0',
)]
class B0_AuditTrailTest extends AuditTestCase
{
    #[Test]
    public function recordsCreateEvent()
    {
        $category = $this->makeCategory();
        $category->save();

        // ---------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = $category->recordedChanges()->first();
        $this->assertNotNull($history);

        // ---------------------------------------------------------- //

        $this->assertSame(Types::CREATED, $history->type);

        $this->assertNull($history->original_data, 'There should not be any original values');
        $this->assertNotNull($history->changed_data, 'Changed data should contain data');

        $changed = $history->changed_data;
        $this->assertArrayHasKey('id', $changed);
        $this->assertSame($category->id, $changed['id']);

        $this->assertArrayHasKey('slug', $changed);
        $this->assertSame($category->slug, $changed['slug']);

        $this->assertArrayHasKey('description', $changed);
        $this->assertSame($category->description, $changed['description']);

        $this->assertArrayNotHasKey('created_at', $changed);
        $this->assertArrayNotHasKey('updated_at', $changed);
    }

    #[Test]
    public function recordsUpdateEvents()
    {
        $description = $this->getFaker()->sentence();
        $category = $this->makeCategory([ 'description' => $description ]);
        $category->save();

        $newDescription = $this->getFaker()->sentence();
        $category->description = $newDescription;
        $category->save();

        // ---------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = $category->recordedChanges->last();
        $this->assertNotNull($history);

        // ---------------------------------------------------------- //

        $this->assertSame(Types::UPDATED, $history->type);

        $this->assertNotNull($history->original_data, 'Original data should contain data');
        $this->assertNotNull($history->changed_data, 'Changed data should contain data');

        $original = $history->original_data;
        $changed = $history->changed_data;

        $this->assertArrayHasKey('description', $original);
        $this->assertArrayHasKey('description', $changed);
        $this->assertSame($description, $original['description']);
        $this->assertSame($category->description, $changed['description']);

        $this->assertArrayNotHasKey('id', $original, 'Original should not have id');
        $this->assertArrayNotHasKey('id', $changed, 'Changed should not have id');
        $this->assertArrayNotHasKey('slug', $original, 'Original should not have slug');
        $this->assertArrayNotHasKey('slug', $changed, 'Changed should not have slug');
        $this->assertArrayNotHasKey('name', $original, 'Original should not have name');
        $this->assertArrayNotHasKey('name', $changed, 'Changed should not have name');
    }

    #[Test]
    public function recordsDeletedEvents()
    {
        $category = $this->makeCategory();
        $category->save();

        $category
            ->refresh()
            ->delete();

        // ---------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = AuditTrail::all()->last();

        // ---------------------------------------------------------- //

        $this->assertSame(Types::DELETED, $history->type);

        $this->assertNull($history->original_data, 'Original data should be null!');
        $this->assertNull($history->changed_data, 'Changed data should be null!');

        // Note that we explicitly cast key and auditable id to string, since we do not know
        // whether an integer or string value is expected.
        $this->assertSame((string)$category->getKey(), (string)$history->auditable_id, 'Id of deleted model not persisted');
    }

    #[Test]
    public function recordsForceDeletedEvents()
    {
        $category = $this->makeCategory();
        $category->save();

        $category
            ->refresh()
            ->forceDelete();

        // ---------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = AuditTrail::all()->last();

        // ---------------------------------------------------------- //

        $this->assertSame(Types::FORCE_DELETED, $history->type);

        $this->assertNull($history->original_data, 'Original data should be null!');
        $this->assertNull($history->changed_data, 'Changed data should be null!');

        // Note that we explicitly cast key and auditable id to string, since we do not know
        // whether an integer or string value is expected.
        $this->assertSame((string)$category->getKey(), (string)$history->auditable_id, 'Id of deleted model not persisted');
    }

    #[Test]
    public function recordsRestoreEvents()
    {
        $category = $this->makeCategory();
        $category->save();
        $category->delete();

        $category->restore();

        // ---------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = AuditTrail::all()->last();

        // ---------------------------------------------------------- //

        $this->assertSame(Types::RESTORED, $history->type);

        $this->assertNull($history->original_data, 'Original data should be null!');
        $this->assertNull($history->changed_data, 'Changed data should be null!');

        // Note that we explicitly cast key and auditable id to string, since we do not know
        // whether an integer or string value is expected.
        $this->assertSame((string)$category->getKey(), (string)$history->auditable_id, 'Id of deleted model not persisted');
    }

    #[Test]
    public function recordsUserThatCausedChange()
    {
        $user = $this->createUser();
        Auth::login($user);

        // ---------------------------------------------------------- //

        $category = $this->makeCategory();
        $category->save();

        // ---------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = $category->recordedChanges()->first();

        // ---------------------------------------------------------- //

        $this->assertNotNull($history->user_id, 'User id not persisted');
    }

    #[Test]
    public function nullsUserIdWhenUserNoLongerExists()
    {
        $user = $this->createUser();
        Auth::login($user);

        // ---------------------------------------------------------- //
        // Delete user in the database, yet ensure that the user instance
        // is still authenticated
        $user->forceDelete();

        $authenticatedUser = Auth::user();
        $this->assertNotNull($authenticatedUser, 'Authenticated is not available, but should be...');

        // ---------------------------------------------------------- //

        $category = $this->makeCategory();
        $category->save();

        // ---------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = $category->recordedChanges()->first();

        // ---------------------------------------------------------- //

        $this->assertNull($history->user_id, 'User id should be null');
    }

    #[Test]
    public function canObtainUserAuditTrail()
    {
        $user = $this->createUser();
        Auth::login($user);

        // ---------------------------------------------------------- //

        $categoryA = $this->makeCategory();
        $categoryA->save();

        $categoryB = $this->makeCategory();
        $categoryB->save();

        $categoryC = $this->makeCategory();
        $categoryC->save();

        // ---------------------------------------------------------- //

        $history = $user->auditTrail;

        // ---------------------------------------------------------- //

        $this->assertCount(3, $history);
    }

    #[Test]
    public function canRecordCustomEvents()
    {
        $faker = $this->getFaker();
        $description = $faker->sentence();
        $category = $this->makeCategory([ 'description' => $description ]);
        $category->save();

        // ---------------------------------------------------------- //


        $newDescription = $faker->words(4, true);
        $type = $faker->slug(5);

        $category->description = $newDescription; // Note: we do not save this change (for this test...)

        // ---------------------------------------------------------- //

        ModelHasChanged::dispatch($category, null, $type);

        // ---------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = AuditTrail::all()->last();

        // ---------------------------------------------------------- //

        $this->assertSame($type, $history->type);

        $this->assertNotNull($history->original_data, 'Original data should contain data');
        $this->assertNotNull($history->changed_data, 'Changed data should contain data');

        $original = $history->original_data;
        $changed = $history->changed_data;

        $this->assertArrayHasKey('description', $original);
        $this->assertArrayHasKey('description', $changed);
        $this->assertSame($description, $original['description']);
        $this->assertSame($newDescription, $changed['description']);
    }

    #[Test]
    public function canSkipNextRecordingChange()
    {
        $category = $this->makeCategory();
        $category
            ->skipRecordingNextChange()
            ->save();

        // ---------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = $category->recordedChanges()->get();

        $this->assertEmpty($history);
    }

    /**
     * @return void
     */
    #[Test]
    public function canRecordCustomChanges(): void
    {
        $category = $this->makeCategory();
        $category->save();

        // ---------------------------------------------------------- //

        $category->recordNewChange(
            type: 'custom',
            original: [ 'a' => null ],
            changed: [ 'a' => true ]
        );

        // ---------------------------------------------------------- //

        /** @var AuditTrail $history */
        $history = $category->recordedChanges()->get()->last();

        ConsoleDebugger::output($history->toArray());

        $this->assertSame('custom', $history->type);
        $this->assertSame([ 'a' => null ], $history->original_data);
        $this->assertSame([ 'a' => true ], $history->changed_data);
    }
}
