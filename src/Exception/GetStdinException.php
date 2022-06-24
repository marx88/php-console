<?php

declare(strict_types=1);

namespace Marx\Console\Exception;

use Exception;

/**
 * 读取STDIN异常.
 */
class ReadStdinException extends Exception
{
    public static function make(): ReadStdinException
    {
        return new static('read STDIN error');
    }
}
