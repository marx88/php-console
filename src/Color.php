<?php

declare(strict_types=1);

namespace Marx\Console;

/**
 * 文字颜色类.
 */
class Color
{
    /**
     * 灰色.
     */
    public static function grey(string $text): string
    {
        return static::fmt(__FUNCTION__, $text);
    }

    /**
     * 红色.
     */
    public static function red(string $text): string
    {
        return static::fmt(__FUNCTION__, $text);
    }

    /**
     * 绿色.
     */
    public static function green(string $text): string
    {
        return static::fmt(__FUNCTION__, $text);
    }

    /**
     * 黄色.
     */
    public static function yellow(string $text): string
    {
        return static::fmt(__FUNCTION__, $text);
    }

    /**
     * 蓝色.
     */
    public static function blue(string $text): string
    {
        return static::fmt(__FUNCTION__, $text);
    }

    /**
     * 紫色.
     */
    public static function purple(string $text): string
    {
        return static::fmt(__FUNCTION__, $text);
    }

    /**
     * 青色.
     */
    public static function cyan(string $text): string
    {
        return static::fmt(__FUNCTION__, $text);
    }

    /**
     * 白色.
     */
    public static function white(string $text): string
    {
        return static::fmt(__FUNCTION__, $text);
    }

    private static function fmt(string $color, string $text): string
    {
        $map = [
            'grey' => '0;30m',
            'red' => '0;31m',
            'green' => '0;32m',
            'yellow' => '0;33m',
            'blue' => '0;34m',
            'purple' => '0;35m',
            'cyan' => '0;36m',
            'white' => '0;37m',
        ];

        return "\033[".$map[$color].$text."\033[0m";
    }
}
