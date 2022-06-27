<?php

declare(strict_types=1);

namespace Marx\Console;

use Marx\Console\Argv\Parser;
use Marx\Console\Command\CommandInterface;
use Marx\Console\Exception\CommandNotFoundException;
use Marx\Console\Input\Input;
use Marx\Console\Output\Output;

/**
 * 命令行类.
 */
class Console
{
    /** @var CommandInterface[] */
    private array $commandArr = [];

    private Output $output;

    private Parser $parser;

    /**
     * 构造函数.
     */
    public function __construct()
    {
        // 添加内置命令
    }

    /**
     * 添加命令行.
     *
     * @return static
     */
    public function addCommand(CommandInterface $command)
    {
        $this->commandArr[$command->getName()] = $command;

        return $this;
    }

    /**
     * 执行命令.
     */
    public function run()
    {
        $this->output = new Output();

        try {
            $this->exec();
        } catch (\Throwable $th) {
            $this->output->write(Color::red('Error: '.$th->getMessage()));
            $this->output->write(Color::grey($th->getTraceAsString()));
        }
    }

    private function exec()
    {
        // 入参解析器
        $this->parser = new Parser();

        // 没有具体命令
        if (!$this->parser->hasCommandName()) {
            return $this->listCommands();
        }

        // 获取命令
        $command = $this->getCommand();

        // 如果需要help 输出描述及参数列表描述
        if ($this->parser->needHelp()) {
            return $this->showCommandHelp($command);
        }

        // 设置命令参数 及 输入输出对象
        $input = $this->getInput($command);
        $command->initInputOutput($input, $this->output);

        // 执行命令
        $command->execute();
    }

    private function listCommands()
    {
        // 确定补位
        $maxLen = 0;
        foreach ($this->commandArr as $command) {
            $curLen = mb_strlen($command->getName()) + 1;
            if ($maxLen < $curLen) {
                $maxLen = $curLen;
            }
        }

        $this->output->write(Color::yellow('Command list:'));
        foreach ($this->commandArr as $command) {
            $name = str_pad($command->getName(), $maxLen);
            $this->output->write(Color::green('  '.$name).$command->getDesc());
        }
    }

    private function getCommand(): CommandInterface
    {
        $commandName = $this->parser->getCommandName();
        if (!isset($this->commandArr[$commandName])) {
            throw CommandNotFoundException::make($commandName);
        }

        return $this->commandArr[$commandName];
    }

    private function showCommandHelp(CommandInterface $command)
    {
        $outputContent = [];
        $outputContent[] = 'Command "'.Color::yellow($command->getName());
        if ($command->getDesc()) {
            $outputContent[] = $command->getDesc();
        }
        $this->output->write(implode(',', $outputContent));
        $this->output->write('');

        $maxLen = 0;
        foreach ($command->getArgumentArr() as $argument) {
            $curLen = mb_strlen($argument->getName()) + 1;
            if ($maxLen < $curLen) {
                $maxLen = $curLen;
            }
        }

        if ($maxLen > 0) {
            $this->output->write(Color::yellow('Arguments:'));
            foreach ($command->getArgumentArr() as $argument) {
                $name = str_pad($argument->getName(), $maxLen);
                $outputContent = [];
                if ($argument->isRequire()) {
                    $outputContent[] = 'require';
                }
                if ($argument->getDesc()) {
                    $outputContent[] = $argument->getDesc();
                }
                $this->output->write(Color::green('  '.$name).implode(',', $outputContent));
            }
            $this->output->write('');
        }

        $maxLen = 0;
        foreach ($command->getOptionArr() as $option) {
            $curLen = 6 + mb_strlen($option->getLongName()) + 1;
            if ($maxLen < $curLen) {
                $maxLen = $curLen;
            }
        }

        if ($maxLen > 0) {
            $this->output->write(Color::yellow('Options:'));
            foreach ($command->getOptionArr() as $option) {
                $shortName = $option->getShortName();
                if ('' === $shortName) {
                    $shortName = '   ';
                } else {
                    $shortName = '-'.$shortName.',';
                }
                $name = str_pad($shortName.' --'.$option->getLongName(), $maxLen);
                $outputContent = [];
                if ($option->isRequire()) {
                    $outputContent[] = 'require';
                }
                if ($option->getDesc()) {
                    $outputContent[] = $option->getDesc();
                }
                $this->output->write(Color::green('  '.$name).implode(',', $outputContent));
            }
            $this->output->write('');
        }
    }

    private function getInput(CommandInterface $command): Input
    {
        $argumentArr = [];
        foreach ($command->getArgumentArr() as $argument) {
            $argumentArr[$argument->getName()] = $argument->getValue($this->parser);
        }

        $optionArr = [];
        foreach ($command->getOptionArr() as $option) {
            $optionArr[$option->getLongName()] = $option->getValue($this->parser);
        }

        return new Input($argumentArr, $optionArr);
    }
}
