<?php

declare(strict_types=1);

namespace Marx\Console\Exception;

use Exception;

/**
 * shortName无效异常.
 */
class ShortNameInvalidException extends Exception
{
    public static function make(string $shortName): ShortNameInvalidException
    {
        return new static('short name "'.$shortName.'" is invalid');
    }
}
