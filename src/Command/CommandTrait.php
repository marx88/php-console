<?php

declare(strict_types=1);

namespace Marx\Console\Command;

use Marx\Console\Input\Input;
use Marx\Console\Output\Output;

trait CommandTrait
{
    /** @var Argument[] */
    private array $argumentArr = [];

    /** @var Option[] */
    private array $optionArr = [];

    private string $name = '';

    private string $desc = '';

    /**
     * {@inheritDoc}
     */
    abstract public function execute(Input $input, Output $output): void;

    /**
     * 获取名称.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 获取描述.
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * 获取ArgumentArr.
     *
     * @return Argument[]
     */
    public function getArgumentArr(): array
    {
        return $this->argumentArr;
    }

    /**
     * 获取OptionArr.
     *
     * @return Option[]
     */
    public function getOptionArr(): array
    {
        return $this->optionArr;
    }

    /**
     * 设置名称.
     */
    protected function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * 设置描述.
     */
    protected function setDesc(string $desc): void
    {
        $this->desc = $desc;
    }

    /**
     * 添加Argument.
     */
    protected function addArgument(string $name, bool $isRequire = false, string $desc = '', ?string $defaultValue = null): void
    {
        $this->argumentArr[] = new Argument($name, count($this->argumentArr), $isRequire, $desc, $defaultValue);
    }

    /**
     * 添加Option.
     */
    protected function addOption(string $longName, string $shortName = '', bool $isRequire = false, string $desc = '', ?string $defaultValue = null): void
    {
        $this->optionArr[$longName] = new Option($longName, $shortName, $isRequire, $desc, $defaultValue);
    }
}
