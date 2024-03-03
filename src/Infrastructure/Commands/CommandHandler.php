<?php

namespace SavvytechTask\Infrastructure\Commands;

use SavvytechTask\Infrastructure\Commands\Contracts\Command;

use function cli\choose;
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

    public function line(): void
    {
        line();
    }

    /**
     * @param string $options like 'yn'
     * @param string $question
     * @param string $default
     * @return string
     */
    public function choose(string $options, string $question, string $default = 'y'): string
    {
        return choose($question, $options, $default);
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
