<?php

namespace Aedart\Tests\Integration\ETags\Preconditions;

use Aedart\Contracts\ETags\Preconditions\Actions;
use Aedart\Contracts\ETags\Preconditions\Evaluator;
use Aedart\Contracts\ETags\Preconditions\ResourceContext;
use Aedart\ETags\Preconditions\BasePrecondition;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Tests\TestCases\ETags\PreconditionsTestCase;
use Codeception\Attribute\Group;
use InvalidArgumentException;
use LogicException;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * EvaluatorTest
 *
 * @group etags
 * @group preconditions
 * @group preconditions-evaluator
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\ETags\Preconditions
 */
#[Group(
    'etags',
    'preconditions',
    'preconditions-evaluator'
)]
class EvaluatorTest extends PreconditionsTestCase
{
    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function canObtainInstance(): void
    {
        $evaluator = $this->makeEvaluator($this->createRequest());

        $this->assertInstanceOf(Evaluator::class, $evaluator);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function hasDefaultPreconditions(): void
    {
        $evaluator = $this->makeEvaluator($this->createRequest());

        $preconditions = $evaluator->getPreconditions();
        $this->assertNotEmpty($preconditions);
    }

    /**
     * @test
     *
     * @return void
     */
    #[Test]
    public function hasDefaultActions(): void
    {
        $evaluator = $this->makeEvaluator($this->createRequest());

        $actions = $evaluator->getActions();
        $this->assertInstanceOf(Actions::class, $actions);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function ignoresRequestWhenMethodNotSupported(): void
    {
        $precondition = new class() extends BasePrecondition {
            public function isApplicable(ResourceContext $resource): bool
            {
                return true;
            }

            public function passes(ResourceContext $resource): bool
            {
                return false;
            }

            public function whenPasses(ResourceContext $resource): ResourceContext|string|null
            {
                throw new InvalidArgumentException('Should NOT pass');
            }

            public function whenFails(ResourceContext $resource): ResourceContext|string|null
            {
                throw new InvalidArgumentException('precondition should NOT be executed');
            }
        };

        // -------------------------------------------------------------------------------- //

        // [...] a server MUST ignore the conditional request header fields [...] when received with a
        // request method that does not involve the selection or modification of a selected representation,
        // such as CONNECT, OPTIONS, or TRACE [...]
        // @see https://httpwg.org/specs/rfc9110.html#when.to.evaluate

        $request = $this->createRequest(
            method: $this->getFaker()->randomElement(['CONNECT', 'OPTIONS', 'TRACE'])
        );

        $evaluator = $this->makeEvaluator($request, [ $precondition ]);

        // -------------------------------------------------------------------------------- //

        $context = $this->makeResourceContext();

        $result = $evaluator->evaluate($context);

        $this->assertSame($context, $result);
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function doesNothingWhenNoPreconditions(): void
    {
        $evaluator = $this->makeEvaluator($this->createRequest());
        $evaluator->clearPreconditions();

        // -------------------------------------------------------------------------------- //

        $context = $this->makeResourceContext();
        $result = $evaluator->evaluate($context);

        $this->assertCount(0, $evaluator->getPreconditions());
        $this->assertSame($context, $result);
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function returnsResourceContextWhenPreconditionsPasses(): void
    {
        $precondition = new class() extends BasePrecondition {
            public function isApplicable(ResourceContext $resource): bool
            {
                return true;
            }

            public function passes(ResourceContext $resource): bool
            {
                return true;
            }

            public function whenPasses(ResourceContext $resource): ResourceContext|string|null
            {
                return $resource->set('foo', 'bar');
            }

            public function whenFails(ResourceContext $resource): ResourceContext|string|null
            {
                throw new InvalidArgumentException('precondition should NOT be executed');
            }
        };

        // -------------------------------------------------------------------------------- //

        $evaluator = $this->makeEvaluator($this->createRequest(), [ $precondition ]);

        // -------------------------------------------------------------------------------- //

        $context = $this->makeResourceContext();
        $result = $evaluator->evaluate($context);

        // -------------------------------------------------------------------------------- //

        $this->assertSame($context, $result);
        $this->assertTrue($result->has('foo'), 'Meta key not set');
        $this->assertSame('bar', $result->get('foo'), 'Invalid meta value');
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function skipsPreconditionsWhenNotApplicable(): void
    {
        $precondition = function (string|null $name) {
            return new class($name) extends BasePrecondition {
                public function __construct(
                    public string|null $name,
                    public bool $isEvaluated = false
                ) {
                }

                public function isApplicable(ResourceContext $resource): bool
                {
                    ConsoleDebugger::output($this->name);
                    $this->isEvaluated = true;

                    return false;
                }

                public function passes(ResourceContext $resource): bool
                {
                    return false;
                }

                public function whenPasses(ResourceContext $resource): ResourceContext|string|null
                {
                    throw new InvalidArgumentException('Should NOT be applicable');
                }

                public function whenFails(ResourceContext $resource): ResourceContext|string|null
                {
                    throw new InvalidArgumentException('Should NOT be applicable');
                }
            };
        };

        $preconditionsList = [
            $precondition('A'),
            $precondition('B'),
            $precondition('C'),
        ];

        // -------------------------------------------------------------------------------- //

        $evaluator = $this->makeEvaluator($this->createRequest(), $preconditionsList);

        // -------------------------------------------------------------------------------- //

        $context = $this->makeResourceContext();
        $result = $evaluator->evaluate($context);

        $this->assertSame($context, $result);

        $a = $evaluator->getPreconditions();
        $total = 0;
        foreach ($a as $c) {
            $this->assertTrue($c->isEvaluated, sprintf('Precondition %s was not evaluated', $c->name));
            $total++;
        }

        $this->assertSame(count($preconditionsList), $total, 'Incorrect amount of preconditions evaluated');
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function canGoToAnotherPrecondition(): void
    {
        // The last precondition...
        $preconditionC = new class() extends BasePrecondition {
            public function isApplicable(ResourceContext $resource): bool
            {
                ConsoleDebugger::output('C is applicable');

                return true;
            }

            public function passes(ResourceContext $resource): bool
            {
                ConsoleDebugger::output('C passes');

                return true;
            }

            public function whenPasses(ResourceContext $resource): ResourceContext|string|null
            {
                return $resource->set('foo', 'bar');
            }

            public function whenFails(ResourceContext $resource): ResourceContext|string|null
            {
                throw new InvalidArgumentException('C should NOT fail');
            }
        };

        // Should not be triggered
        $preconditionB = new class() extends BasePrecondition {
            public function isApplicable(ResourceContext $resource): bool
            {
                ConsoleDebugger::output('B is applicable');

                return true;
            }

            public function passes(ResourceContext $resource): bool
            {
                ConsoleDebugger::output('B passes');

                return true;
            }

            public function whenPasses(ResourceContext $resource): ResourceContext|string|null
            {
                throw new InvalidArgumentException('B should had been skipped');
            }

            public function whenFails(ResourceContext $resource): ResourceContext|string|null
            {
                throw new InvalidArgumentException('B should had been skipped');
            }
        };

        // When A passes, it should return precondition C as its result...
        $preconditionA = new class($preconditionC::class) extends BasePrecondition {
            public function __construct(protected string $nextPrecondition)
            {
            }

            public function isApplicable(ResourceContext $resource): bool
            {
                ConsoleDebugger::output('A is applicable');

                return true;
            }

            public function passes(ResourceContext $resource): bool
            {
                ConsoleDebugger::output('A passes');

                return true;
            }

            public function whenPasses(ResourceContext $resource): ResourceContext|string|null
            {
                return $this->nextPrecondition;
            }

            public function whenFails(ResourceContext $resource): ResourceContext|string|null
            {
                throw new InvalidArgumentException('A should NOT fail...');
            }
        };

        // -------------------------------------------------------------------------------- //

        $evaluator = $this->makeEvaluator($this->createRequest(), [
            $preconditionA,
            $preconditionB, // Should be skipped
            $preconditionC
        ]);

        $context = $this->makeResourceContext();
        $result = $evaluator->evaluate($context);

        $this->assertSame($context, $result);
        $this->assertTrue($result->has('foo'), 'Meta key not set');
        $this->assertSame('bar', $result->get('foo'), 'Invalid meta value');
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function failsWhenIndexOfPreconditionNotFound(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Unable to find unknown_precondition_class_path precondition');

        // -------------------------------------------------------------------------------- //

        $preconditionA = new class() extends BasePrecondition {
            public function isApplicable(ResourceContext $resource): bool
            {
                return true;
            }

            public function passes(ResourceContext $resource): bool
            {
                return true;
            }

            public function whenPasses(ResourceContext $resource): ResourceContext|string|null
            {
                return 'unknown_precondition_class_path';
            }

            public function whenFails(ResourceContext $resource): ResourceContext|string|null
            {
                throw new InvalidArgumentException('A should NOT fail...');
            }
        };

        // -------------------------------------------------------------------------------- //

        $evaluator = $this->makeEvaluator($this->createRequest(), [
            $preconditionA,
        ]);

        $evaluator->evaluate($this->makeResourceContext());
    }

    /**
     * @test
     *
     * @return void
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function failsWhenNextPreconditionIsRankedLowerThanCurrent(): void
    {
        $this->expectException(LogicException::class);
        // $this->expectExceptionMessageMatches('/(It has either already been evaluated, or its ranked before)/g');

        // -------------------------------------------------------------------------------- //

        // A not applicable condition...
        $preconditionA = new class() extends BasePrecondition {
            public function isApplicable(ResourceContext $resource): bool
            {
                ConsoleDebugger::output('A is NOT applicable');

                return false;
            }

            public function passes(ResourceContext $resource): bool
            {
                return false;
            }

            public function whenPasses(ResourceContext $resource): ResourceContext|string|null
            {
                throw new InvalidArgumentException('A should NOT be applicable');
            }

            public function whenFails(ResourceContext $resource): ResourceContext|string|null
            {
                throw new InvalidArgumentException('A should NOT be applicable');
            }
        };

        // Applicable and passes... but returns first precondition (ranked lower) as result...
        $preconditionB = new class($preconditionA::class) extends BasePrecondition {
            public function __construct(protected string $nextPrecondition)
            {
            }

            public function isApplicable(ResourceContext $resource): bool
            {
                ConsoleDebugger::output('B is applicable');

                return true;
            }

            public function passes(ResourceContext $resource): bool
            {
                ConsoleDebugger::output('B passes');

                return true;
            }

            public function whenPasses(ResourceContext $resource): ResourceContext|string|null
            {
                ConsoleDebugger::output(sprintf('B - Attempt to return %s as result (next precondition)', $this->nextPrecondition));

                return $this->nextPrecondition;
            }

            public function whenFails(ResourceContext $resource): ResourceContext|string|null
            {
                throw new InvalidArgumentException('B should NOT fail...');
            }
        };

        // -------------------------------------------------------------------------------- //

        $evaluator = $this->makeEvaluator($this->createRequest(), [
            $preconditionA,
            $preconditionB, // passes, but return A !
        ]);

        $evaluator->evaluate($this->makeResourceContext());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws HttpExceptionInterface
     * @throws Throwable
     */
    #[Test]
    public function proceedsToNextPreconditionWhenEvaluatedToNull(): void
    {
        $precondition = function (string|null $name) {
            return new class($name) extends BasePrecondition {
                public function __construct(
                    public string|null $name
                ) {
                }

                public function isApplicable(ResourceContext $resource): bool
                {
                    ConsoleDebugger::output($this->name);

                    return true;
                }

                public function passes(ResourceContext $resource): bool
                {
                    return true;
                }

                public function whenPasses(ResourceContext $resource): ResourceContext|string|null
                {
                    $passed = $resource->get('passed', []);
                    $passed[] = $this::class;

                    $resource->set('passed', $passed);

                    // Go to next in list of preconditions...
                    return null;
                }

                public function whenFails(ResourceContext $resource): ResourceContext|string|null
                {
                    throw new InvalidArgumentException('Should NOT fail!');
                }
            };
        };

        $preconditionsList = [
            $precondition('A'),
            $precondition('B'),
            $precondition('C'),
        ];

        // -------------------------------------------------------------------------------- //

        $evaluator = $this->makeEvaluator($this->createRequest(), $preconditionsList);

        // -------------------------------------------------------------------------------- //

        $context = $this->makeResourceContext();
        $result = $evaluator->evaluate($context);

        $this->assertSame($context, $result);

        $passed = $result->get('passed', []);
        ConsoleDebugger::output($passed);

        $this->assertCount(count($preconditionsList), $passed, 'Incorrect amount of preconditions evaluated');
    }
}
