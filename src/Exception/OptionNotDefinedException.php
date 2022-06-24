<?php

declare(strict_types=1);

namespace Marx\Console\Exception;

use Exception;

/**
 * Option未定义异常.
 */
class OptionNotDefinedException extends Exception
{
    public static function make(string $optionName): OptionNotDefinedException
    {
        return new static('option "'.$optionName.'" is not defined');
    }
}
