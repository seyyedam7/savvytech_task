<?php

namespace SavvytechTask\Services\Races;

use SavvytechTask\Services\Races\Contracts\RaceWinner;
use SavvytechTask\Services\Races\DTO\PlayerDTO;

class RaceWinnerManager implements RaceWinner
{
    private array $players = [];

    public static function setPlayers(array $players): self
    {
        $instance = new self();
        $instance->players = $players;
        return $instance;
    }

    public function getWinner(): PlayerDTO
    {
        $winner = $this->players[0];
        foreach ($this->players as $player) {
            if ($player->getTime() < $winner->getTime()) {
                $winner = $player;
            }
        }
        return $winner;
    }
}