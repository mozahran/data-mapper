<?php
/**
 * Data Mapper (https://github.com/mozahran/data-mapper)
 * Copyright 2021, Mohamed Zahran. (https://www.linkedin.com/in/mo-zahran/)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Mohamed Zahran (https://www.linkedin.com/in/mo-zahran/)
 * @link          https://github.com/mozahran/data-mapper
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

namespace Zahran\Mapper\Model;

class Condition
{
    const ATTRIBUTE_CONDITION_TYPE = 'condition_type';
    const ATTRIBUTE_VALUE = 'value';
    const ATTRIBUTE_THEN = 'then';
    const ATTRIBUTE_OTHERWISE = 'otherwise';

    /**
     * @var string
     */
    protected $conditionType;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $then;

    /**
     * @var string|null
     */
    protected $otherwise = null;

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    public function fill(array $data): self
    {
        $this->setConditionType($data[self::ATTRIBUTE_CONDITION_TYPE]);
        $this->setValue($data[self::ATTRIBUTE_VALUE]);
        $this->setThen($data[self::ATTRIBUTE_THEN]);
        $this->setOtherwise($data[self::ATTRIBUTE_OTHERWISE] ?? null);
        return $this;
    }

    public function getConditionType(): string
    {
        return $this->conditionType;
    }

    public function setConditionType(string $condition): self
    {
        $this->conditionType = $condition;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getThen(): string
    {
        return $this->then;
    }

    public function setThen(string $then): self
    {
        $this->then = $then;
        return $this;
    }

    public function getOtherwise(): ?string
    {
        return $this->otherwise;
    }

    public function setOtherwise(?string $otherwise): self
    {
        $this->otherwise = $otherwise;
        return $this;
    }
}
