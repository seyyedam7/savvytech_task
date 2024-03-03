<?php

namespace SavvytechTask\Services\Races\DTO;

use SavvytechTask\Services\Vehicles\DTO\VehicleDTO;

class PlayerDTO
{
    public function __construct(
        private string $name,
        private VehicleDTO $vehicleDTO,
        private ?int $time = null
    ){
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return VehicleDTO
     */
    public function getVehicleDTO(): VehicleDTO
    {
        return $this->vehicleDTO;
    }

    /**
     * @return ?int
     */
    public function getTime(): ?int
    {
        return $this->time;
    }

    /**
     * @param int|null $time
     */
    public function setTime(?int $time): void
    {
        $this->time = $time;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            VehicleDTO::fromArray($data['vehicleDTO']),
            $data['time']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'vehicleDTO' => $this->vehicleDTO->toArray(),
            'time' => $this->time
        ];
    }
}