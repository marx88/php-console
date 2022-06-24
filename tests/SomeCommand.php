<?php

declare(strict_types=1);

namespace Marx\Console\Test;

use Marx\Console\Color;
use Marx\Console\Command\AbstractCommand;
use Marx\Console\Input\Input;
use Marx\Console\Output\Output;

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
        $this->addOption('four', '');
    }

    public function execute(Input $input, Output $output): void
    {
        $output->write(Color::cyan('your argument one:').$input->getArgument('one'));
        $output->write(Color::blue('your argument two:').$input->getArgument('two'));
        $output->write(Color::purple('your option three:').$input->getOption('three'));
        $output->write(Color::grey('your option four:').$input->getOption('four'));
    }
}
