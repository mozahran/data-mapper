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

namespace Zahran\Mapper;

use Zahran\Mapper\Contract\CastTypeFactory as CastFactoryInterface;
use Zahran\Mapper\Contract\ConditionFactory as ConditionFactoryInterface;
use Zahran\Mapper\Contract\DataModifier as DataModifierInterface;
use Zahran\Mapper\Contract\MutatorFactory as MutatorFactoryInterface;
use Zahran\Mapper\Model\Attribute;
use Zahran\Mapper\Model\Condition;
use Zahran\Mapper\Model\Mutator;

class DataModifier implements DataModifierInterface
{
    public function modify(Attribute $attribute): void
    {
        $this->applyConditions($attribute);
        $this->applyMutators($attribute);
        $this->cast($attribute);
    }

    protected function applyConditions(Attribute $attribute): void
    {
        if (!$attribute->getConditions()) {
            return;
        }
        $value = $attribute->getValue();
        /** @var Condition $conditionModel */
        foreach ($attribute->getConditions() as $conditionModel) {
            $conditionType = Container::getInstance()->getConditionType($conditionModel);
            if (!is_array($value)) {
                $value = $conditionType->apply($value);
            }
            if (is_array($value)) {
                foreach ($value as &$item) {
                    $item = $conditionType->apply($item);
                }
            }
        }
        $attribute->setValue($value);
    }

    protected function applyMutators(Attribute $attribute): void
    {
        if (!$attribute->getMutators()) {
            return;
        }
        $value = $attribute->getValue();
        /** @var Mutator $mutatorModel */
        foreach ($attribute->getMutators() as $mutatorModel) {
            $mutatorInstance = Container::getInstance()->getMutator($mutatorModel);
            if (!is_array($value)) {
                $value = $mutatorInstance->apply($value, $mutatorModel->getArguments());
            }
            if (is_array($value)) {
                foreach ($value as &$v) {
                    $v = $mutatorInstance->apply($v, $mutatorModel->getArguments());
                }
            }
        }
        $attribute->setValue($value);
    }

    protected function cast(Attribute $attribute): void
    {
        if (!$attribute->getCast() ||
            $attribute->getValue() === $attribute->getDefault()) {
            return;
        }
        $castType = Container::getInstance()->getCastType($attribute->getCast());
        if (!is_array($attribute->getValue())) {
            $attribute->setValue(
                $castType
                    ->setModel($attribute->getCast())
                    ->cast($attribute->getValue())
            );
        }
        if (is_array($attribute->getValue())) {
            $values = [];
            foreach ($attribute->getValue() as $value) {
                $values[] = $castType->setModel($attribute->getCast())->cast($value);
            }
            $attribute->setValue($values);
        }
    }
}
