<?php

declare(strict_types=1);

namespace Marx\Console\Command;

/**
 * Abstract命令行类.
 */
abstract class AbstractCommand implements CommandInterface
{
    use CommandTrait;
}
