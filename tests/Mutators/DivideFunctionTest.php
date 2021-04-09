<?php


namespace Mutators;

use PHPUnit\Framework\TestCase;
use Zahran\Mapper\Model\Mutator;
use Zahran\Mapper\Mutator\Divide;

class DivideFunctionTest extends TestCase
{
    const MUTATOR_NAME = "divide";
    protected $mutatorType;

    function setUp(): void
    {
        parent::setUp();
        $this->mutatorType = new Divide;
        $this->mutatorType->setModel(new Mutator([
            Mutator::ATTRIBUTE_NAME => self::MUTATOR_NAME,
            Mutator::ATTRIBUTE_ARGUMENTS => [],
        ]));
    }

    /** @test */
    function it_can_divide_original_value()
    {
        $originalValue = 12;
        $divideBy = 5;

        $dividedValue = $this->mutatorType->apply($originalValue,[$divideBy]);
        $this->assertSame( ($originalValue / $divideBy), $dividedValue, "Original value should be correctly divided");
        $this->assertNotSame( $originalValue, $dividedValue, "Original value should have mutated");
    } //EOF it_can_divide_original_value

    /** @test */
    function it_can_divide_original_value_multiple_times()
    {
        $originalValue = 12;
        $divideBy = 5;
        $thenDivideBy = 2;

        $dividedValue = $this->mutatorType->apply($originalValue,[$divideBy,$thenDivideBy]);
        $this->assertNotSame( ($originalValue / $divideBy), $dividedValue, "Value not just divided by first argument");
        $this->assertSame( ( $originalValue / $divideBy / $thenDivideBy), $dividedValue, "Original value should be divided by each argument supplied");
    } //EOF it_can_divide_original_value_multiple_times
}