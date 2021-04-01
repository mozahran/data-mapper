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

/**
 * @since 1.1.0
 */
class IsBoolean implements ConditionInterface
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
        if (is_bool($originalValue)) {
            return $this->model->getThen();
        }
        if (!is_bool($originalValue) &&
            $this->model->getOtherwise()) {
            return $this->model->getOtherwise();
        }
        return $originalValue;
    }
}
