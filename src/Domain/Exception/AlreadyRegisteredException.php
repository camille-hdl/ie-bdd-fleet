<?php

namespace MyFleet\Domain\Exception;
use MyFleet\Domain\Fleet;
use MyFleet\Domain\Vehicle;
use function sprintf;

/**
 * Représente une demande d'enregistrer un véhicule dans une fleet alors qu'il y est déjà
 */
class AlreadyRegisteredException extends \Exception
{
    public static function fromFleetAndVehicle(Fleet $fleet, Vehicle $vehicle)
    {
        $fleetHash = \spl_object_hash($fleet);
        $vehicleHash = \spl_object_hash($vehicle);
        return new self(
            sprintf(
                "Vehicle '%s' is already registered to fleet '%s'",
                $vehicleHash,
                $fleetHash
            )
        );
    }
}