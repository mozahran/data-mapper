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

namespace Zahran\Mapper\Helper;

use Zahran\Mapper\Model\Attribute;
use Cake\Utility\Hash;

class Util
{
    public function isArray(array $attributeData): bool
    {
        return isset($attributeData[Attribute::ATTRIBUTE_TYPE]) &&
            $attributeData[Attribute::ATTRIBUTE_TYPE] === Attribute::TYPE_ARRAY;
    }

    public function getSourceArraySize(array $data, array $attributeData): int
    {
        if (is_array($lastElement = end($attributeData[Attribute::ATTRIBUTE_PATH]))) {
            return count($lastElement);
        } else {
            $path = implode('.', $attributeData[Attribute::ATTRIBUTE_PATH]);
            $data = Hash::get($data, $path);
        }
        return is_array($data) ? count($data) : 1;
    }

    public function updatePath(array &$attributeData, Attribute $parent)
    {
        if (!isset($attributeData[Attribute::ATTRIBUTE_PATH])) {
            return;
        }
        // Push the parent's path + index to the child's path array
        array_unshift($attributeData[Attribute::ATTRIBUTE_PATH], $parent->getIndex());
        array_unshift($attributeData[Attribute::ATTRIBUTE_PATH], ...$parent->getPath());
    }

    public function castHardCodedValues(string &$value)
    {
        // add custom values that are hard-coded in the mapping template
        $hardcodedValue = ltrim($value, '$');
        if (filter_var($hardcodedValue, FILTER_SANITIZE_NUMBER_FLOAT) !== '') {
            $hardcodedValue = (float)$hardcodedValue;
        } elseif (filter_var($hardcodedValue, FILTER_SANITIZE_NUMBER_INT) !== '') {
            $hardcodedValue = (int)$hardcodedValue;
        }
        if ($hardcodedValue === 'null') {
            $hardcodedValue = null;
        }
        if ($hardcodedValue === 'true') {
            $hardcodedValue = true;
        }
        if ($hardcodedValue === 'false') {
            $hardcodedValue = false;
        }
        return $hardcodedValue;
    }
}
