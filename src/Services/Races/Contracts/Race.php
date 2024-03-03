<?php

namespace SavvytechTask\Services\Races\Contracts;

use SavvytechTask\Services\Races\DTO\PlayerDTO;

interface Race
{
    public static function setDistance(int $distance): self;

    public function addPlayer(PlayerDTO $playerDTO): self;

    public function getPlayers(): array;

    public function calculateTimes(): self;
}