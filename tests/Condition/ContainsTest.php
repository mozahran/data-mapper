<?php

namespace Condition;

use Zahran\Mapper\Condition\Contains;
use PHPUnit\Framework\TestCase;
use Zahran\Mapper\Model\Condition;

class ContainsTest extends TestCase
{
    const CONDITION_TYPE = 'contains';
    const CONDITION_THEN = 'Found!';
    const CONDITION_OTHERWISE = 'Missing!';

    public function testFindOccurrenceInText()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => 'lorem',
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = 'lorem ipsum';
        $this->assertSame(self::CONDITION_THEN, $contains->apply($originalValue));
    }

    public function testFindOccurrenceInArray()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => 1,
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = [1, 'bar', 'baz'];
        $this->assertSame(self::CONDITION_THEN, $contains->apply($originalValue));
    }

    public function testFindOccurrencesInArray()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => ['foo', 'bar'],
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = ['foo', 'bar', 'baz'];
        $this->assertSame(self::CONDITION_THEN, $contains->apply($originalValue));
    }

    public function testMissingOccurrenceFromArray()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => 'abc',
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = ['foo', 'bar', 'baz'];
        $this->assertSame(self::CONDITION_OTHERWISE, $contains->apply($originalValue));
    }

    public function testMissingOccurrencesFromArray()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => ['abc', 'def'],
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = ['foo', 'bar', 'baz'];
        $this->assertSame(self::CONDITION_OTHERWISE, $contains->apply($originalValue));
    }

    public function testMissingOccurrenceFromText()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => 'abc',
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
            Condition::ATTRIBUTE_OTHERWISE => self::CONDITION_OTHERWISE,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = 'xyz';
        $this->assertSame(self::CONDITION_OTHERWISE, $contains->apply($originalValue));
    }

    public function testMissingOccurrencesFromText()
    {
        $model = new Condition([
            Condition::ATTRIBUTE_CONDITION_TYPE => self::CONDITION_TYPE,
            Condition::ATTRIBUTE_VALUE => ['abc', 'def'],
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
            Condition::ATTRIBUTE_VALUE => ['abc', 'def'],
            Condition::ATTRIBUTE_THEN => self::CONDITION_THEN,
        ]);
        $contains = $this->createConditionType();
        $contains->setModel($model);
        $originalValue = 'xyz';
        $this->assertSame($originalValue, $contains->apply($originalValue));

    }

    protected function createConditionType(): Contains
    {
        return new Contains();
    }
}
