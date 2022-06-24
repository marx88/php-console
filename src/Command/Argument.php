<?php

declare(strict_types=1);

namespace Marx\Console\Command;

use Marx\Console\Argv\Parser;
use Marx\Console\Exception\ArgumentRequireException;

/**
 * Argument类.
 */
class Argument
{
    private string $name;
    private int $index;
    private bool $isRequire;
    private string $desc;
    private ?string $defaultValue;

    /**
     * 构造函数.
     */
    public function __construct(string $name, int $index, bool $isRequire = false, string $desc = '', ?string $defaultValue = null)
    {
        $this->name = $name;
        $this->index = $index;
        $this->isRequire = $isRequire;
        $this->desc = $desc;
        $this->defaultValue = $defaultValue;
    }

    /**
     * 获取名称.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 获取索引.
     */
    public function getIndex(): int
    {
        return $this->index;
    }

    /**
     * 是否必填.
     */
    public function isRequire(): bool
    {
        return $this->isRequire;
    }

    /**
     * 获取描述.
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * 读取默认值.
     */
    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    /**
     * 获取值.
     */
    public function getValue(Parser $parser): ?string
    {
        $value = $parser->getArgument($this->getIndex());
        if (('' === $value || is_null($value)) && !is_null($this->defaultValue)) {
            $value = $this->defaultValue;
        }
        if (('' === $value || is_null($value)) && $this->isRequire()) {
            throw ArgumentRequireException::make($this->getName());
        }

        return $value;
    }
}
