<?php

declare(strict_types=1);

namespace Marx\Console;

/**
 * 文字颜色类.
 */
class Color
{
    /**
     * 灰色 0=不高亮 1=高亮.
     */
    public static function grey(string $text, int $light = 1): string
    {
        return static::fmt(__FUNCTION__, $text, $light);
    }

    /**
     * 红色 0=不高亮 1=高亮.
     */
    public static function red(string $text, int $light = 0): string
    {
        return static::fmt(__FUNCTION__, $text, $light);
    }

    /**
     * 绿色 0=不高亮 1=高亮.
     */
    public static function green(string $text, int $light = 0): string
    {
        return static::fmt(__FUNCTION__, $text, $light);
    }

    /**
     * 黄色 0=不高亮 1=高亮.
     */
    public static function yellow(string $text, int $light = 0): string
    {
        return static::fmt(__FUNCTION__, $text, $light);
    }

    /**
     * 蓝色 0=不高亮 1=高亮.
     */
    public static function blue(string $text, int $light = 0): string
    {
        return static::fmt(__FUNCTION__, $text, $light);
    }

    /**
     * 紫色 0=不高亮 1=高亮.
     */
    public static function purple(string $text, int $light = 0): string
    {
        return static::fmt(__FUNCTION__, $text, $light);
    }

    /**
     * 青色 0=不高亮 1=高亮.
     */
    public static function cyan(string $text, int $light = 0): string
    {
        return static::fmt(__FUNCTION__, $text, $light);
    }

    /**
     * 白色 0=不高亮 1=高亮.
     */
    public static function white(string $text, int $light = 0): string
    {
        return static::fmt(__FUNCTION__, $text, $light);
    }

    private static function fmt(string $color, string $text, int $light): string
    {
        if (!in_array($light, [0, 1], true)) {
            $light = 1;
        }
        $map = [
            'grey' => "{$light};30m",
            'red' => "{$light};31m",
            'green' => "{$light};32m",
            'yellow' => "{$light};33m",
            'blue' => "{$light};34m",
            'purple' => "{$light};35m",
            'cyan' => "{$light};36m",
            'white' => "{$light};37m",
        ];

        return "\033[".$map[$color].$text."\033[0m";
    }
}
