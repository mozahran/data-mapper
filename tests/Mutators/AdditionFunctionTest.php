<?php


namespace Mutators;

use PHPUnit\Framework\TestCase;
use Zahran\Mapper\Model\Mutator;
use Zahran\Mapper\Mutator\Add;

class AdditionFunctionTest extends TestCase
{
    const MUTATOR_NAME = "add";
    protected $mutatorType;

    function setUp(): void
    {
        parent::setUp();
        $this->mutatorType = new Add;
        $this->mutatorType->setModel(new Mutator([
            Mutator::ATTRIBUTE_NAME => self::MUTATOR_NAME,
            Mutator::ATTRIBUTE_ARGUMENTS => [],
        ]));
    }

    /** @test */
    function it_can_add_to_original_value()
    {
        $originalValue = 12;
        $add = 5;

        $addedValue = $this->mutatorType->apply($originalValue,[$add]);
        $this->assertSame( ($originalValue + $add), $addedValue, "Original value should be correctly added together");
        $this->assertNotSame( $originalValue, $addedValue, "Original value should have mutated");
    } //EOF it_can_add_to_original_value

    /** @test */

    function it_can_add_original_value_multiple_times()
    {
        $originalValue = 12;
        $add = 5;
        $thenAnd = 12;
        $finallyAdd = 43;

        $addedValue = $this->mutatorType->apply($originalValue,[$add,$thenAnd,$finallyAdd]);
        $this->assertNotSame( ($originalValue + $add), $addedValue, "Value not just adding the first argument");
        $this->assertSame( ( $originalValue + $add + $thenAnd + $finallyAdd), $addedValue, "Original value should add each argument supplied");
    } //EOF it_can_add_original_value_multiple_times
}