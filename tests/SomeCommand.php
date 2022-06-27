<?php

declare(strict_types=1);

namespace Marx\Console\Test;

use Marx\Console\Color;
use Marx\Console\Command\AbstractCommand;

/**
 * SomeCommand.
 */
class SomeCommand extends AbstractCommand
{
    public function __construct()
    {
        $this->setName('some');
        $this->setDesc('some command');
        $this->addArgument('one', true, 'one argument');
        $this->addArgument('two', false, 'two argument');
        $this->addOption('three', 't', true, 'option three');
        $this->addOption('four', '', false, 'accept array');
    }

    public function execute(): void
    {
        // 测试脚本:php tests/cmd some the_one -t=the_three --four the_four the_two
        $this->output->write(Color::cyan('your argument one:').$this->input->getArgument('one'));
        $this->output->write(Color::blue('your argument two:').$this->input->getArgument('two'));
        $this->output->write(Color::purple('your option three:').$this->input->getOption('three'));
        $this->output->writeLn(Color::grey('your option four:'), $this->input->getOptionAsArray('four'));

        $this->output->askQuestion(Color::yellow('input five argv'));
        $this->output->writeLn(Color::green('your five argv is:'), $this->input->readAnswerAsArray());
    }
}
