<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Tests\TestCases\Streams\StreamTestCase;
use Codeception\Attribute\Group;
use PHPUnit\Framework\Attributes\Test;
use Throwable;

/**
 * I0_TransactionTest
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
#[Group(
    'streams',
    'stream-file',
    'stream-file-i0',
)]
class I0_TransactionTest extends StreamTestCase
{
    /**
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Aedart\Contracts\Streams\Exceptions\TransactionException
     * @throws \Codeception\Exception\ConfigurationException
     * @throws Throwable
     */
    #[Test]
    public function canPerformTransactionOnStream()
    {
        $stream = $this->openFileStreamForTransaction('text.txt');

        // We are not going to do anything other than  to return here.
        // specific driver tests should cover stream manipulation,... etc.
        $result = $stream->transaction(fn () => true, 1, 'cwr');

        $this->assertTrue($result);
    }
}
