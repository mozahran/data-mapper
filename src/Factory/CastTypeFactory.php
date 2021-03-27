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

use Zahran\Mapper\Contract\CastTypeFactory as CastFactoryInterface;
use Zahran\Mapper\Model\Attribute;
use Zahran\Mapper\Model\CastType as Model;

class CastTypeFactory implements CastFactoryInterface
{
    public function createModel(array $attributeData): ?Model
    {
        if (!isset($attributeData[Attribute::ATTRIBUTE_CAST])) {
            return null;
        }
        return new Model($attributeData[Attribute::ATTRIBUTE_CAST]);
    }
}
