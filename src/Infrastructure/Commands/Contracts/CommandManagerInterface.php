<?php

namespace SavvytechTask\Infrastructure\Commands\Contracts;

interface CommandManagerInterface
{
    public function makeCommand(string $command): mixed;
}