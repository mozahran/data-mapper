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

namespace Zahran\Mapper\Contract;

use Zahran\Mapper\Contract\CastType as CastTypeInterface;
use Zahran\Mapper\Contract\Condition as ConditionInterface;
use Zahran\Mapper\Contract\Mutator as MutatorInterface;
use Zahran\Mapper\Model\CastType;
use Zahran\Mapper\Model\Condition;
use Zahran\Mapper\Model\Mutator;

interface ContainerInterface extends \Psr\Container\ContainerInterface
{
    public function getCastType(CastType $model): CastTypeInterface;

    public function getConditionType(Condition $model): ConditionInterface;

    public function getMutator(Mutator $model): MutatorInterface;
}
