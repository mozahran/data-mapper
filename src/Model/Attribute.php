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

namespace Zahran\Mapper\Model;

class Attribute
{
    const ATTRIBUTE_NAME = 'name';
    const ATTRIBUTE_TYPE = 'type';
    const ATTRIBUTE_PATH = 'path';
    const ATTRIBUTE_INDEX = 'index';
    const ATTRIBUTE_VALUE = 'value';
    const ATTRIBUTE_DEFAULT = 'default';
    const ATTRIBUTE_CONDITIONS = 'conditions';
    const ATTRIBUTE_CAST = 'cast';
    const ATTRIBUTE_ATTRIBUTES = 'attributes';
    const ATTRIBUTE_MUTATORS = 'mutators';
    const TYPE_ARRAY = 'array';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $type = null;

    /**
     * @var array
     */
    protected $path = [];

    /**
     * @var int|null
     */
    protected $index = null;

    /**
     * @var mixed
     */
    protected $value = null;

    /**
     * @var null
     */
    protected $default = null;

    /**
     * @var array|null
     */
    protected $conditions = [];

    /**
     * @var CastType|null
     */
    protected $cast;

    /**
     * @var array|null
     */
    protected $attributes = [];

    /**
     * @var array|null
     */
    protected $mutators = [];

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    public function fill(array $data): self
    {
        $this->name = $data[self::ATTRIBUTE_NAME];
        $this->type = $data[self::ATTRIBUTE_TYPE] ?? null;
        $this->path = $data[self::ATTRIBUTE_PATH] ?? [];
        $this->index = $data[self::ATTRIBUTE_INDEX] ?? null;
        $this->value = $data[self::ATTRIBUTE_VALUE] ?? null;
        $this->default = $data[self::ATTRIBUTE_DEFAULT] ?? null;
        $this->conditions = $data[self::ATTRIBUTE_CONDITIONS] ?? [];
        $this->cast = $data[self::ATTRIBUTE_CAST] ?? null;
        $this->attributes = $data[self::ATTRIBUTE_ATTRIBUTES] ?? [];
        $this->mutators = $data[self::ATTRIBUTE_MUTATORS] ?? [];
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function isArray(): bool
    {
        return $this->getType() === self::TYPE_ARRAY;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param bool $stringify
     * @return array|string
     */
    public function getPath(bool $stringify = false)
    {
        if ($stringify) {
            if (is_array($lastElement = end($this->path))) {
                $path = $this->path;
                array_pop($path);
                return implode('.', $path) . '|' . implode(',', $lastElement);
            } else {
                return implode('.', $this->path);
            }
        }
        return $this->path;
    }

    public function setPath(array $path): self
    {
        $this->path = $path;
        return $this;
    }

    public function getIndex(): ?int
    {
        return $this->index;
    }

    public function setIndex(?int $index = null): self
    {
        if ($index !== null && $this->isArray()) {
            $this->index = $index;
        }
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function setDefault($default): self
    {
        $this->default = $default;
        return $this;
    }

    public function getConditions(): array
    {
        return $this->conditions;
    }

    public function setConditions($conditions): self
    {
        $this->conditions = $conditions;
        return $this;
    }

    public function getCast(): ?CastType
    {
        return $this->cast;
    }

    public function setCastType(?CastType $cast): self
    {
        $this->cast = $cast;
        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    public function getMutators(): array
    {
        return $this->mutators;
    }

    public function setMutators(array $mutators): self
    {
        $this->mutators = $mutators;
        return $this;
    }
}
