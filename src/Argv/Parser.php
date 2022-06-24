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
    protected function addOption(ArgvItem $argvItem)
    {
        $this->optionArr[$argvItem->getKey()] = $argvItem->getValue();
    }

    /**
     * 解析参数及可选项.
     */
    protected function parseArgOpt(array &$argv)
    {
        $len = count($argv);
        $argvItem = new ArgvItem();
        for ($index = $this->hasCommandName() ? 2 : 1; $index < $len; ++$index) {
            $opt = $argv[$index];

            // 匹配长名称
            $this->matchLongOption($opt, $argvItem);
            if ($argvItem->isMatched()) {
                $this->addOption($argvItem);

                continue;
            }

            // 匹配短名称
            $this->matchShortOption($opt, $argvItem);
            if ($argvItem->isMatched()) {
                $this->addOption($argvItem);

                continue;
            }

            // 前一个匹配到key 但未设置value
            if ($argvItem->isFill()) {
                $argvItem->setValue($opt);
                $this->addOption($argvItem);
                $argvItem->reset();

                continue;
            }

            $this->addArgument($opt);
        }
    }

    private function matchLongOption(string $opt, ArgvItem $argvItem): void
    {
        $argvItem->setMatched(false);
        $longOptionRegexp = '/^--(?<key>[^=]+)(=(?<val>.*))?$/';
        if (preg_match($longOptionRegexp, $opt, $matches)) {
            $argvItem->setMatched(true);
            $argvItem->setKey('--'.$matches['key']);
            $argvItem->setValue($matches['val'] ?? '');
        }
    }

    private function matchShortOption(string $opt, ArgvItem $argvItem): void
    {
        $argvItem->setMatched(false);
        $shortOptionRegexp = '/^-(?<key>[^=])(=(?<val>.*))?$/';
        if (preg_match($shortOptionRegexp, $opt, $matches)) {
            $argvItem->setMatched(true);
            $argvItem->setKey('-'.$matches['key']);
            $argvItem->setValue($matches['val'] ?? '');
        }
    }
}
