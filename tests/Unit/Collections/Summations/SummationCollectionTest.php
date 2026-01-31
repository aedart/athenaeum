<?php

namespace Aedart\Tests\Unit\Collections\Summations;

use Aedart\Collections\Exceptions\KeyNotFound;
use Aedart\Collections\Summation;
use Aedart\Contracts\Collections\Summation as SummationInterface;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Utils\Json;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * SummationCollectionTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Collections
 */
#[Group(
    'collections',
    'summations',
    'summation-collection'
)]
class SummationCollectionTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates new Summation Collection instance
     *
     * @param  array  $results  [optional]
     *
     * @return SummationInterface
     */
    public function makeCollection(array $results = []): SummationInterface
    {
        return Summation::make($results);
    }

    /*****************************************************************
     * Data Providers
     ****************************************************************/

    /**
     * Data provider of method names
     *
     * @return array
     */
    public function methodProvider(): array
    {
        return [
            'increase' => [ 'increase' ],
            'decrease' => [ 'decrease' ],
            'multiply' => [ 'multiply' ],
            'divide' => [ 'divide' ],
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    #[Test]
    public function canObtainInstance()
    {
        $summation = $this->makeCollection();

        $this->assertNotNull($summation);
    }

    #[Test]
    public function canSetAndGetValue()
    {
        $key = 'player.strength';
        $value = $this->getFaker()->randomNumber(2);

        $result = $this->makeCollection()
            ->set($key, $value)
            ->get($key);

        $this->assertSame($value, $result);
    }

    #[Test]
    public function canSetAndGetViaArrayAccess()
    {
        $key = 'player.strength';
        $value = $this->getFaker()->randomNumber(2);

        $summation = $this->makeCollection();
        $summation[$key] = $value;
        $result = $summation[$key];

        $this->assertSame($value, $result);
    }

    #[Test]
    public function canSetUsingCallback()
    {
        $key = 'player.strength';
        $value = $this->getFaker()->randomNumber(2);

        $result = $this->makeCollection()
            ->set($key, function () use ($value) {
                return $value;
            })
            ->get($key);

        $this->assertSame($value, $result);
    }

    #[Test]
    public function returnDefaultWhenKeyIsEmpty()
    {
        $key = 'player.strength';
        $value = $this->getFaker()->randomNumber(2);

        $result = $this->makeCollection()
            ->get($key, $value);

        $this->assertSame($value, $result);
    }

    #[Test]
    public function invokesCallbackWhenGivenAsDefault()
    {
        $key = 'player.strength';
        $value = $this->getFaker()->randomNumber(2);

        $result = $this->makeCollection()
            ->get($key, function () use ($value) {
                return $value;
            });

        $this->assertSame($value, $result);
    }

    #[Test]
    public function canDetermineIfKeyExists()
    {
        $key = 'player.dexterity';
        $value = $this->getFaker()->randomNumber(2);

        $summation = $this->makeCollection()
            ->set($key, $value);

        $resultA = $summation->has('none-existing-key');
        $resultB = $summation->has($key);

        $this->assertFalse($resultA, 'Key should not exist');
        $this->assertTrue($resultB, 'Key should exist');
    }

    #[Test]
    public function canDetermineIfKeyExistsViaArrayAccess()
    {
        $key = 'player.dexterity';
        $value = $this->getFaker()->randomNumber(2);

        $summation = $this->makeCollection()
            ->set($key, $value);

        $resultA = isset($summation['none-existing-key']);
        $resultB = isset($summation[$key]);

        $this->assertFalse($resultA, 'Key should not exist');
        $this->assertTrue($resultB, 'Key should exist');
    }

    #[Test]
    public function canDetermineIfKeyHasValue()
    {
        $keyA = 'player.dexterity';
        $keyB = 'player.strength';
        $value = $this->getFaker()->randomNumber(2);

        $summation = $this->makeCollection()
            ->set($keyA, $value)
            ->set($keyB, null);

        $resultA = $summation->hasValue($keyA);
        $resultB = $summation->hasNoValue($keyA);

        $resultC = $summation->hasValue($keyB);
        $resultD = $summation->hasNoValue($keyB);

        $this->assertTrue($resultA, 'key A should have value');
        $this->assertFalse($resultB, 'Key A should not be empty');

        $this->assertFalse($resultC, 'key B should not have value');
        $this->assertTrue($resultD, 'Key B should be empty');
    }

    #[Test]
    public function canDetermineIfKeyHasValueViaArrayAccess()
    {
        $keyA = 'player.dexterity';
        $keyB = 'player.strength';
        $value = $this->getFaker()->randomNumber(2, true);

        $summation = $this->makeCollection()
            ->set($keyA, $value)
            ->set($keyB, null);

        $resultA = empty($summation[$keyA]);
        $resultB = empty($summation[$keyB]);

        $this->assertFalse($resultA, 'A should be set and not empty');
        $this->assertTrue($resultB, 'B should be set, but empty');
    }

    #[Test]
    public function canDetermineIfCollectionIsEmpty()
    {
        $summationA = $this->makeCollection([
            'a' => 1,
            'b' => 2,
            'c' => 3
        ]);

        $summationB = $this->makeCollection();

        $this->assertFalse($summationA->isEmpty(), 'A should not be empty');
        $this->assertTrue($summationA->isNotEmpty(), 'A IS NOT empty');

        $this->assertTrue($summationB->isEmpty(), 'B should be empty');
        $this->assertFalse($summationB->isNotEmpty(), 'B IS EMPTY');
    }

    #[Test]
    public function canRemoveKey()
    {
        $summation = $this->makeCollection([
            'a' => 1,
            'b' => 2,
            'c' => 3
        ]);

        $result = $summation->remove('b');

        $this->assertTrue($result, 'b should had been removed');
        $this->assertFalse($summation->has('b'), 'b should no longer be set');
    }

    #[Test]
    public function canRemoveKeyViaArrayAccess()
    {
        $summation = $this->makeCollection([
            'a' => 1,
            'b' => 2,
            'c' => 3
        ]);

        unset($summation['c']);

        $this->assertFalse($summation->has('c'), 'c should no longer be set');
    }

    #[Test]
    public function canCountElementsInCollection()
    {
        $summation = $this->makeCollection([
            'a' => 1,
            'b' => 2,
            'c' => 3
        ]);

        $this->assertCount(3, $summation);
        $this->assertSame(3, $summation->count(), 'Incorrect amount via count()');
    }

    #[Test]
    public function canLoopThroughElements()
    {
        $results = [
            'a' => 1,
            'b' => 2,
            'c' => 3
        ];

        $summation = $this->makeCollection($results);

        $c = 0;
        foreach ($summation as $key => $value) {
            $this->assertArrayHasKey($key, $results, 'Key does not exist');
            $this->assertSame($results[$key], $value, 'Incorrect value');
            $c++;
        }

        $this->assertSame(count($results), $c, 'Incorrect amount looped through');
    }

    #[Test]
    public function canExportToArray()
    {
        $elements = [
            'a' => 1,
            'b' => 2,
            'c' => 3
        ];

        $result = $this->makeCollection($elements)
            ->toArray();

        $this->assertSame($elements, $result);
    }

    #[Test]
    public function canConvertToJson()
    {
        $elements = [
            'a' => 1,
            'b' => 2,
            'c' => 3
        ];

        $summation = $this->makeCollection($elements);

        $resultA = Json::encode($summation);
        $resultB = $summation->toJson();

        $this->assertJson($resultA, 'Was unable to encode to Json');
        $this->assertJson($resultB, 'Was unable to export to Json');
    }

    #[Test]
    public function canConvertToString()
    {
        $summation = $this->makeCollection([
            'a' => 1,
            'b' => 2,
            'c' => 3
        ]);

        $result = (string)$summation;
        ConsoleDebugger::output($result);

        $this->assertIsString($result);
        $this->assertNotEmpty($result);
    }

    #[Test]
    public function canIncreaseValue()
    {
        $key = 'player.score';

        $result = $this->makeCollection([ $key => 5, ])
            ->increase($key, 10)
            ->get($key);

        $this->assertSame(15, $result);
    }

    #[Test]
    public function canIncreaseValueViaCallback()
    {
        $key = 'player.score';

        $result = $this->makeCollection([ $key => 5, ])
            ->increase($key, function ($value) {
                return $value + 10;
            })
            ->get($key);

        $this->assertSame(15, $result);
    }

    #[Test]
    public function canDecreaseValue()
    {
        $key = 'player.score';

        $result = $this->makeCollection([ $key => 5, ])
            ->decrease($key, 10)
            ->get($key);

        $this->assertSame(-5, $result);
    }

    #[Test]
    public function canDecreaseValueViaCallback()
    {
        $key = 'player.score';

        $result = $this->makeCollection([ $key => 5, ])
            ->decrease($key, function ($value) {
                return $value - 10;
            })
            ->get($key);

        $this->assertSame(-5, $result);
    }

    #[Test]
    public function canMultiplyValue()
    {
        $key = 'player.score';

        $result = $this->makeCollection([ $key => 5, ])
            ->multiply($key, 5)
            ->get($key);

        $this->assertSame(25, $result);
    }

    #[Test]
    public function canMultiplyValueViaCallback()
    {
        $key = 'player.score';

        $result = $this->makeCollection([ $key => 5, ])
            ->multiply($key, function ($value) {
                return $value * 10;
            })
            ->get($key);

        $this->assertSame(50, $result);
    }

    #[Test]
    public function canDivideValue()
    {
        $key = 'player.score';

        $result = $this->makeCollection([ $key => 50, ])
            ->divide($key, 5)
            ->get($key);

        $this->assertSame(10, $result);
    }

    #[Test]
    public function canDivideValueViaCallback()
    {
        $key = 'player.score';

        $result = $this->makeCollection([ $key => 50, ])
            ->divide($key, function ($value) {
                return $value / 10;
            })
            ->get($key);

        $this->assertSame(5, $result);
    }

    /**
     * @param  string  $method
     */
    #[DataProvider('methodProvider')]
    #[Test]
    public function failsArithmeticOperationIfKeyDoesNotExist(string $method)
    {
        $this->expectException(KeyNotFound::class);

        $this->makeCollection()
            ->{$method}('none-existing-key', 10);
    }
}
