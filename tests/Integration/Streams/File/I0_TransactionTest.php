<?php

namespace Aedart\Tests\Integration\Streams\File;

use Aedart\Tests\TestCases\Streams\StreamTestCase;

/**
 * I0_TransactionTest
 *
 * @group streams
 * @group streams-file-i0
 * @group stream-transaction
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Integration\Streams\File
 */
class I0_TransactionTest extends StreamTestCase
{
    /**
     * @test
     *
     * @return void
     * @throws \Aedart\Contracts\Streams\Exceptions\StreamException
     * @throws \Aedart\Contracts\Streams\Exceptions\TransactionException
     * @throws \Codeception\Exception\ConfigurationException
     * @throws \Throwable
     */
    public function canPerformTransactionOnStream()
    {
        $stream = $this->openFileStreamForTransaction('text.txt');

        // We are not going to do anything other than  to return here.
        // specific driver tests should cover stream manipulation,... etc.
        $result = $stream->transaction(fn () => true, 1, 'cwr');

        $this->assertTrue($result);
    }
}
