<?php

namespace SavvytechTask\Services\Vehicle\DTO;

use Exception;

class VehiclesDTO
{
    private array $vehicles;

    public function __construct(array $vehicles = [])
    {
        $this->vehicles = $vehicles;
    }

    public function addVehicle(VehicleDTO $vehicle): self
    {
        $this->vehicles[] = $vehicle;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function findVehicleByName(string $name): VehicleDTO
    {
        foreach ($this->vehicles as $vehicle) {
            if ($vehicle->getName() === $name) {
                return $vehicle;
            }
        }
        throw new Exception('Vehicle not found');
    }

    public static function fromArray(mixed $json_decode): VehiclesDTO
    {
        $vehicles = [];
        foreach ($json_decode as $vehicle) {
            $vehicles[] = VehicleDTO::fromArray($vehicle);
        }
        return new self($vehicles);
    }

    public function toArray(): array
    {
        return array_map(function ($vehicle) {
            return $vehicle->toArray();
        }, $this->vehicles);
    }
}