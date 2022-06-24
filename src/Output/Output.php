<?php

declare(strict_types=1);

namespace Marx\Console\Output;

/**
 * 输出类.
 */
class Output implements OutputInterface
{
    use OutputTrait;

    /**
     * {@inheritDoc}
     */
    public function write($message, bool $appendLn = true): void
    {
        if (!is_scalar($message)) {
            $message = var_export($message, true);
        } elseif (!is_string($message)) {
            $message = (string) $message;
        }

        if ($appendLn) {
            $message .= PHP_EOL;
        }

        fwrite(STDOUT, $message);
    }
}
