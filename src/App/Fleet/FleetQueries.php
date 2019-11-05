<?php

namespace MyFleet\App\Fleet;
use MyFleet\Domain\Fleet;
use MyFleet\Domain\Vehicle;

/**
 * Queries pour lire des informations sur une Fleet
 */
final class FleetQueries
{
    /**
     * @param Fleet $fleet
     * @param Vehicle $vehicle
     * @return boolean
     */
    public static function fleetIncludes(Fleet $fleet, Vehicle $vehicle): bool
    {
        return includes($fleet->getVehicles(), $vehicle);
    }
}