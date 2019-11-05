<?php

namespace MyFleet\Domain\Exception;
use MyFleet\Domain\Vehicle;
use function sprintf;

/**
 * Représente une demande de garer un véhicule à une location
 * sur laquelle il a déjà été garé
 */
class AlreadyParkedException extends \Exception
{
    public static function fromVehicleAndLocation(Vehicle $vehicle, array $location)
    {
        $locationString = implode(", ", $location);
        $vehicleHash = \spl_object_hash($vehicle);
        return new self(
            sprintf(
                "Vehicle '%s' has already been parked at '%s'",
                $vehicleHash,
                $locationString
            )
        );
    }
}