<?php

namespace Aedart\Tests\Integration\Http\Clients;

use Aedart\Contracts\Http\Clients\Exceptions\ProfileNotFoundException;
use Aedart\Contracts\Http\Clients\Requests\Builder;
use Aedart\Contracts\Http\Clients\Requests\Criteria;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\Http\HttpClientsTestCase;
use Codeception\Attribute\DataProvider;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * J0_CriteriaTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Http\Clients
 */
#[Group(
    'http',
    'http-clients',
    'http-clients-j0',
)]
class J0_CriteriaTest extends HttpClientsTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    /**
     * Creates a new criteria
     *
     * @param string $field
     * @param mixed $operator [optional]
     * @param mixed $value [optional]
     *
     * @return Criteria
     */
    public function makeCriteria(string $field, $operator = null, $value = null): Criteria
    {
        return new class($field, $operator, $value) implements Criteria {
            /**
             * @var string
             */
            protected string $field;

            /**
             * @var mixed
             */
            protected $operator;

            /**
             * @var mixed
             */
            protected $value;

            public function __construct($field, $operator, $value)
            {
                $this->field = $field;
                $this->operator = $operator;
                $this->value = $value;
            }

            /**
             * @inheritDoc
             */
            public function apply(Builder $request): void
            {
                $request->where($this->field, $this->operator, $this->value);
            }
        };
    }

    /**
     * Returns a list of criteria
     *
     * @return Criteria[]
     */
    public function criteriaList(): array
    {
        return [
            $this->makeCriteria('created', 'gt', '2020'),
            $this->makeCriteria('created', 'lt', '2051'),
            $this->makeCriteria('income', 'gt', 800),
        ];
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/


    /**
     * @param string $profile
     *
     * @throws ProfileNotFoundException
     */
    #[DataProvider('providesClientProfiles')]
    #[Test]
    public function canApplyCriteria(string $profile)
    {
        $criteria = $this->criteriaList();

        $this
            ->client($profile)
            ->withOption('handler', $this->makeRespondsOkMock())
            ->applyCriteria($criteria)
            ->get('/users');

        $request = $this->lastRequest;
        $query = urldecode($request->getUri()->getQuery());

        ConsoleDebugger::output($query);

        $this->assertStringContainsString('created[gt]=2020', $query);
        $this->assertStringContainsString('created[lt]=2051', $query);
        $this->assertStringContainsString('income[gt]=800', $query);
    }
}
