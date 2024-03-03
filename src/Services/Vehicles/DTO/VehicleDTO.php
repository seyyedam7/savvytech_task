<?php

namespace SavvytechTask\Services\Vehicles\DTO;

use SavvytechTask\Services\Units\Enums\SpeedUnit;

class VehicleDTO
{
    public function __construct(
        private string $name,
        private int $maxSpeed,
        private string $unit
    ){
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMaxSpeed(): int
    {
        return $this->maxSpeed;
    }

    public function getUnit(): SpeedUnit
    {
        return SpeedUnit::from($this->unit);
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['maxSpeed'],
            $data['unit']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'maxSpeed' => $this->maxSpeed,
            'unit' => $this->unit
        ];
    }
}