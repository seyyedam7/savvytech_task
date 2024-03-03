<?php

namespace SavvytechTask\Infrastructure\Commands\Contracts;

interface Command
{
    public function handle(): void;

    public function notify(string $message): void;

    public function menu(array $options, string $message = 'Choose an item', $default = false): string;

    public function prompt(string $question, $default = false): string;
}
