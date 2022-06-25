<?php

declare(strict_types=1);

namespace Marx\Console\Argv;

/**
 * argv参数解析类.
 */
class Parser
{
    /**
     * 命令名.
     */
    private string $commandName = '';

    /**
     * 参数.
     */
    private array $argumentArr = [];

    /**
     * 可选项.
     */
    private array $optionArr = [];

    /**
     * 构造函数.
     */
    public function __construct()
    {
        global $argv;
        $this->setCommandName($argv);
        $this->parseArgOpt($argv);
    }

    /**
     * 是否有命令名.
     */
    public function hasCommandName(): bool
    {
        return '' !== $this->commandName;
    }

    /**
     * 是否需要help.
     */
    public function needHelp(): bool
    {
        return isset($this->optionArr['--help']) || isset($this->optionArr['-h']);
    }

    /**
     * 获取命令名.
     */
    public function getCommandName(): string
    {
        return $this->commandName;
    }

    /**
     * 根据Index获取Argument.
     */
    public function getArgument(int $index): ?string
    {
        return $this->argumentArr[$index] ?? null;
    }

    /**
     * 获取Option.
     */
    public function getOption(string $longName, string $shortName): ?string
    {
        return $this->optionArr['--'.$longName] ?? ($this->optionArr['-'.$shortName] ?? null);
    }

    /**
     * 设置命令名.
     *
     * @return static
     */
    protected function setCommandName(array &$argv)
    {
        $first = $argv[1] ?? '';
        if (false !== strpos($first, '-')) {
            $first = '';
        }
        $this->commandName = $first;
    }

    /**
     * 添加argument.
     */
    protected function addArgument(string $argument)
    {
        $this->argumentArr[] = $argument;
    }

    /**
     * 添加option.
     */
    protected function addOption(string &$key, ?string $val)
    {
        $this->optionArr[$key] = $val ?? '';
        if (!is_null($val)) {
            $key = null;
        }
    }

    /**
     * 解析参数及可选项.
     */
    protected function parseArgOpt(array &$argv)
    {
        $len = count($argv);
        $key = null;
        for ($index = $this->hasCommandName() ? 2 : 1; $index < $len; ++$index) {
            $opt = $argv[$index];

            // 匹配长名称
            if ($this->addLongOption($opt, $key)) {
                continue;
            }

            // 匹配短名称
            if ($this->addShortOption($opt, $key)) {
                continue;
            }

            // 前一个匹配到key 但未设置value
            if (!is_null($key)) {
                $this->addOption($key, $opt);

                continue;
            }

            $this->addArgument($opt);
        }
    }

    private function addLongOption(string $opt, ?string &$key): bool
    {
        $longOptionRegexp = '/^--(?<key>[^=]+)(=(?<val>.*))?$/';
        if (!preg_match($longOptionRegexp, $opt, $matches)) {
            return false;
        }

        $key = '--'.$matches['key'];
        $this->addOption($key, $matches['val'] ?? null);

        return true;
    }

    private function addShortOption(string $opt, ?string &$key): bool
    {
        $shortOptionRegexp = '/^-(?<key>[^=])(=(?<val>.*))?$/';
        if (!preg_match($shortOptionRegexp, $opt, $matches)) {
            return false;
        }

        $key = '-'.$matches['key'];
        $this->addOption($key, $matches['val'] ?? null);

        return true;
    }
}
