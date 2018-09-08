<?php

namespace Aedart\Tests\TestCases;

use Aedart\Testing\GetterSetterTraitTester;
use Aedart\Testing\TestCases\UnitTestCase;

/**
 * Trait Test Case
 *
 * <br />
 *
 * Test case for default "getter-setter-trait".
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases
 */
abstract class TraitTestCase extends UnitTestCase
{
    use GetterSetterTraitTester;
}
