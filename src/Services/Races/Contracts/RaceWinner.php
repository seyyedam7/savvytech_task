<?php

namespace SavvytechTask\Services\Races\Contracts;

use SavvytechTask\Services\Races\DTO\PlayerDTO;

interface RaceWinner
{
    public static function setPlayers(array $players): self;

    public function getWinner(): PlayerDTO;
}