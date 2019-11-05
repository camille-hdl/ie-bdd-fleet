<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use MyFleet\App\Fleet\FleetCommands;
use MyFleet\App\Fleet\FleetQueries;
use MyFleet\App\Vehicle\VehicleCommands;
use MyFleet\App\Vehicle\VehicleQueries;
use MyFleet\Domain\Exception\AlreadyParkedException;
use MyFleet\Domain\Exception\AlreadyRegisteredException;
use MyFleet\Domain\Fleet;
use MyFleet\Domain\Vehicle;

/**
 * Test suite pour les features
 * * register_vehicle
 * * park_vehicle
 */
class FeatureContext implements Context
{

    private $fleet;
    private $vehicle;
    private $location;

    private $fleetService;
    private $fleetQueries;
    private $vehicleCommands;
    private $vehicleQueries;

    private $alreadyRegisteredException;
    private $alreadyParkedException;

    private $otherFleet;
    private $otherVehicle;

    public function __construct()
    {
        $this->fleetCommands = new FleetCommands();
        $this->fleetQueries = new FleetQueries();
        $this->vehicleCommands = new VehicleCommands();
        $this->vehicleQueries = new VehicleQueries();
    }
    /**
     * @Given my fleet
     */
    public function myFleet()
    {
        $this->fleet = new Fleet();
    }

    /**
     * @Given a vehicle
     */
    public function aVehicle()
    {
        $this->vehicle = new Vehicle();
    }

    /**
     * @Given I have registered this vehicle into my fleet
     */
    public function iHaveRegisteredThisVehicleIntoMyFleet()
    {
        $this->fleetCommands->registerVehicle($this->fleet, $this->vehicle);
    }

    /**
     * @Given a location
     */
    public function aLocation()
    {
        $this->location = [0.00, 0.00];
    }

    /**
     * @When I park my vehicle at this location
     */
    public function iParkMyVehicleAtThisLocation()
    {
        $this->vehicleCommands->parkVehicleAt($this->vehicle, $this->location);
    }

    /**
     * @Then the known location of my vehicle should verify this location
     */
    public function theKnownLocationOfMyVehicleShouldVerifyThisLocation()
    {
        \PHPUnit\Framework\Assert::assertSame(
            $this->vehicleQueries->getVehicleLocation($this->vehicle),
            $this->location
        );
    }

    /**
     * @Given my vehicle has been parked into this location
     */
    public function myVehicleHasBeenParkedIntoThisLocation()
    {
        $this->vehicleCommands->parkVehicleAt($this->vehicle, $this->location);
        \PHPUnit\Framework\Assert::assertTrue($this->vehicleQueries->vehicleHasBeenParkedAt($this->vehicle, $this->location));
    }

    /**
     * @When I try to park my vehicle at this location
     */
    public function iTryToParkMyVehicleAtThisLocation()
    {
        try {
            $this->vehicleCommands->parkVehicleAt($this->vehicle, $this->location);
        } catch(AlreadyParkedException $e) {
            $this->alreadyParkedException = $e;
        }
    }

    /**
     * @Then I should be informed that my vehicle is already parked at this location
     */
    public function iShouldBeInformedThatMyVehicleIsAlreadyParkedAtThisLocation()
    {
        \PHPUnit\Framework\Assert::assertInstanceOf(AlreadyParkedException::class, $this->alreadyParkedException);
    }

    /**
     * @When I register this vehicle into my fleet
     */
    public function iRegisterThisVehicleIntoMyFleet()
    {
        $this->fleetCommands->unregisterVehicle($this->fleet, $this->vehicle);
        $this->fleetCommands->registerVehicle($this->fleet, $this->vehicle);
    }

    /**
     * @Then this vehicle should be part of my vehicle fleet
     */
    public function thisVehicleShouldBePartOfMyVehicleFleet()
    {
        \PHPUnit\Framework\Assert::assertTrue($this->fleetQueries->fleetIncludes($this->fleet, $this->vehicle));
    }

    /**
     * @When I try to register this vehicle into my fleet
     */
    public function iTryToRegisterThisVehicleIntoMyFleet()
    {
        try {
            $this->fleetCommands->registerVehicle($this->fleet, $this->vehicle);
        } catch(AlreadyRegisteredException $e) {
            $this->alreadyRegisteredException = $e;
        }
    }

    /**
     * @Then I should be informed this this vehicle has already been registered into my fleet
     */
    public function iShouldBeInformedThisThisVehicleHasAlreadyBeenRegisteredIntoMyFleet()
    {
        \PHPUnit\Framework\Assert::assertInstanceOf(AlreadyRegisteredException::class, $this->alreadyRegisteredException);
    }
    /**
     * @Given the fleet of another user
     */
    public function theFleetOfAnotherUser()
    {
        $this->otherFleet = new Fleet();
    }

    /**
     * @Given this vehicle has been registered into the other user's fleet
     */
    public function thisVehicleHasBeenRegisteredIntoTheOtherUsersFleet()
    {
        $this->otherVehicle = new Vehicle();
        $this->fleetCommands->registerVehicle($this->otherFleet, $this->otherVehicle);
        \PHPUnit\Framework\Assert::assertTrue($this->fleetQueries->fleetIncludes($this->otherFleet, $this->otherVehicle));
    }

    /**
     * @When I register this other vehicle into my fleet
     */
    public function iRegisterThisOtherVehicleIntoMyFleet()
    {
        $this->fleetCommands->registerVehicle($this->fleet, $this->otherVehicle);
    }

    /**
     * @Then this other vehicle should be part of my vehicle fleet
     */
    public function thisOtherVehicleShouldBePartOfMyVehicleFleet()
    {
        \PHPUnit\Framework\Assert::assertTrue($this->fleetQueries->fleetIncludes($this->fleet, $this->otherVehicle));
    }
}
