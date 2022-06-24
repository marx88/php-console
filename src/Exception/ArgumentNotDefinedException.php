<?php

declare(strict_types=1);

namespace Marx\Console\Exception;

use Exception;

/**
 * Argument未定义异常.
 */
class ArgumentNotDefinedException extends Exception
{
    public static function make(string $argumentName): ArgumentNotDefinedException
    {
        return new static('argument "'.$argumentName.'" is not defined');
    }
}
