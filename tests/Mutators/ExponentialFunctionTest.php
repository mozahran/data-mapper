<?php


namespace Mutators;

use PHPUnit\Framework\TestCase;
use Zahran\Mapper\Model\Mutator;
use Zahran\Mapper\Mutator\Exponential;

class ExponentialFunctionTest extends TestCase
{
    const MUTATOR_NAME = "exponential";
    protected $mutatorType;

    function setUp(): void
    {
        parent::setUp();
        $this->mutatorType = new Exponential;
        $this->mutatorType->setModel(new Mutator([
            Mutator::ATTRIBUTE_NAME => self::MUTATOR_NAME,
            Mutator::ATTRIBUTE_ARGUMENTS => [],
        ]));
    }

    /** @test */
    function it_can_raise_the_power_of_original_value()
    {
        $originalValue = 12;
        $raisedToPowerOf = 3;

        $mutatedValue = $this->mutatorType->apply($originalValue,[$raisedToPowerOf]);
        $this->assertSame( ($originalValue ** $raisedToPowerOf), $mutatedValue, "Original value should be correctly raised to the power");
        $this->assertNotSame( $originalValue, $mutatedValue, "Original value should have mutated");
    } //EOF it_can_raise_the_power_of_original_value

    /** @test */

    function it_can_raise_the_power_of_the_original_value_multiple_times()
    {
        $originalValue = 34;
        $raiseToThePowerOf = 2;
        $thenRaiseTo = 2;

        $mutatedValue = $this->mutatorType->apply($originalValue,[$raiseToThePowerOf,$thenRaiseTo]);
        $this->assertNotSame( ($originalValue ** $raiseToThePowerOf), $mutatedValue, "Value not just raising the power of the first argument");
        $this->assertSame( ( $originalValue ** $raiseToThePowerOf ** $thenRaiseTo), $mutatedValue, "Original value should raise to the power of each argument supplied");
    } //EOF it_can_raise_the_power_of_the_original_value_multiple_times
}