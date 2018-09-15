<?php

namespace Aedart\Tests\TestCases\Dto;

use Aedart\Testing\TestCases\IntegrationTestCase;
use Aedart\Tests\Helpers\Dummies\Dto\Person;

/**
 * DTo Test Case
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\TestCases\Dto
 */
abstract class DtoTestCase extends IntegrationTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Returns a new Dto instance
     *
     * @param array $data [optional]
     * @return Person
     *
     * @throws \Throwable
     */
    public function makeDto(array $data = [])
    {
        return Person::makeNew($data);
    }
}
