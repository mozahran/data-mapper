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

class NotEquals implements ConditionInterface
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
        if ($originalValue !== $this->model->getValue()) {
            return $this->model->getThen();
        }
        if ($originalValue === $this->model->getValue() &&
            $this->model->getOtherwise()) {
            return $this->model->getOtherwise();
        }
        return $originalValue;
    }
}
