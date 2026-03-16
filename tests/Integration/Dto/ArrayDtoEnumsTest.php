<?php

namespace Aedart\Tests\Integration\Dto;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\Helpers\Dummies\Dto\Availability;
use Aedart\Tests\Helpers\Dummies\Dto\InvalidProductStatus;
use Aedart\Tests\Helpers\Dummies\Dto\ProductStatus;
use Aedart\Tests\TestCases\Dto\DtoTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Throwable;
use TypeError;

/**
 * ArrayDtoEnumsTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Dto
 */
#[Group(
    'dto',
    'array-dto',
    'dto-nested',
    'array-dto-enum',
)]
class ArrayDtoEnumsTest extends DtoTestCase
{
    /**
     * @throws Throwable
     */
    #[Test]
    public function canPopulateWithBackedEnum(): void
    {
        $faker = $this->getFaker();

        $data = [
            'id' => $faker->randomDigit(),
            'name' => $faker->word(),
            'description' => $faker->sentence(),
            'status' => $faker->randomElement(
                ProductStatus::cases()
            ),
        ];

        $dto = $this->makeArrayDtoWithEnum($data);
        ConsoleDebugger::output($dto);

        $this->assertSame($data['status'], $dto->status);
    }

    /**
     * @throws Throwable
     */
    #[Test]
    public function canPopulateWithBackedEnumValue(): void
    {
        $faker = $this->getFaker();

        /** @var ProductStatus $status */
        $status = $faker->randomElement(
            ProductStatus::cases()
        );

        $data = [
            'id' => $faker->randomDigit(),
            'name' => $faker->word(),
            'description' => $faker->sentence(),
            'status' => $status->value
        ];

        $dto = $this->makeArrayDtoWithEnum($data);
        ConsoleDebugger::output($dto);

        $this->assertSame($status, $dto->status);
    }

    /**
     * @throws Throwable
     */
    #[Test]
    public function failsWhenAttemptingToPopulateWithUnitEnum(): void
    {
        $this->expectException(TypeError::class);

        $faker = $this->getFaker();

        /** @var InvalidProductStatus $status */
        $status = $faker->randomElement(
            InvalidProductStatus::cases()
        );

        $data = [
            'id' => $faker->randomDigit(),
            'name' => $faker->word(),
            'description' => $faker->sentence(),
            'status' => $status
        ];

        $this->makeArrayDtoWithEnum($data);
    }

    /**
     * @throws Throwable
     */
    #[Test]
    public function failsWhenAttemptingToPopulateWithUnsupportedValue(): void
    {
        $this->expectException(TypeError::class);

        $faker = $this->getFaker();

        $status = 'unknown-enum-value';

        $data = [
            'id' => $faker->randomDigit(),
            'name' => $faker->word(),
            'description' => $faker->sentence(),
            'status' => $status
        ];

        $this->makeArrayDtoWithEnum($data);
    }

    /**
     * @throws Throwable
     */
    #[Test]
    public function canResolveBackedEnumFromValueInUnionType(): void
    {
        $faker = $this->getFaker();

        $availability = $faker->randomElement(
            Availability::cases()
        );

        $data = [
            'id' => $faker->randomDigit(),
            'name' => $faker->word(),
            'description' => $faker->sentence(),
            'status' => $faker->randomElement(
                ProductStatus::cases()
            ),
            'availability' => $availability->value
        ];

        $dto = $this->makeArrayDtoWithEnum($data);
        ConsoleDebugger::output($dto);

        $this->assertSame($availability, $dto->availability);
    }

    /**
     * @throws Throwable
     */
    #[Test]
    public function ResolvesNullForBackedEnumInUnionType(): void
    {
        $faker = $this->getFaker();

        $data = [
            'id' => $faker->randomDigit(),
            'name' => $faker->word(),
            'description' => $faker->sentence(),
            'status' => $faker->randomElement(
                ProductStatus::cases()
            ),
            'availability' => null
        ];

        $dto = $this->makeArrayDtoWithEnum($data);
        ConsoleDebugger::output($dto);

        $this->assertNull($dto->availability);
    }
}