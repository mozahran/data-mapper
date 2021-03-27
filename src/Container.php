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

use Cake\Utility\Hash;
use Exception;
use Zahran\Mapper\Contract\CastType as CastTypeInterface;
use Zahran\Mapper\Contract\Condition as ConditionInterface;
use Zahran\Mapper\Contract\ContainerInterface;
use Zahran\Mapper\Contract\Mutator as MutatorInterface;
use Zahran\Mapper\Exception\TypeError;
use Zahran\Mapper\Model\CastType;
use Zahran\Mapper\Model\Condition;
use Zahran\Mapper\Model\Mutator;
use Zahran\Mapper\Mutator\NativeFunction;

class Container implements ContainerInterface
{
    /**
     * @var static
     */
    protected static $instance;

    protected $instances = [];

    public static function getInstance(): self
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * @param string| array $id
     * @param null|object $concrete
     */
    public function add($id, $concrete = null): void
    {
        if (is_array($id)) {
            foreach ($id as $_id => $_concrete) {
                $this->add($_id, $_concrete);
            }
            return;
        }
        list($type, $name) = explode('.', $id);
        $this->instances[$type][$name] = $concrete;
    }

    public function get(string $id, bool $throwNotFoundException = true)
    {
        if (!$this->has($id) && $throwNotFoundException) {
            throw new Exception(sprintf(
                'Instance "%s" does not exist in the container.',
                $id
            ));
        }
        if (!$this->has($id) && !$throwNotFoundException) {
            return null;
        }
        return Hash::get($this->instances, $id);
    }

    public function getCastType(CastType $model): CastTypeInterface
    {
        $castType = $this->get('cast_type.' . $model->getType());
        if (!$castType instanceof CastTypeInterface) {
            $exceptionMessage = sprintf(
                'Invalid type "%s". Cast Types must implement interface "%s".',
                gettype($castType),
                CastTypeInterface::class
            );
            throw new TypeError($exceptionMessage);
        }
        return $castType->setModel($model);
    }

    public function getConditionType(Condition $model): ConditionInterface
    {
        $condition = $this->get('condition.' . $model->getConditionType());
        if (!$condition instanceof ConditionInterface) {
            $exceptionMessage = sprintf(
                'Invalid type "%s". Conditions must implement interface "%s".',
                gettype($condition),
                ConditionInterface::class
            );
            throw new TypeError($exceptionMessage);
        }
        return $condition->setModel($model);
    }

    public function getMutator(Mutator $model): MutatorInterface
    {
        /** @var MutatorInterface $mutator */
        $mutator = $this->get('mutator.' . $model->getName(), false);
        if (!$mutator) {
            return new NativeFunction();
        }
        if (!$mutator instanceof MutatorInterface) {
            $exceptionMessage = sprintf(
                'Invalid type "%s". Mutators must implement interface "%s".',
                gettype($mutator),
                MutatorInterface::class
            );
            throw new TypeError($exceptionMessage);
        }
        return $mutator->setModel($model);
    }

    public function has(string $id): bool
    {
        return Hash::check($this->instances, $id);
    }
}
