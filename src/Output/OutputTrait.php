<?php

declare(strict_types=1);

namespace Marx\Console\Output;

trait OutputTrait
{
    /**
     * {@inheritDoc}
     */
    abstract public function write($message, bool $appendLn = true): void;

    /**
     * 换行输出.
     */
    public function writeLn(...$msgArr): void
    {
        foreach ($msgArr as $msg) {
            $this->write($msg);
        }
    }

    /**
     * 提出问题.
     */
    public function askQuestion(string ...$msgArr): void
    {
        $this->writeLn(...$msgArr);
        $this->write(': ', false);
    }
}
