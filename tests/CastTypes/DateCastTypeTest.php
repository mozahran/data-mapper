<?php


namespace CastTypes;


use PHPUnit\Framework\TestCase;
use Zahran\Mapper\CastType\Date;
use Zahran\Mapper\Model\CastType;

class DateCastTypeTest extends TestCase
{
    const ATTRIBUTE_TYPE = "date";
    protected $castType;

    function setUp(): void
    {
        parent::setUp();
        $this->castType = new Date;

    }

    /** @test */
    function it_can_format_date_to_string_supplied()
    {
        $originalValue = "2021-03-21 09:34:15";
        $format = "d/m/Y H:i";

        $this->castType->setModel(new CastType([
            CastType::ATTRIBUTE_TYPE => self::ATTRIBUTE_TYPE,
            CastType::ATTRIBUTE_FORMAT => $format,
        ]));

        $reformattedDate = $this->castType->cast($originalValue);

        $this->assertSame( ( new \DateTime($originalValue))->format($format), $reformattedDate, "Original value should now be in new date format");
        $this->assertNotSame($originalValue,$reformattedDate,"Original value should have changed");

    } //EOF it_can_format_date_to_string_supplied

    /** @test */
    function it_can_format_date_to_constant_supplied()
    {
        $originalValue = "2021-03-21 09:34:15";
        $format = \DateTimeInterface::ISO8601;

        $this->castType->setModel(new CastType([
            CastType::ATTRIBUTE_TYPE => self::ATTRIBUTE_TYPE,
            CastType::ATTRIBUTE_FORMAT => $format,
        ]));

        $reformattedDate = $this->castType->cast($originalValue);

        $this->assertSame( ( new \DateTime($originalValue))->format($format), $reformattedDate, "Original value should now be in new date format");
        $this->assertNotSame($originalValue,$reformattedDate,"Original value should have changed");

    } //EOF it_can_format_date_to_constant_supplied

    /** @test */
    function it_throws_exception_if_format_missing()
    {
        $originalValue = "2021-03-21 09:34:15";

        $this->expectExceptionObject(new \InvalidArgumentException('The format must be provided!'));

        $this->castType->setModel(new CastType([
            CastType::ATTRIBUTE_TYPE => self::ATTRIBUTE_TYPE,
        ]));

        $this->castType->cast($originalValue);

    } //EOF it_throws_exception_if_format_missing
}