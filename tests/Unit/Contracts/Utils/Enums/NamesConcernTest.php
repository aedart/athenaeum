<?php

namespace Aedart\Tests\Unit\Contracts\Utils\Enums;

use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;
use Aedart\Tests\Helpers\Dummies\Contracts\Utils\Enums\BasicState;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * NamesConcernTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Contracts\Utils\Enums
 */
#[Group(
    'contracts',
    'utils',
    'enums',
    'enums-names-concern'
)]
class NamesConcernTest extends UnitTestCase
{
    #[Test]
    public function canListNames(): void
    {
        $names = BasicState::names();

        ConsoleDebugger::output($names);

        $this->assertCount(count(BasicState::cases()), $names, 'Incorrect number of names');
        $this->assertContains('OPEN', $names);
        $this->assertContains('CLOSED', $names);
    }
}
