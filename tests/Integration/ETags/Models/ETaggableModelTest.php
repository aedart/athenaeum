<?php

namespace Aedart\Tests\Integration\ETags\Models;

use Aedart\Contracts\ETags\Exceptions\ETagGeneratorException;
use Aedart\Contracts\ETags\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\ETags\Models\ETaggable;
use Aedart\ETags\Models\Concerns\ModelETags;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Illuminate\Database\Eloquent\Model;

/**
 * ETaggableModelTest
 *
 * @group etags
 * @group etags-etaggable
 * @group etags-eloquent-model
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Models
 */
class ETaggableModelTest extends ETagsTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Makes a new model instance
     *
     * @param  array  $attributes  [optional]
     *
     * @return Model|ETaggable
     */
    public function makeModel(array $attributes = []): Model|ETaggable
    {
        $modelClass = new class extends Model implements ETaggable
        {
            use ModelETags;

            protected $table = 'users';
            protected $fillable = [ 'id' ];
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
    public function canMakeWeakEtagForModel(): void
    {
        $model = $this->makeModel([
            'id' => 1234,
            'updated_at' => now()
        ]);

        $eTag = $model->weakEtag();

        $this->assertNotEmpty($eTag->raw());
        $this->assertTrue($eTag->isWeak(), 'ETag should be weak');

        ConsoleDebugger::output((string) $eTag);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagGeneratorException
     * @throws ProfileNotFoundException
     */
    public function canMakeStrongEtagForModel(): void
    {
        $model = $this->makeModel([
            'id' => 4321,
            'updated_at' => now()
        ]);

        $eTag = $model->strongEtag();

        $this->assertNotEmpty($eTag->raw());
        $this->assertTrue($eTag->isStrong(), 'ETag should NOT be weak');

        ConsoleDebugger::output((string) $eTag);
    }
}