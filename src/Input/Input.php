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
     * 以数组形式获取Argument.
     */
    public function getArgumentAsArray(string $name, string $separator = ','): ?array
    {
        $argument = $this->getArgument($name);

        return $this->stringToArray($argument, $separator);
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
     * 以数组形式获取Option.
     */
    public function getOptionAsArray(string $name, string $separator = ','): ?array
    {
        $option = $this->getOption($name);

        return $this->stringToArray($option, $separator);
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
     * 以数组形式获取Answer.
     */
    public function readAnswerAsArray(string $separator = ','): ?array
    {
        $answer = $this->readAnswer();

        return $this->stringToArray($answer, $separator);
    }

    /**
     * 字符串转数组.
     */
    private function &stringToArray(?string &$str, string $separator): ?array
    {
        if (is_null($str)) {
            return null;
        }

        $arr = [];
        if ('' === trim($str)) {
            return [];
        }

        foreach (explode($separator, $str) as $item) {
            $arr[] = trim($item);
        }

        return $arr;
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
