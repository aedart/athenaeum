<?php

namespace Aedart\Tests\Integration\ETags\Models;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\ETags\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\ETags\HasEtag;
use Aedart\ETags\Concerns\EloquentEtag;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Codeception\Attribute\Group;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\Test;

/**
 * EloquentEtagsTest
 *
 * @group etags
 * @group etags-eloquent-model
 * @group etags-eloquent-model-etags
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Models
 */
#[Group(
    'etags',
    'etags-eloquent-model',
    'etags-eloquent-model-etags'
)]
class EloquentEtagsTest extends ETagsTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Makes a new model instance
     *
     * @param  array  $attributes  [optional]
     *
     * @return Model|HasEtag
     */
    public function makeModel(array $attributes = []): Model|HasEtag
    {
        $modelClass = new class() extends Model implements HasEtag {
            use EloquentEtag;

            protected $table = 'users';

            // NOTE: We need to declare all that is fillable or some
            // of the tests might not works as intended...
            protected $fillable = [
                'id',
                'name',
                'age',
                'updated_at',
            ];
        };

        return new $modelClass($attributes);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagGeneratorException
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canMakeWeakEtagForModel(): void
    {
        $model = $this->makeModel([
            'id' => 1234,
            'name' => 'Sabrina',
            'updated_at' => now()
        ]);

        $etag = $model->makeWeakEtag();

        $this->assertNotEmpty($etag->raw());
        $this->assertTrue($etag->isWeak(), 'ETag should be weak');

        ConsoleDebugger::output((string) $etag);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagGeneratorException
     * @throws ProfileNotFoundException
     */
    #[Test]
    public function canMakeStrongEtagForModel(): void
    {
        $model = $this->makeModel([
            'id' => 4321,
            'name' => 'Albert',
            'updated_at' => now()
        ]);

        $etag = $model->makeStrongEtag();

        $this->assertNotEmpty($etag->raw());
        $this->assertTrue($etag->isStrong(), 'ETag should NOT be weak');

        ConsoleDebugger::output((string) $etag);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagGeneratorException
     */
    #[Test]
    public function returnsCachedEtagWhenAvailable(): void
    {
        $model = $this->makeModel([
            'id' => 4321,
            'name' => 'Jane',
            'updated_at' => now()
        ])->syncOriginal(); // A little cheating to trick model in thinking attributes are original!

        $etagA = $model->getWeakEtag();
        $etagB = $model->getWeakEtag();

        $etagC = $model->getStrongEtag();
        $etagD = $model->getStrongEtag();

        ConsoleDebugger::output((string) $etagA, (string) $etagB);
        ConsoleDebugger::output((string) $etagC, (string) $etagD);
        $this->assertSame($etagA, $etagB, '(weak) Not same instance of etag returned');
        $this->assertSame($etagC, $etagD, '(strong) Not same instance of etag returned');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagGeneratorException
     */
    #[Test]
    public function canForceNewEtag(): void
    {
        $model = $this->makeModel([
            'id' => 4321,
            'name' => 'Jane',
            'updated_at' => now()
        ])->syncOriginal(); // A little cheating to trick model in thinking attributes are original!

        $etagA = $model->getWeakEtag();
        $etagB = $model->getWeakEtag();
        $etagC = $model->getWeakEtag(true);

        ConsoleDebugger::output((string) $etagA, (string) $etagB, (string) $etagC);
        $this->assertSame($etagA, $etagB, '(weak) Not same instance of etag returned');
        $this->assertNotSame($etagA, $etagC, '(forced) should not be same instance');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagGeneratorException
     */
    #[Test]
    public function invalidatesCachedEtagWhenAttributesChange(): void
    {
        $model = $this->makeModel([
            'id' => 4321,
            'updated_at' => now()
        ]);

        $etagA = $model->getStrongEtag();

        // ---------------------------------------------------------------------- //

        $model->id = 5478;
        $etagB = $model->getStrongEtag();

        ConsoleDebugger::output((string) $etagA, (string) $etagB);
        $this->assertNotSame($etagA, $etagB, 'Cached etags should had been invalidated');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagGeneratorException
     */
    #[Test]
    public function invalidatesCachedEtagWhenModelFilled(): void
    {
        $model = $this->makeModel([
            'id' => 4321,
            'name' => 'Jack',
            'updated_at' => now()
        ]);

        $etagA = $model->getStrongEtag();

        // ---------------------------------------------------------------------- //

        $model->fill([
            'name' => 'Jack Simpson',
            'age' => 27
        ]);

        $etagB = $model->getStrongEtag();

        ConsoleDebugger::output((string) $etagA, (string) $etagB);
        $this->assertNotSame($etagA, $etagB, 'Cached etags should had been invalidated');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagGeneratorException
     */
    #[Test]
    public function canClearCachedEtags(): void
    {
        $model = $this->makeModel([
            'id' => 4321,
            'name' => 'Jane',
            'updated_at' => now()
        ])->syncOriginal(); // A little cheating to trick model in thinking attributes are original!

        $etagA = $model->getWeakEtag();
        $etagB = $model
            ->clearCachedEtag()
            ->getWeakEtag();

        ConsoleDebugger::output((string) $etagA, (string) $etagB);
        $this->assertNotSame($etagA, $etagB, 'Cached etags should had been cleared');
    }
}
