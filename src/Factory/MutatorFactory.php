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

use Zahran\Mapper\Contract\MutatorFactory as MutatorFactoryInterface;
use Zahran\Mapper\Model\Attribute;
use Zahran\Mapper\Model\Mutator;

class MutatorFactory implements MutatorFactoryInterface
{
    public function createModel(array $attributeData): array
    {
        if (!isset($attributeData[Attribute::ATTRIBUTE_MUTATORS])) {
            return [];
        }
        $mutators = [];
        foreach ($attributeData[Attribute::ATTRIBUTE_MUTATORS] as $mutatorData) {
            $mutators[] = new Mutator($mutatorData);
        }
        return $mutators;
    }
}
