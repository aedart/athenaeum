<?php

namespace Aedart\Tests\Unit\Pagination;

use Aedart\Pagination\Paginator;
use Aedart\Testing\TestCases\UnitTestCase;
use Codeception\Attribute\Group;
use LogicException;
use PHPUnit\Framework\Attributes\Test;

/**
 * PaginatorTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\Pagination
 */
#[Group(
    'pagination',
    'paginator'
)]
class PaginatorTest extends UnitTestCase
{
    /*****************************************************************
     * Helpers
     ****************************************************************/

    public function makePaginator(int $total, int $limit = 10, int $offset = 0)
    {
        return new Paginator($total, $limit, $offset);
    }

    /*****************************************************************
     * Actual Tests
     ****************************************************************/

    #[Test]
    public function canSetTotalLimitAndOffset()
    {
        $total = 10;
        $limit = 2;
        $offset = 3;
        $paginator = $this->makePaginator($total, $limit, $offset);

        $this->assertSame($total, $paginator->total(), 'Incorrect total');
        $this->assertSame($limit, $paginator->limit(), 'Incorrect limit');
        $this->assertSame($offset, $paginator->offset(), 'Incorrect offset');
    }

    #[Test]
    public function failsWhenNegativeTotalProvided()
    {
        $this->expectException(LogicException::class);

        $this->makePaginator(-1);
    }

    #[Test]
    public function failsWhenLessThanOneLimitProvided()
    {
        $this->expectException(LogicException::class);

        $this->makePaginator(0, 0);
    }

    #[Test]
    public function failsWhenNegativeOffsetProvided()
    {
        $this->expectException(LogicException::class);

        $this->makePaginator(0, 1, -1);
    }

    #[Test]
    public function resolvesCurrentPage()
    {
        $paginator = $this->makePaginator(3, 1);

        // 1. page
        $this->assertSame(1, $paginator->currentPage(), 'invalid 1. page');

        // 2. page
        $paginator->setOffset(1);
        $this->assertSame(2, $paginator->currentPage(), 'invalid 2. page');

        // 3. page
        $paginator->setOffset(2);
        $this->assertSame(3, $paginator->currentPage(), 'invalid 3. page');
    }

    #[Test]
    public function resolvesFirstAndLastPages()
    {
        $paginator = $this->makePaginator(10, 3);

        $this->assertSame(1, $paginator->firstPage(), 'invalid 1. page');
        $this->assertSame(4, $paginator->lastPage(), 'invalid last page / total pages');
    }

    #[Test]
    public function resolvesNextAndPreviousPages()
    {
        $paginator = $this->makePaginator(3, 1);

        // When on 1. page
        $this->assertNull($paginator->previousPage(), 'Invalid prev. when on 1. page');
        $this->assertSame(2, $paginator->nextPage(), 'Invalid next when on 1. page');

        // When on 2. page
        $paginator->setOffset(1);
        $this->assertSame(1, $paginator->previousPage(), 'Invalid prev. when on 2. page');
        $this->assertSame(3, $paginator->nextPage(), 'Invalid next when on 2. page');

        // When on 3. page
        $paginator->setOffset(2);
        $this->assertSame(2, $paginator->previousPage(), 'Invalid prev. when on 3. page');
        $this->assertNull($paginator->nextPage(), 'Invalid next when on 3. page');
    }

    #[Test]
    public function getObtainOffsetForPage()
    {
        $paginator = $this->makePaginator(10, 2);

        $this->assertSame(5, $paginator->lastPage(), 'Invalid last page!');

        $this->assertSame(0, $paginator->offsetForPage(1), 'Invalid offset for page 1');
        $this->assertSame(2, $paginator->offsetForPage(2), 'Invalid offset for page 2');
        $this->assertSame(4, $paginator->offsetForPage(3), 'Invalid offset for page 3');
        $this->assertSame(6, $paginator->offsetForPage(4), 'Invalid offset for page 4');
        $this->assertSame(8, $paginator->offsetForPage(5), 'Invalid offset for page 5');
    }

    #[Test]
    public function offsetForPreviousAndNextPages()
    {
        $paginator = $this->makePaginator(3, 1);

        // When on 1. page
        $paginator->setPage(1);
        $this->assertSame(0, $paginator->previousPageOffset(), 'Invalid prev. offset when on 1. page');
        $this->assertSame(1, $paginator->nextPageOffset(), 'Invalid next offset when on 1. page');

        // When on 2. page
        $paginator->setPage(2);
        $this->assertSame(0, $paginator->previousPageOffset(), 'Invalid prev. offset when on 2. page');
        $this->assertSame(2, $paginator->nextPageOffset(), 'Invalid next offset when on 2. page');

        // When on 3. page
        $paginator->setPage(3);
        $this->assertSame(1, $paginator->previousPageOffset(), 'Invalid prev. offset when on 3. page');
        $this->assertSame(2, $paginator->nextPageOffset(), 'Invalid next offset when on 3. page');
    }
}
