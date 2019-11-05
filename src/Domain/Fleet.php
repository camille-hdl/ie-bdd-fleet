<?php

namespace MyFleet\Domain;

/**
 * Une collection de Vehicles
 */
class Fleet
{
    protected $vehicles = [];

    public function __construct()
    {

    }

    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    public function setVehicles(array $vehicles)
    {
        $this->vehicles = $vehicles;
    }
}