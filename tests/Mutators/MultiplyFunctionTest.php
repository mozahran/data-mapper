<?php


namespace Mutators;


use PHPUnit\Framework\TestCase;
use Zahran\Mapper\Model\Mutator;
use Zahran\Mapper\Mutator\Multiply;

class MultiplyFunctionTest extends TestCase
{
    const MUTATOR_NAME = "multiply";

    protected $mutatorType;

    function setUp(): void
    {
        parent::setUp();
        $this->mutatorType = new Multiply;
        $this->mutatorType->setModel(new Mutator([
            Mutator::ATTRIBUTE_NAME => self::MUTATOR_NAME,
            Mutator::ATTRIBUTE_ARGUMENTS => [],
        ]));

    }

    /** @test */
    function it_multiplies_data_by_first_argument()
    {
        $originalValue = 12;
        $multiplyBy = 5; // could use Faker to make both of these random in the future...

        $multipliedValue = $this->mutatorType->apply($originalValue,[$multiplyBy]);
        $this->assertSame( ( $originalValue * $multiplyBy ), $multipliedValue,"The mutator applies the multiplication" );
        $this->assertNotSame( $originalValue, $multipliedValue,"The original value should be changed" );

    } //EOF it_multiplies_data_by_first_argument

    /** @test */
    function it_does_not_multiply_subsequent_arguments()
    {
        $originalValue = 21;
        $multiplyBy = 7;
        $doNotMultiplyBy = 8;
        $norMultiplyBy = 9;

        $multipliedValue = $this->mutatorType->apply($originalValue,[$multiplyBy,$doNotMultiplyBy,$norMultiplyBy]);
        $this->assertSame(( $originalValue * $multiplyBy ), $multipliedValue,"The mutator multiplies by first argument");
        $this->assertNotSame(( $originalValue * $doNotMultiplyBy ), $multipliedValue,"The mutator ignores the second argument");
        $this->assertNotSame(( $originalValue * $norMultiplyBy ), $multipliedValue,"The mutator ignores the third argument");

    } //EOF it_does_not_multiply_subsequent_arguments

    /** @test */
    function it_multiplies_decimals()
    {
        $originalValue = 12.345;
        $multiplyBy = 5.67; // could use Faker to make both of these random in the future...

        $multipliedValue = $this->mutatorType->apply($originalValue,[$multiplyBy]);
        $this->assertSame( ( $originalValue * $multiplyBy ), $multipliedValue,"The mutator works with decimals and floating point numbers" );
    } //EOF it_multiplies_decimals

    /** @test */
    function it_can_multiply_string_arguments()
    {
        $originalValue = "24";
        $multiplyBy = "5"; // could use Faker to make both of these random in the future...

        $multipliedValue = $this->mutatorType->apply($originalValue,[$multiplyBy]);
        $this->assertSame( ( (int)$originalValue * (int) $multiplyBy ), $multipliedValue,"The mutator casts strings to numbers" );
    } //EOF it_can_multiply_string_arguments
}