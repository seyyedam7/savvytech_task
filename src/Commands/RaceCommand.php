<?php

namespace SavvytechTask\Commands;

use Exception;
use SavvytechTask\Infrastructure\Commands\CommandHandler;
use SavvytechTask\Services\Vehicle\DTO\VehicleDTO;
use SavvytechTask\Services\Vehicle\VehicleManager;

class RaceCommand extends CommandHandler
{
    protected string $signature = 'race:start';
    private VehicleManager $vehicleManager;

    private array $vehicleNames;

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
    }

    /**
     * @throws Exception
     */
    private function selectPlayer1Vehicle(): void
    {
        $selectedVehicle1 = $this->menu($this->getVehicleNames(), 'Choose a vehicle for player 1');
        $playerVehicle1 = $this->findVehicle($selectedVehicle1);
        $this->notify("Great, You have selected " . $playerVehicle1->getName() . " for player 1");
    }
    /**
     * @throws Exception
     */
    private function selectPlayer2Vehicle(): void
    {
        $selectedVehicle2 = $this->menu($this->getVehicleNames(), 'Choose a vehicle for player 2');
        $playerVehicle2 = $this->findVehicle($selectedVehicle2);
        $this->notify("Well, You have selected " . $playerVehicle2->getName() . " for player 2");
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
