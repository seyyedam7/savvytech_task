<?php

namespace SavvytechTask\Infrastructure\Commands;

use SavvytechTask\Infrastructure\Commands\Contracts\Command;

use function cli\line;
use function cli\menu;
use function cli\out;
use function cli\prompt;

abstract class CommandHandler implements Command
{
    public function __construct()
    {
    }

    public function notify(string $message): void
    {
        line($message);
    }

    public function menu(array $options, string $message = 'Choose an item', $default = false): string
    {
        return menu($options, $default, $message);
    }

    public function prompt(string $question, $default = false): string
    {
        return prompt($question, $default);
    }

    abstract public function handle(): void;
}
