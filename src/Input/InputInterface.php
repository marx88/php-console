<?php

declare(strict_types=1);

namespace Marx\Console\Input;

interface InputInterface
{
    /**
     * 根据Argument名称获取值.
     */
    public function getArgument(string $name): ?string;

    /**
     * 根据Option长名称获取值.
     */
    public function getOption(string $longName): ?string;

    /**
     * 读取命令行输入的答案.
     */
    public function readAnswer(): string;
}
