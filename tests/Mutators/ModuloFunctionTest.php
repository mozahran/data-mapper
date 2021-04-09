<?php


namespace Mutators;


use PHPUnit\Framework\TestCase;
use Zahran\Mapper\Model\Mutator;
use Zahran\Mapper\Mutator\Modulo;

class ModuloFunctionTest extends TestCase
{
    const MUTATOR_NAME = "modulo";
    protected $mutatorType;

    function setUp(): void
    {
        parent::setUp();
        $this->mutatorType = new Modulo;
        $this->mutatorType->setModel(new Mutator([
            Mutator::ATTRIBUTE_NAME => self::MUTATOR_NAME,
            Mutator::ATTRIBUTE_ARGUMENTS => [],
        ]));
    }

    /** @test */
    function it_returns_the_modulo_of_both_numbers()
    {
        $firstNumber = 5.7;
        $secondNumber = 1.3;

        $modulo = $this->mutatorType->apply($firstNumber,[$secondNumber]);
        $this->assertSame(fmod($firstNumber,$secondNumber), $modulo,"It returns the remainder of the original value divided by the second" );
        $this->assertNotSame( $firstNumber, $modulo,"The original value should have changed" );
    } //EOF it_returns_the_modulo_of_both_numbers

    /** @test */
    function it_returns_the_modulo_if_numeric_strings()
    {
        $firstNumber = "5.7";
        $secondNumber = "1.3";

        $modulo = $this->mutatorType->apply($firstNumber,[$secondNumber]);
        $this->assertSame(fmod(floatval($firstNumber),floatval($secondNumber)), $modulo,"It converts string arguments to floating point numbers" );
    } //EOF it_returns_the_modulo_if_numeric_strings

}