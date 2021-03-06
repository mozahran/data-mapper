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

namespace Zahran\Mapper\Condition;

use Zahran\Mapper\Contract\Condition as ConditionInterface;
use Zahran\Mapper\Model\Condition;

class Contains implements ConditionInterface
{
    /**
     * @var Condition
     */
    protected $model;

    public function setModel(Condition $model): ConditionInterface
    {
        $this->model = $model;
        return $this;
    }

    public function apply($originalValue)
    {
        $result = false;
        $conditionValue = $this->model->getValue();
        if (is_array($originalValue)) {
            if (is_array($conditionValue)) {
                // Find elements in the original array
                $matches = 0;
                foreach ($originalValue as $originalValueItem) {
                    foreach ($conditionValue as $conditionValueItem) {
                        if (stripos((string)$originalValueItem, $conditionValueItem) !== false) {
                            $matches++;
                        }
                    }
                }
                $result = $matches === count($conditionValue);
            } else {
                // Find an item in the original array
                foreach ($originalValue as $originalValueItem) {
                    if (stripos((string)$originalValueItem, (string)$conditionValue) !== false) {
                        $result = true;
                        break;
                    }
                }
            }
        }
        if (!is_array($originalValue)) {
            if (is_array($conditionValue)) {
                // Find occurrences in a text
                $matches = 0;
                foreach ($conditionValue as $conditionValueItem) {
                    if (stripos((string)$originalValue, (string)$conditionValueItem) !== false) {
                        $matches++;
                    }
                }
                $result = $matches === count($conditionValue);
            } else {
                // Find an occurrence in a text
                if (stripos((string)$originalValue, (string)$conditionValue) !== false) {
                    $result = true;
                }
            }
        }
        if ($result) {
            return $this->model->getThen();
        }
        if (!$result && $this->model->getOtherwise()) {
            return $this->model->getOtherwise();
        }
        return $originalValue;
    }
}
