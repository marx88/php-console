<?php

declare(strict_types=1);

namespace Marx\Console\Output;

interface OutputInterface
{
    /**
     * 输出内容到控制台.
     *
     * @param null|array|bool|float|int|object|string $message
     */
    public function write($message, bool $appendLn = true): void;
}
