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

class Mutator
{
    const ATTRIBUTE_NAME = 'name';
    const ATTRIBUTE_ARGUMENTS = 'arguments';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array|null
     */
    protected $arguments = [];

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    public function fill(array $data): self
    {
        $this->name = $data[self::ATTRIBUTE_NAME];
        $this->arguments = $data[self::ATTRIBUTE_ARGUMENTS] ?? [];
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

    public function getArguments(): array
    {
        return $this->arguments;
    }

    public function setArguments($arguments): self
    {
        $this->arguments = $arguments;
        return $this;
    }
}
