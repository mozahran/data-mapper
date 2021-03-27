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

namespace Zahran\Mapper;

use Cake\Utility\Hash;
use Zahran\Mapper\Contract\AttributeFactory as AttributeFactoryInterface;
use Zahran\Mapper\Contract\DataModifier as DataModifierInterface;
use Zahran\Mapper\Contract\Mapper as MapperInterface;
use Zahran\Mapper\Helper\Util;
use Zahran\Mapper\Model\Attribute;

class DataMapper implements MapperInterface
{
    /**
     * @var AttributeFactoryInterface
     */
    protected $attributeFactory;

    /**
     * @var DataModifierInterface
     */
    protected $dataModifier;

    protected $data = [];

    /**
     * @var Util
     */
    protected $helper;

    public function __construct(
        AttributeFactoryInterface $attributeFactory,
        DataModifierInterface $dataModifier
    ) {
        $this->attributeFactory = $attributeFactory;
        $this->dataModifier = $dataModifier;
        $this->helper = Container::getInstance()->get('helper.util');
    }

    public function map(string $data, string $mappings): array
    {
        $items = [];
        $mappings = json_decode($mappings, true) ?? [];
        $this->data = json_decode($data, true) ?? [];
        $attributes = $mappings[Attribute::ATTRIBUTE_ATTRIBUTES] ?? [];
        $this->attributeFactory->setData($this->data);
        foreach ($attributes as $index => $attribute) {
            array_push($items, ...$this->attributeFactory->create($attribute));
        }
        return $this->_map($items);
    }

    public function _map(array $attributes): array
    {
        $items = [];
        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {
            if (!$attribute->isArray()) {
                $this->getAttributeValueFromData($attribute);
                $this->dataModifier->modify($attribute);
                $items[$attribute->getName()] = $attribute->getValue();
            } else {
                $items[$attribute->getName()][] = $this->_mapChildren($attribute);
            }
        }
        return $items;
    }

    protected function _mapChildren(Attribute $attribute): array
    {
        $items = [];
        /** @var Attribute $child */
        foreach ($attribute->getAttributes() as $child) {
            if (!$child->isArray()) {
                $this->getAttributeValueFromData($child);
                $this->dataModifier->modify($child);
                $items[$child->getName()] = $child->getValue();
            } else {
                $items[$child->getName()][] = $this->_mapChildren($child);
            }
        }
        return $items;
    }

    protected function getAttributeValueFromData(Attribute $attribute): Attribute
    {
        // Attributes that have hardcoded values
        if (!$attribute->getPath()) {
            $value = [];
            if (is_array($attribute->getDefault())) {
                foreach ($attribute->getDefault() as $item) {
                    $value[] = $this->helper->castHardCodedValues($item);
                }
            }
            return $attribute->setValue($value);
        }
        // Attributes that have scoped indices
        if (strpos($attribute->getPath(true), '|') !== false) {
            return $attribute->setValue(
                $this->getScopedIndicesFromSourceArray($attribute)
            );
        }
        $value = Hash::get($this->data, $attribute->getPath(true), $attribute->getDefault());
        return $attribute->setValue($value);
    }

    /**
     * @param Attribute $attribute
     * @return array
     */
    protected function getScopedIndicesFromSourceArray(Attribute $attribute): array
    {
        $value = [];
        list($path, $scopedIndices) = explode('|', $attribute->getPath(true));
        $data = Hash::get($this->data, $path, $attribute->getDefault());
        $scopedIndices = explode(',', $scopedIndices);
        foreach ($scopedIndices as $targetIndex) {
            if (strpos($targetIndex, '$', 0) !== false) {
                $value[] = $this->helper->castHardCodedValues($targetIndex);
            } else {
                $value[] = $data[$targetIndex];
            }
        }
        return $value;
    }
}
