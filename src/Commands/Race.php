<?php

namespace SavvytechTask\Commands;

use SavvytechTask\Infrastructure\Commands\CommandHandler;

class Race extends CommandHandler
{
    protected string $signature = 'race';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->notify("test");
    }
}
