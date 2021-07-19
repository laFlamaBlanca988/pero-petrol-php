<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../model/GasStations.php';

// Instantiate & connect DB
$database = new Database();
$db = $database->connect();

// Instantiate users object
$stationsData = new GasStations($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$stationsData->stationID = $data->stationID;
$stationsData->gasStation = $data->gasStation;
$stationsData->petrol95 = $data->petrol95;
$stationsData->petrol98 = $data->petrol98;
$stationsData->diesel = $data->diesel;
$stationsData->gas = $data->gas;

// Create post
if ($stationsData->update_station()) {
    echo json_encode(
        array('Message' => 'Post Updated')
    );
} else {
    echo json_encode(
        array('Message' => 'Post Not Updated')
    );
}