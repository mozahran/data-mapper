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

namespace Zahran\Mapper\Factory;

use Zahran\Mapper\Container;
use Zahran\Mapper\Contract\AttributeFactory as AttributeFactoryInterface;
use Zahran\Mapper\Contract\CastTypeFactory as CastFactoryInterface;
use Zahran\Mapper\Contract\ConditionFactory as ConditionFactoryInterface;
use Zahran\Mapper\Contract\MutatorFactory as MutatorFactoryInterface;
use Zahran\Mapper\Model\Attribute;

class AttributeFactory implements AttributeFactoryInterface
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @var CastFactoryInterface
     */
    protected $castFactory;

    /**
     * @var ConditionFactoryInterface
     */
    protected $conditionFactory;

    /**
     * @var MutatorFactoryInterface
     */
    protected $mutatorFactory;

    /**
     * @var \Zahran\Mapper\Helper\Util
     */
    protected $util;

    public function __construct() {
        $this->castFactory = Container::getInstance()->get('factory.cast_type');
        $this->conditionFactory = Container::getInstance()->get('factory.condition');
        $this->mutatorFactory = Container::getInstance()->get('factory.mutator');
        $this->util = Container::getInstance()->get('helper.util');
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function create(array $attributeData): array
    {
        $items = [];
        $size = $this->util->getSourceArraySize($this->data, $attributeData);
        for ($i = 0; $i < $size; $i++) {
            $items[] = $this->_create($attributeData, $i);
        }
        return $items;
    }

    protected function _create(array $attributeData, ?int $index = null): Attribute
    {
        $attribute = new Attribute($attributeData);
        $attribute->setIndex($index);
        $attribute->setAttributes($this->_createChildren($attributeData, $attribute));
        $attribute->setConditions($this->conditionFactory->createModel($attributeData));
        $attribute->setCastType($this->castFactory->createModel($attributeData));
        $attribute->setMutators($this->mutatorFactory->createModel($attributeData));
        return $attribute;
    }

    private function _createChildren(array $attributeData, Attribute $parent): array
    {
        if (!$attributes = $attributeData[Attribute::ATTRIBUTE_ATTRIBUTES] ?? null) {
            return [];
        }
        $items = [];
        foreach ($attributes as $attributeData) {
            $this->util->updatePath($attributeData, $parent);
            if ($this->util->isArray($attributeData)) {
                array_push($items, ...$this->create($attributeData));
            } else {
                $items[] = $this->_create($attributeData);
            }
        }
        return $items;
    }
}
