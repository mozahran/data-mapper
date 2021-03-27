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

use Zahran\Mapper\Contract\ConditionFactory as ConditionFactoryInterface;
use Zahran\Mapper\Model\Attribute;
use Zahran\Mapper\Model\Condition;

class ConditionFactory implements ConditionFactoryInterface
{
    public function createModel(array $conditionData): array
    {
        if (!isset($conditionData[Attribute::ATTRIBUTE_CONDITIONS])) {
            return [];
        }
        $conditions = [];
        foreach ($conditionData[Attribute::ATTRIBUTE_CONDITIONS] as $condition) {
            $conditions[] = new Condition($condition);
        }
        return $conditions;
    }
}
