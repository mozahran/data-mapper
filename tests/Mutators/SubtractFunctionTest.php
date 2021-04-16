<?php


namespace Mutators;

use PHPUnit\Framework\TestCase;
use Zahran\Mapper\Model\Mutator;
use Zahran\Mapper\Mutator\Subtract;

class SubtractFunctionTest extends TestCase
{
    const MUTATOR_NAME = "subtract";
    protected $mutatorType;

    function setUp(): void
    {
        parent::setUp();
        $this->mutatorType = new Subtract;
        $this->mutatorType->setModel(new Mutator([
            Mutator::ATTRIBUTE_NAME => self::MUTATOR_NAME,
            Mutator::ATTRIBUTE_ARGUMENTS => [],
        ]));
    }

    /** @test */
    function it_can_subtract_from_original_value()
    {
        $originalValue = 12;
        $subtract = 5;

        $subtractedValue = $this->mutatorType->apply($originalValue,[$subtract]);
        $this->assertSame( ($originalValue - $subtract), $subtractedValue, "Original value should be correctly subtracted");
        $this->assertNotSame( $originalValue, $subtractedValue, "Original value should have mutated");
    } //EOF it_can_subtract_from_original_value

    /** @test */

    function it_can_subtract_from_original_value_multiple_times()
    {
        $originalValue = 12;
        $subtract = 5;
        $thenSubtract = 12;
        $finallySubtract = 43;

        $subtractedValue = $this->mutatorType->apply($originalValue,[$subtract,$thenSubtract,$finallySubtract]);
        $this->assertNotSame( ($originalValue - $subtract), $subtractedValue, "Value not just subtracting the first argument");
        $this->assertSame( ( $originalValue - $subtract - $thenSubtract - $finallySubtract), $subtractedValue, "Original value should subtract each argument supplied");
    } //EOF it_can_subtract_from_original_value_multiple_times
}