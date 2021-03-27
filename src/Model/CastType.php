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

class CastType
{
    const ATTRIBUTE_TYPE = 'type';
    const ATTRIBUTE_FORMAT = 'format';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $format = null;

    public function __construct(array $data = [])
    {
        $this->fill($data);
    }

    public function fill(array $data): self
    {
        $this->name = $data[self::ATTRIBUTE_TYPE];
        $this->format = $data[self::ATTRIBUTE_FORMAT] ?? null;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->name;
    }

    public function setType(string $type): self
    {
        $this->name = $type;
        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;
        return $this;
    }
}
