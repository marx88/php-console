<?php

declare(strict_types=1);

namespace Marx\Console\Command;

use Marx\Console\Input\Input;
use Marx\Console\Output\Output;

interface CommandInterface
{
    /**
     * 执行命令.
     */
    public function execute(Input $input, Output $output): void;

    /**
     * 获取名称.
     */
    public function getName(): string;

    /**
     * 获取描述.
     */
    public function getDesc(): string;

    /**
     * 获取ArgumentArr.
     *
     * @return Argument[]
     */
    public function getArgumentArr(): array;

    /**
     * 获取OptionArr.
     *
     * @return Option[]
     */
    public function getOptionArr(): array;
}
