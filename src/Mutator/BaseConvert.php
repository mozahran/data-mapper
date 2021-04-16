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

namespace Zahran\Mapper\Mutator;

use Zahran\Mapper\Contract\Mutator as MutatorInterface;
use Zahran\Mapper\Model\Mutator;

class BaseConvert implements MutatorInterface
{
    /**
     * @var Mutator
     */
    protected $model;

    protected $defaultToBase = 10;

    public function setModel(Mutator $model): MutatorInterface
    {
        $this->model = $model;
        return $this;
    }

    public function apply($originalValue, array $arguments = [])
    {
        $fromBase = (int) $arguments[0];
        $toBase = ( isset($arguments[1]) && (int) $arguments[1] > 0 ) ? (int) $arguments[1]:$this->defaultToBase;
        return base_convert($originalValue,$fromBase,$toBase);
    }
}
