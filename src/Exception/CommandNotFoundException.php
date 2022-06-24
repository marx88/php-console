<?php

declare(strict_types=1);

namespace Marx\Console\Exception;

use Exception;

/**
 * 命令未找到异常.
 */
class CommandNotFoundException extends Exception
{
    public static function make(string $commandName): CommandNotFoundException
    {
        return new static('command "'.$commandName.'" not found');
    }
}
