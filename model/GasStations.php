<?php
class GasStations
{
    private $conn;
    public $stationID;
    public $gasStation;
    public $petrol95;
    public $petrol98;
    public $diesel;
    public $gas;

    public function __construct($db)
    {
        $this->conn = $db;
    }
    public function read_gas_station()
    {
        $query = "SELECT
        gas_stations.gasStation, gas_stations.stationID, gas_stations.petrol95, gas_stations.petrol98, gas_stations.diesel, gas_stations.gas
        FROM gas_stations
        ORDER BY stationID
         ";
        $statement = $this->conn->prepare($query);
        $statement->execute();

        return $statement;
    }

    public function read_single_station()
    {
        $query = "SELECT
        gas_stations.gasStation, gas_stations.stationID, gas_stations.petrol95, gas_stations.petrol98, gas_stations.diesel, gas_stations.gas
        FROM gas_stations
        WHERE gas_stations.stationID = ?
        LIMIT 0,1";

        $statement = $this->conn->prepare($query);
        $statement->bindParam(1, $this->stationID);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->stationID = $row['stationID'];
        $this->gasStation = $row['gasStation'];
        $this->petrol95 = $row['petrol95'];
        $this->petrol98 = $row['petrol98'];
        $this->diesel = $row['diesel'];
        $this->gas = $row['gas'];
    }

    public function create_station()
    {
        $query = "INSERT INTO gas_stations SET gasStation = :gasStation, petrol95 = :petrol95, petrol98 = :petrol98, diesel = :diesel, gas = :gas";

        $statement = $this->conn->prepare($query);

        $this->gasStation = htmlspecialchars(strip_tags($this->gasStation));
        $this->petrol95 = htmlspecialchars(strip_tags($this->petrol95));
        $this->petrol98 = htmlspecialchars(strip_tags($this->petrol98));
        $this->diesel = htmlspecialchars(strip_tags($this->diesel));
        $this->gas = htmlspecialchars(strip_tags($this->gas));

        $statement->bindParam(':gasStation', $this->gasStation);
        $statement->bindParam(':petrol95', $this->petrol95);
        $statement->bindParam(':petrol98', $this->petrol98);
        $statement->bindParam(':diesel', $this->diesel);
        $statement->bindParam(':gas', $this->gas);

        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s. /n", $statement->error);
        return false;
    }

    public function update_station()
    {
        $query = "UPDATE gas_stations SET stationID = :stationID, gasStation = :gasStation, petrol95 = :petrol95, petrol98 = :petrol98, diesel = :diesel, gas = :gas WHERE stationID = :stationID";

        $statement = $this->conn->prepare($query);

        $this->stationID = htmlspecialchars(strip_tags($this->stationID));
        $this->gasStation = htmlspecialchars(strip_tags($this->gasStation));
        $this->petrol95 = htmlspecialchars(strip_tags($this->petrol95));
        $this->petrol98 = htmlspecialchars(strip_tags($this->petrol98));
        $this->diesel = htmlspecialchars(strip_tags($this->diesel));
        $this->gas = htmlspecialchars(strip_tags($this->gas));

        $statement->bindParam(':stationID', $this->stationID);
        $statement->bindParam(':gasStation', $this->gasStation);
        $statement->bindParam(':petrol95', $this->petrol95);
        $statement->bindParam(':petrol98', $this->petrol98);
        $statement->bindParam(':diesel', $this->diesel);
        $statement->bindParam(':gas', $this->gas);

        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s. /n", $statement->error);
        return false;
    }

    public function delete_station()
    {
        $query = "DELETE FROM gas_stations WHERE stationID = :stationID";

        $statement = $this->conn->prepare($query);

        $this->stationID = htmlspecialchars(strip_tags($this->stationID));

        $statement->bindParam(':stationID', $this->stationID);

        if ($statement->execute()) {
            return true;
        }
        printf("Error: %s. /n", $statement->error);
        return false;
    }
}
