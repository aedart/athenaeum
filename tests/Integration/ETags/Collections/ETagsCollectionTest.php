<?php

namespace Aedart\Tests\Integration\ETags\Collections;

use Aedart\Contracts\ETags\Collection;
use Aedart\Contracts\ETags\ETag;
use Aedart\Contracts\ETags\Exceptions\ETagException;
use Aedart\ETags\ETagsCollection;
use Aedart\ETags\Exceptions\InvalidETagCollectionEntry;
use Aedart\ETags\Facades\Generator;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\ETagsTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\Group;
use JsonException;
use PHPUnit\Framework\Attributes\Test;

/**
 * ETagsCollectionTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Collections
 */
#[Group(
    'etags',
    'etags-collection',
)]
class ETagsCollectionTest extends ETagsTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new etags collection instance
     *
     * @param  ETag[]  $etags  [optional]
     *
     * @return Collection
     *
     * @throws ETagException
     */
    public function makeCollection(array $etags = []): Collection
    {
        return ETagsCollection::make($etags);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    /**
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function canMakeInstance(): void
    {
        $collection = $this->makeCollection();

        $this->assertInstanceOf(Collection::class, $collection);
    }

    /**
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function canMakeInstanceWithEtags(): void
    {
        $collection = $this->makeCollection([
            Generator::parseSingle('"1234"'),
            Generator::parseSingle('"5678"'),
            Generator::parseSingle('"9101"'),
        ]);

        $this->assertFalse($collection->isEmpty(), 'collection should not be empty');
        $this->assertTrue($collection->isNotEmpty(), 'collection is empty, but should not be !?!');
        $this->assertCount(3, $collection, 'Incorrect amount of etags in collection');
    }

    /**
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function canObtainAllEtags(): void
    {
        $collection = $this->makeCollection([
            Generator::parseSingle('"1234"'),
            Generator::parseSingle('"5678"'),
            Generator::parseSingle('"9101"'),
        ]);

        $etags = $collection->all();

        $c = 0;
        foreach ($etags as $index => $etag) {
            ConsoleDebugger::output((string) $etag);

            $this->assertInstanceOf(ETag::class, $etag, "[{$index}] is not an ETag!");
            $c++;
        }

        $this->assertSame(3, $c, 'Incorrect amount etags obtained from collection');
    }

    /**
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function canIterateThroughCollection(): void
    {
        $collection = $this->makeCollection([
            Generator::parseSingle('"1234"'),
            Generator::parseSingle('"5678"'),
            Generator::parseSingle('"9101"'),
        ]);

        $c = 0;
        foreach ($collection as $index => $etag) {
            ConsoleDebugger::output((string) $etag);

            $this->assertInstanceOf(ETag::class, $etag, "[{$index}] is not an ETag!");
            $c++;
        }

        $this->assertSame(3, $c, 'Incorrect amount etags obtained from collection');
    }

    /**
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function canExportToJson(): void
    {
        $collection = $this->makeCollection([
            Generator::parseSingle('"1234"'),
            Generator::parseSingle('"5678"'),
            Generator::parseSingle('W/"9101"'),
        ]);

        $result = $collection->toJson(JSON_PRETTY_PRINT);
        ConsoleDebugger::output($result);
        $this->assertTrue(Json::isValid($result));

        $decoded = Json::decode($result, true);
        ConsoleDebugger::output($decoded);
        $this->assertNotEmpty($decoded);

        // If able to parse value into an ETag, then pass...
        foreach ($decoded as $value) {
            $this->assertIsString($value, 'Value SHOULD be a string!');

            $etag = Generator::parseSingle($value);
            ConsoleDebugger::output($etag);
        }
    }

    /**
     * @return void
     *
     * @throws ETagException
     * @throws JsonException
     */
    #[Test]
    public function canSerialiseToJson(): void
    {
        $collection = $this->makeCollection([
            Generator::parseSingle('"1234"'),
            Generator::parseSingle('"5678"'),
            Generator::parseSingle('W/"9101"'),
        ]);

        $result = Json::encode($collection, JSON_PRETTY_PRINT);
        ConsoleDebugger::output($result);

        $decoded = Json::decode($result, true);
        ConsoleDebugger::output($decoded);
        $this->assertNotEmpty($decoded);

        // If able to parse value into an ETag, then pass...
        foreach ($decoded as $value) {
            $this->assertIsString($value, 'Value SHOULD be a string!');

            $etag = Generator::parseSingle($value);
            ConsoleDebugger::output($etag);
        }
    }

    /**
     * @return void
     * @throws ETagException
     */
    #[Test]
    public function canExportToString(): void
    {
        $collection = $this->makeCollection([
            Generator::parseSingle('"bcc458"'),
            Generator::parseSingle('"9842"'),
            Generator::parseSingle('W/"vv54gh7"'),
        ]);

        $resultA = $collection->toString();
        $resultB = (string) $collection;

        ConsoleDebugger::output($resultA);
        ConsoleDebugger::output($resultB);

        $this->assertNotEmpty($resultA, '(a) is empty');
        $this->assertNotEmpty($resultB, '(b) is empty');
        $this->assertSame($resultA, $resultB, 'output differs between export to string and string cast');

        $newCollection = Generator::parse($resultA);
        ConsoleDebugger::output($newCollection->all());
        $this->assertCount($collection->count(), $newCollection, 'Incorrect amount parsed from string output');
    }

    /**
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function canAccessCollectionLikeAnArray(): void
    {
        $collection = $this->makeCollection([
            Generator::parseSingle('"bcc458"'),
            Generator::parseSingle('"9842"'),
            Generator::parseSingle('W/"vv54gh7"'),
        ]);

        $this->assertTrue(isset($collection[2]), 'expected etag to exist at index');
        $this->assertFalse(isset($collection[3]), 'expected etag NOT to exist at index');

        $a = $collection[1];
        $this->assertInstanceOf(ETag::class, $a, 'wrong element returned from collection');
        $this->assertSame('9842', $a->raw(), 'Wrong etag returned');

        unset($collection[0]);
        $this->assertFalse(isset($collection[0]), 'removed etag still exists!');
        $this->assertCount(2, $collection, 'Etag was not removed');

        $collection[] = Generator::parseSingle('"0001"');
        ConsoleDebugger::output((string) $collection);
        $this->assertCount(3, $collection, 'failed pushing new etag into collection');

        $collection[27] = Generator::parseSingle('"0x34"');
        ConsoleDebugger::output((string) $collection);
        $this->assertTrue(isset($collection[27]), 'expected etag to exist after set via index');
    }

    /**
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function preventsCreatingMixedEtagsWithWildcardETag(): void
    {
        $this->expectException(InvalidETagCollectionEntry::class);

        $this->makeCollection([
            Generator::parseSingle('"bcc458"'),
            Generator::parseSingle('"9842"'),

            // This should cause exception...
            Generator::parseSingle('*'),
        ]);
    }

    /**
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function preventsAddingWildcardEtagToListOfETags(): void
    {
        $this->expectException(InvalidETagCollectionEntry::class);

        $collection = $this->makeCollection([
            Generator::parseSingle('"bcc458"'),
            Generator::parseSingle('"9842"'),
        ]);

        $collection[] = Generator::parseSingle('*');
    }

    /**
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function preventsAddingEtagToSingleWildcardCollection(): void
    {
        $this->expectException(InvalidETagCollectionEntry::class);

        $collection = $this->makeCollection([
            Generator::parseSingle('*')
        ]);

        $collection[] = Generator::parseSingle('"9842"');
    }

    /**
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function preventsReplacingExistingIfListOfEtags(): void
    {
        $this->expectException(InvalidETagCollectionEntry::class);

        $collection = $this->makeCollection([
            Generator::parseSingle('"bcc458"'),
            Generator::parseSingle('"9842"'),
        ]);

        $collection[1] = Generator::parseSingle('*');
    }

    /**
     * @return void
     *
     * @throws ETagException
     */
    #[Test]
    public function canReplaceWildcardWithRegularEtag(): void
    {
        $collection = $this->makeCollection([
            Generator::parseSingle('*')
        ]);

        $collection[0] = Generator::parseSingle('"bcc458"');
    }
}
