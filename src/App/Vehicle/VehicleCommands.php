<?php

namespace MyFleet\App\Vehicle;
use MyFleet\Domain\Vehicle;

/**
 * Suppose une collection de locations `[lat, lng]`
 *
 * @param array $collection
 * @param array $element
 * @return boolean
 */
function includes(array $collection, $element): bool {
    foreach ($collection as $item) {
        if (implode(", ", $item) === implode(", ", $element)) return true;
    }
    return false;
}

/**
 * Commandes pour modifier un Vehicle
 */
final class VehicleCommands
{
    /**
     * Ajoute $location à la liste des locations du Vehicle,
     * s'il n'y a pas été garé
     *
     * @param Vehicle $vehicle
     * @param array $location
     * @return Vehicle
     */
    public static function parkVehicleAt(Vehicle $vehicle, array $location): Vehicle
    {
        $locations = $vehicle->getLocations();
        if (includes($locations, $location)) {
            throw \MyFleet\Domain\Exception\AlreadyParkedException::fromVehicleAndLocation($vehicle, $location);
        }
        $locations[] = $location;
        $vehicle->setLocations($locations);
        return $vehicle;
    }
}