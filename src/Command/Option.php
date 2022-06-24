<?php

declare(strict_types=1);

namespace Marx\Console\Command;

use Marx\Console\Argv\Parser;
use Marx\Console\Exception\OptionRequireException;
use Marx\Console\Exception\ShortNameInvalidException;

/**
 * Option类.
 */
class Option
{
    private string $longName;
    private string $shortName;
    private bool $isRequire;
    private string $desc;
    private ?string $defaultValue;

    /**
     * 构造函数.
     */
    public function __construct(string $longName, string $shortName = '', bool $isRequire = false, string $desc = '', ?string $defaultValue = null)
    {
        if (mb_strlen($shortName) > 1) {
            throw ShortNameInvalidException::make($shortName);
        }

        $this->longName = $longName;
        $this->shortName = $shortName;
        $this->isRequire = $isRequire;
        $this->desc = $desc;
        $this->defaultValue = $defaultValue;
    }

    /**
     * 获取长名称.
     */
    public function getLongName(): string
    {
        return $this->longName;
    }

    /**
     * 获取短名称.
     */
    public function getShortName(): string
    {
        return $this->shortName;
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
     * 获取值
     */
    public function getValue(Parser $parser): ?string
    {
        $value = $parser->getOption($this->getLongName(), $this->getShortName());
        if (('' === $value || is_null($value)) && !is_null($this->defaultValue)) {
            $value = $this->defaultValue;
        }
        if (('' === $value || is_null($value)) && $this->isRequire()) {
            throw OptionRequireException::make($this->getLongName());
        }

        return $value;
    }
}
