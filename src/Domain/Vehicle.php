<?php

namespace MyFleet\Domain;

/**
 * Un Vehicle peut être garé sur les locations
 */
class Vehicle
{
    protected $locations = [];

    public function __construct()
    {

    }

    public function getLocations(): array
    {
        return $this->locations;
    }

    public function setLocations(array $locations)
    {
        $this->locations = $locations;
    }
}