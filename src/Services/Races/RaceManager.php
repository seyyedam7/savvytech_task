<?php

namespace SavvytechTask\Services\Races;

use Exception;
use SavvytechTask\Services\Races\Contracts\Race;
use SavvytechTask\Services\Races\DTO\PlayerDTO;
use SavvytechTask\Services\Units\Enums\ConversionSpeedUnit;
use SavvytechTask\Services\Units\Enums\SpeedUnit;

class RaceManager implements Race
{
    private array $players = [];
    private string $distance;

    public static function setDistance(int $distance): self
    {
        $instance = new self();
        $instance->distance = $distance;
        return $instance;
    }

    public function addPlayer(PlayerDTO $playerDTO): self
    {
        $this->players[] = $playerDTO;

        return $this;
    }


    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @throws Exception
     */
    public function calculateTimes(): self
    {
        foreach ($this->players as $player) {
            $playerUnit = $player->getVehicleDTO()->getUnit();
            $playerSpeed = $player->getVehicleDTO()->getMaxSpeed();

            match ($playerUnit) {
                SpeedUnit::KILOMETERS => $time = $this->calculateTime($playerSpeed),
                SpeedUnit::KTS => $time = $this->calculateTime($playerSpeed * ConversionSpeedUnit::KTS_TO_KMH->value),
                SpeedUnit::KNOTS => $time = $this->calculateTime($playerSpeed * ConversionSpeedUnit::KNOTS_TO_KMH->value),
                default => throw new Exception('Unit not found'),
            };
            $player->setTime($time);
        }
        return $this;
    }

    /**
     * @throws Exception
     */
    private function calculateTime(int $playerSpeed): int
    {
        //convert km/h to km/s
        return round($this->distance / ($playerSpeed / 3600));
    }
}