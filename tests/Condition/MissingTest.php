<?php

namespace Condition;

use Zahran\Mapper\Condition\Contains;
use PHPUnit\Framework\TestCase;
use Zahran\Mapper\Condition\Missing;
use Zahran\Mapper\Model\Condition;

class MissingTest extends TestCase
{
    const CONDITION_TYPE = 'missing';
    const CONDITION_THEN = 'Missing!';
    const CONDITION_OTHERWISE = 'Found!';

    public function testMissingOccurrenceInText()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => 'foo',
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = 'lorem ipsum';
        $this->assertSame(self::CONDITION_THEN, $contains->apply($originalValue));
    }

    public function testMissingOccurrenceInArray()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => 0,
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = [1, 'bar', 'baz'];
        $this->assertSame(self::CONDITION_THEN, $contains->apply($originalValue));
    }

    public function testMissingOccurrencesInArray()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => ['A', 'B'],
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = ['foo', 'bar', 'baz'];
        $this->assertSame(self::CONDITION_THEN, $contains->apply($originalValue));
    }

    public function testFoundOccurrenceFromArray()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => 'foo',
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = ['foo', 'bar', 'baz'];
        $this->assertSame(self::CONDITION_OTHERWISE, $contains->apply($originalValue));
    }

    public function testFoundOccurrencesFromArray()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => ['foo', 'baz'],
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = ['foo', 'bar', 'baz'];
        $this->assertSame(self::CONDITION_OTHERWISE, $contains->apply($originalValue));
    }

    public function testFoundOccurrenceFromText()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => 'z',
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = 'xyz';
        $this->assertSame(self::CONDITION_OTHERWISE, $contains->apply($originalValue));
    }

    public function testFoundOccurrencesFromText()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => ['x', 'y'],
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = 'xyz';
        $this->assertSame(self::CONDITION_OTHERWISE, $contains->apply($originalValue));
    }

    public function testGetOriginalValueIfOtherwiseNotSet()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => ['x', 'y'],
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = 'xyz';
        $this->assertSame($originalValue, $contains->apply($originalValue));

    }

    protected function createConditionType(): Missing
    {
        return new Missing();
    }
}
