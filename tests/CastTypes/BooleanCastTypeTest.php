<?php


namespace CastTypes;


use PHPUnit\Framework\TestCase;
use Zahran\Mapper\CastType\Boolean;
use Zahran\Mapper\Model\CastType;

class BooleanCastTypeTest extends TestCase
{
    protected $castType;
    function setUp(): void
    {
        parent::setUp();
        $this->castType = new Boolean;
        $this->castType->setModel(new CastType([
            CastType::ATTRIBUTE_TYPE => "boolean"
        ]));
    }

    /** @test */
    function it_can_cast_numerals_as_a_boolean()
    {
        $originalNumeral = 1;
        $castTo = $this->castType->cast($originalNumeral);
        $this->assertSame(boolval($originalNumeral),$castTo,"Converts numerals to booleans");
        $this->assertNotSame($originalNumeral,$castTo,"Original value casting should have changed");
        $this->assertTrue( $castTo ,"Original value should now equate to true");
    } //EOF it_can_cast_numerals_as_a_boolean

    /** @test */
    function it_can_cast_strings_as_a_boolean()
    {
        $originalNumeral = "1";
        $castTo = $this->castType->cast($originalNumeral);
        $this->assertSame(boolval($originalNumeral),$castTo,"Converts strings to booleans");
        $this->assertNotSame($originalNumeral,$castTo,"Original value casting should have changed");
        $this->assertTrue( $castTo ,"Original value should now equate to true");
    } //EOF it_can_cast_strings_as_a_boolean

    /** @test */
    function it_keeps_booleans_as_booleans()
    {
        $originalNumeral = true;
        $castTo = $this->castType->cast($originalNumeral);
        $this->assertSame($originalNumeral,$castTo,"Original value casting should match the output");
        $this->assertTrue( $castTo ,"Original value should still equate to true");
    } //EOF it_keeps_booleans_as_booleans

}