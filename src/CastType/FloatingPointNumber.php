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

namespace Zahran\Mapper\CastType;

use Zahran\Mapper\Contract\CastType as CastTypeInterface;
use Zahran\Mapper\Model\CastType;

/**
 * @since 1.1.0
 */
class FloatingPointNumber implements CastTypeInterface
{
    /**
     * @var CastType
     */
    protected $model;

    public function setModel(CastType $model): CastTypeInterface
    {
        $this->model = $model;
        return $this;
    }

    public function cast($originalValue): float
    {
        return (float)$originalValue;
    }
}
