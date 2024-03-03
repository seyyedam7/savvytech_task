<?php

namespace SavvytechTask\Commands;

use Exception;
use SavvytechTask\Infrastructure\Commands\CommandHandler;
use SavvytechTask\Services\Races\DTO\PlayerDTO;
use SavvytechTask\Services\Races\RaceManager;
use SavvytechTask\Services\Races\RaceWinnerManager;
use SavvytechTask\Services\Vehicles\DTO\VehicleDTO;
use SavvytechTask\Services\Vehicles\VehicleManager;

class RaceCommand extends CommandHandler
{
    protected string $signature = 'race:start';
    private VehicleManager $vehicleManager;

    private array $vehicleNames;
    private VehicleDTO $playerVehicle1;
    private VehicleDTO $playerVehicle2;
    private int $distance;
    private bool $raceStart;

    public function __construct()
    {
        parent::__construct();
        $this->vehicleManager = new VehicleManager();
        $this->setVehicleNames();
    }

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        $this->selectPlayer1Vehicle();
        $this->selectPlayer2Vehicle();
        $this->promptDistance();
        $this->askToStart();
        if ($this->raceStart) {
            $this->whoIsWinner();
        }
    }

    /**
     * @throws Exception
     */
    private function selectPlayer1Vehicle(): void
    {
        $selectedVehicle1 = $this->menu($this->getVehicleNames(), 'Choose a vehicle for player 1');
        $this->playerVehicle1 = $this->findVehicle($selectedVehicle1);
        $this->line();
        $this->notify("Great, You have selected " . $this->playerVehicle1->getName() . " for player 1");
        $this->line();
    }

    /**
     * @throws Exception
     */
    private function selectPlayer2Vehicle(): void
    {
        $selectedVehicle2 = $this->menu($this->getVehicleNames(), 'Choose a vehicle for player 2');
        $this->playerVehicle2 = $this->findVehicle($selectedVehicle2);
        $this->line();
        $this->notify("Well, You have selected " . $this->playerVehicle2->getName() . " for player 2");
        $this->line();
    }

    private function promptDistance(): void
    {
        $this->distance = $this->prompt('How far should the race be? (Kilometers)', 100);
        $this->line();
        $this->notify('The race will be ' . $this->distance . ' kilometers');
        $this->line();
    }

    private function askToStart(): void
    {
        $start = $this->choose(
            'yn',
            'Would you like to start the race?'
        );
        $this->raceStart = $start === 'y';

        if (!$this->raceStart){
            $this->notify('Ok, maybe next time');
            $this->line();
        }
    }

    /**
     * @throws Exception
     */
    private function whoIsWinner(): void
    {
        $players = RaceManager::setDistance($this->distance)
            ->addPlayer(new PlayerDTO("Player 1", $this->playerVehicle1))
            ->addPlayer(new PlayerDTO("Player 2", $this->playerVehicle2))
            ->calculateTimes()
            ->getPlayers();

        foreach ($players as $player) {
            $humanReadableTime = secondsToReadableTime($player->getTime());
            $this->notify($player->getName() . " covered a distance of " . $this->distance . " km for " . $humanReadableTime);
        }

        $winner = RaceWinnerManager::setPlayers($players)->getWinner();

        $this->notify("The winner is " . $winner->getName() . " with a time of " . secondsToReadableTime($winner->getTime()));
    }

    /**
     * @throws Exception
     */
    private function findVehicle(string $selectedVehicle1): VehicleDTO
    {
        $vehicleName = $this->vehicleNames[$selectedVehicle1];
        return $this->vehicleManager->getVehicleByName($vehicleName);
    }

    private function setVehicleNames(): void
    {
        $this->vehicleNames = $this->vehicleManager->getVehicleNames();
    }

    private function getVehicleNames(): array
    {
        return $this->vehicleNames;
    }
}
