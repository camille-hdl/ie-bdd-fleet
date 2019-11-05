<?php

namespace MyFleet\App\Fleet;
use MyFleet\Domain\Fleet;
use MyFleet\Domain\Vehicle;

/**
 * Suppose une collection d'objets
 *
 * @param array $collection
 * @param mixed $element
 * @return boolean
 */
function includes(array $collection, $element): bool {
    foreach ($collection as $item) {
        if ($item === $element) return true;
    }
    return false;
}

/**
 * @param array $collection
 * @param callable $predicate
 * @return array
 */
function filter(array $collection, callable $predicate): array {
    $output = [];
    foreach ($collection as $k => $v) {
        if ($predicate($v, $k)) {
            $output[] = $v;
        }
    }
    return $output;
}

/**
 * Commandes pour modifier une Fleet
 */
final class FleetCommands
{
    /**
     * Enregistrer un Vehicle dans une fleet
     *
     * @param Fleet $fleet
     * @param Vehicle $vehicle
     * @return Fleet
     */
    public static function registerVehicle(Fleet $fleet, Vehicle $vehicle): Fleet
    {
        $fleetVehicles = $fleet->getVehicles();
        if (includes($fleetVehicles, $vehicle)) {
            throw \MyFleet\Domain\Exception\AlreadyRegisteredException::fromFleetAndVehicle($fleet, $vehicle);
        }
        $fleetVehicles[] = $vehicle;
        $fleet->setVehicles($fleetVehicles);
        return $fleet;
    }

    /**
     * Enlever un Vehicle d'une Fleet, s'il y était enregistré
     *
     * @param Fleet $fleet
     * @param Vehicle $vehicle
     * @return Fleet
     */
    public static function unregisterVehicle(Fleet $fleet, Vehicle $vehicle): Fleet
    {
        $fleetVehicles = $fleet->getVehicles();
        if (includes($fleetVehicles, $vehicle)) {
            $fleetVehicles = filter($fleetVehicles, function(Vehicle $element) use($vehicle) {
                return $vehicle !== $vehicle;
            });
            $fleet->setVehicles($fleetVehicles);
        }
        return $fleet;
    }
}