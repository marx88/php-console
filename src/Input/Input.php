<?php

declare(strict_types=1);

namespace Marx\Console\Input;

use Marx\Console\Exception\ArgumentNotDefinedException;
use Marx\Console\Exception\OptionNotDefinedException;
use Marx\Console\Exception\ReadStdinException;

/**
 * 输入类.
 */
class Input implements InputInterface
{
    /** @var string[] */
    private array $argumentArr = [];

    /** @var string[] */
    private array $optionArr = [];

    /**
     * 构造函数.
     *
     * @param string[] $argumentArr
     * @param string[] $optionArr
     */
    public function __construct(array $argumentArr, array $optionArr)
    {
        $this->argumentArr = $argumentArr;
        $this->optionArr = $optionArr;
    }

    /**
     * {@inheritDoc}
     */
    public function getArgument(string $name): ?string
    {
        if (!array_key_exists($name, $this->argumentArr)) {
            throw ArgumentNotDefinedException::make($name);
        }

        return $this->argumentArr[$name];
    }

    /**
     * {@inheritDoc}
     */
    public function getOption(string $longName): ?string
    {
        if (!array_key_exists($longName, $this->optionArr)) {
            throw OptionNotDefinedException::make($longName);
        }

        return $this->optionArr[$longName];
    }

    /**
     * {@inheritDoc}
     */
    public function readAnswer(): string
    {
        if (function_exists('sapi_windows_cp_set')) {
            $input = $this->readWindowsInput();
        } else {
            $input = $this->readNotWindowsInput();
        }

        if (false === $input) {
            throw ReadStdinException::make();
        }

        return trim($input);
    }

    /**
     * 非windows系统读取命令行输入.
     */
    private function readNotWindowsInput()
    {
        return fgets(STDIN);
    }

    /**
     * windows系统读取命令行输入.
     * 解决某些编码无法读取到的问题 比如汉字.
     */
    private function readWindowsInput()
    {
        $cp = sapi_windows_cp_get('');
        sapi_windows_cp_set(sapi_windows_cp_get('oem'));

        $input = fgets(STDIN);

        sapi_windows_cp_set($cp);
        if (false === $input || '' === $input) {
            return $input;
        }

        return sapi_windows_cp_conv(sapi_windows_cp_get('oem'), $cp, $input);
    }
}
