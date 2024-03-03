<?php

namespace SavvytechTask\Services\Vehicles\Contracts;

use SavvytechTask\Services\Vehicles\DTO\VehicleDTO;

interface Vehicle
{
    public function setVehicles(bool|string $jsonString): void;

    public function getVehicleNames(): array;

    public function getVehicleByName(string $vehicleName): VehicleDTO;
}