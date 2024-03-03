<?php

namespace SavvytechTask\Services\Commands\Contracts;

interface CommandManagerInterface
{
    public function makeCommand(string $command): mixed;
}