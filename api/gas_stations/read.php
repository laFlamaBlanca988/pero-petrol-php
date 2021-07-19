<?php
header('Acces-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../model/GasStations.php';

// Instantiate & connect DB
$database = new Database();
$db = $database->connect();

// Instantiate users object
$stationsData = new GasStations($db);

// Users query
$result = $stationsData->read_gas_station();

// Get row count
$num = $result->rowCount();

// Check if any users
if ($num > 0) {
    $stations_arr = array();
    $stations_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $station = array(
            'stationID' => $stationID,
            'gasStation' => $gasStation,
            'petrol95' => $petrol95,
            'petrol98' => $petrol98,
            'diesel' => $diesel,
            'gas' => $gas,
        );
        // Push to 'data
        array_push($stations_arr['data'], $station);
    }
    // Turn to JSON & output
    echo json_encode($stations_arr);
} else {
    echo json_encode(array('message' => 'No stations found!'));
}
