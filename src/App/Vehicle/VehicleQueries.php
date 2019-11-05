<?php

namespace MyFleet\App\Vehicle;
use MyFleet\Domain\Vehicle;

function last(array $collection) {
    if (count($collection) <=0) return null;
    $actualCollection = array_values($collection);
    return $actualCollection[\array_key_last($actualCollection)];
}

/**
 * Queries pour lire des informations sur un Vehicle
 */
final class VehicleQueries
{
    /**
     * Retourne la dernière location du Vehicle,
     * s'il en a une, null sinon
     *
     * @param Vehicle $vehicle
     * @return array|null
     */
    public static function getVehicleLocation(Vehicle $vehicle): ?array
    {
        return last($vehicle->getLocations());
    }

    /**
     * Retourne true si un Vehicle a déjà été garé à une location donnée
     *
     * @param Vehicle $vehicle
     * @param array $location
     * @return boolean
     */
    public static function vehicleHasBeenParkedAt(Vehicle $vehicle, array $location): bool
    {
        return includes($vehicle->getLocations(), $location);
    }
}