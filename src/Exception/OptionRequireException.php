<?php

declare(strict_types=1);

namespace Marx\Console\Exception;

use Exception;

/**
 * 缺少Option异常.
 */
class OptionRequireException extends Exception
{
    public static function make(string $optionName): OptionRequireException
    {
        return new static('option "'.$optionName.'" is required');
    }
}
