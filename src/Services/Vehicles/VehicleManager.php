<?php

namespace SavvytechTask\Services\Vehicles;

use Exception;
use SavvytechTask\Services\Vehicles\Contracts\Vehicle;
use SavvytechTask\Services\Vehicles\DTO\VehicleDTO;
use SavvytechTask\Services\Vehicles\DTO\VehiclesDTO;

class VehicleManager implements Vehicle
{
    protected string $vehiclesFileName = 'vehicles.json';
    private VehiclesDTO $vehicles;

    //TODO: pass vehicles file in other class
    public function __construct()
    {
        $jsonString = file_get_contents(resources_path($this->vehiclesFileName));
        $this->setVehicles($jsonString);
    }

    public function setVehicles(bool|string $jsonString): void
    {
        if ($jsonString === false) {
            $this->vehicles = new VehiclesDTO();
        } else {
            $this->vehicles = VehiclesDTO::fromArray(json_decode($jsonString, true));
        }
    }

    public function getVehicleNames(): array
    {
        $vehicleNames = [];

        foreach ($this->vehicles->toArray() as $vehicle) {
            $vehicleNames[] = $vehicle['name'];
        }

        return $vehicleNames;
    }

    /**
     * @throws Exception
     */
    public function getVehicleByName(string $vehicleName): VehicleDTO
    {
        return $this->vehicles->findVehicleByName($vehicleName);
    }
}