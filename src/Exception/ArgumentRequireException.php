<?php

declare(strict_types=1);

namespace Marx\Console\Exception;

use Exception;

/**
 * 缺少Argument异常.
 */
class ArgumentRequireException extends Exception
{
    public static function make(string $argumentName): ArgumentRequireException
    {
        return new static('argument "'.$argumentName.'" is required');
    }
}
