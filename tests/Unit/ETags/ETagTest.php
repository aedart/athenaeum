<?php

namespace Aedart\Tests\Unit\ETags;

use Aedart\Contracts\ETags\ETag as ETagInterface;
use Aedart\Contracts\ETags\Exceptions\ETagException;
use Aedart\ETags\ETag;
use Aedart\ETags\Exceptions\InvalidRawValue;
use Aedart\ETags\Exceptions\UnableToParseETag;
use Aedart\Testing\Helpers\ConsoleDebugger;
use Aedart\Testing\TestCases\UnitTestCase;

/**
 * ETagTest
 *
 * @group etags
 * @group etag-dto
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Tests\Unit\ETags
 */
class ETagTest extends UnitTestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function canMakeNewInstance(): void
    {
        $raw = '1234';
        $etag = ETag::make($raw);

        ConsoleDebugger::output($etag);

        // When no failure, then test passes
        $this->assertInstanceOf(ETagInterface::class, $etag);
        $this->assertSame($raw, $etag->raw(), 'Invalid raw value');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagException
     */
    public function failsWhenEmptyRawValue(): void
    {
        $this->expectException(InvalidRawValue::class);

        ETag::make('');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagException
     */
    public function canParseFromHttpHeaderValue(): void
    {
        $raw = '0815';
        $value = 'W/"' . $raw . '"';

        $etag = ETag::parse($value);

        ConsoleDebugger::output($etag);

        $this->assertSame($raw, $etag->raw());
        $this->assertTrue($etag->isWeak());
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagException
     */
    public function failsParsingWhenValueInvalid(): void
    {
        $this->expectException(UnableToParseETag::class);

        $raw = '0815';
        $value = '/"' . $raw;

        ETag::parse($value);
    }

    /**
     * @test
     *
     * @return void
     */
    public function formatsValueCorrectly(): void
    {
        $etag = ETag::make(1234);
        $weakETag = ETag::make(1234, true);

        $this->assertSame('"1234"', (string) $etag);
        $this->assertSame('W/"1234"', (string) $weakETag);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagException
     */
    public function canMatchEtags(): void
    {
        //  @see https://httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2
        /**
            ETag 1 	ETag 2 	Strong Comparison 	Weak Comparison
            W/"1" 	W/"1" 	no match 	        match
            W/"1" 	W/"2" 	no match 	        no match
            W/"1" 	"1" 	no match 	        match
            "1" 	"1" 	match 	            match
         */

        // ----------------------------------------------------------- //
        // ETag 1 	ETag 2 	Strong Comparison 	Weak Comparison
        // W/"1" 	W/"1" 	no match 	        match
        $etagA = ETag::parse('W/"0815"');
        $etagB = ETag::parse('W/"0815"');

        $this->assertFalse($etagA->matches($etagB, true), '(a) strong comparison should NOT match');
        $this->assertTrue($etagA->matches($etagB), '(b) weak comparison should match');

        // ----------------------------------------------------------- //
        // ETag 1 	ETag 2 	Strong Comparison 	Weak Comparison
        // W/"1" 	W/"2" 	no match 	        no match
        $etagA = ETag::parse('W/"0815"');
        $etagB = ETag::parse('W/"0932"');

        $this->assertFalse($etagA->matches($etagB, true), '(c) strong comparison should NOT match');
        $this->assertFalse($etagA->matches($etagB), '(d) weak comparison should NOT match');

        // ----------------------------------------------------------- //
        // ETag 1 	ETag 2 	Strong Comparison 	Weak Comparison
        // W/"1" 	"1" 	no match 	        match
        $etagA = ETag::parse('W/"0815"');
        $etagB = ETag::parse('"0815"');

        $this->assertFalse($etagA->matches($etagB, true), '(e) strong comparison should NOT match');
        $this->assertTrue($etagA->matches($etagB), '(f) weak comparison should match');

        // ----------------------------------------------------------- //
        // ETag 1 	ETag 2 	Strong Comparison 	Weak Comparison
        // "1" 	    "1" 	match 	            match
        $etagA = ETag::parse('"0815"');
        $etagB = ETag::parse('"0815"');

        $this->assertTrue($etagA->matches($etagB, true), '(g) strong comparison should match');
        $this->assertTrue($etagA->matches($etagB), '(h) weak comparison should match');

        // ----------------------------------------------------------- //
        // Not match test...
        $etagA = ETag::parse('W/"0815"');
        $etagB = ETag::parse('"0815"');

        $this->assertTrue($etagA->doesNotMatch($etagB, true), '(i) strong comparison should NOT match');
        $this->assertFalse($etagA->doesNotMatch($etagB), '(j) weak comparison should match');
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws ETagException
     */
    public function canMatchAgainstHttpHeaderValue(): void
    {
        $etag = ETag::make(1234);

        $this->assertTrue($etag->matches('"1234"'), '(a) should had matched value');
        $this->assertFalse($etag->doesNotMatch('"1234"'), '(b) should had matched value');
    }
}