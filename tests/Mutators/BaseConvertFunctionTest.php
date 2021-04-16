<?php


namespace Mutators;


use PHPUnit\Framework\TestCase;
use Zahran\Mapper\Model\Mutator;
use Zahran\Mapper\Mutator\BaseConvert;

class BaseConvertFunctionTest extends TestCase
{
    const MUTATOR_NAME = "base-convert";
    protected $mutatorType;

    function setUp(): void
    {
        parent::setUp();
        $this->mutatorType = new BaseConvert;
        $this->mutatorType->setModel(new Mutator([
            Mutator::ATTRIBUTE_NAME => self::MUTATOR_NAME,
            Mutator::ATTRIBUTE_ARGUMENTS => [],
        ]));
    }

    /** @test */
    function it_converts_a_number_to_different_base()
    {
        $originalValue = 'a37334'; // hexadecimal
        $fromBase = 16;
        $toBase = 2;

        $rebasedValue = $this->mutatorType->apply($originalValue,[$fromBase, $toBase]);
        $this->assertSame( base_convert($originalValue,$fromBase,$toBase), $rebasedValue,"It converts base" );
        $this->assertNotSame( $originalValue, $rebasedValue,"The original value should have changed base" );
    } //EOF it_converts_a_number_to_different_base

    /** @test */
    function it_defaults_to_base_ten_if_missing_second_argument()
    {
        $originalValue = 'a37334'; // hexadecimal
        $fromBase = 16;
        $rebasedValue = $this->mutatorType->apply($originalValue,[$fromBase]);
        $this->assertSame( base_convert($originalValue,$fromBase,10), $rebasedValue,"It defaults to base into base 10" );

    } //EOF it_converts_a_number_to_different_base
}