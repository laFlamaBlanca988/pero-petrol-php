<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../model/Users.php';

// Instantiate & connect DB
$database = new Database();
$db = $database->connect();

// Instantiate users object
$usersData = new Users($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$usersData->userID = $data->userID;
$usersData->firstName = $data->firstName;
$usersData->lastName = $data->lastName;
$usersData->experience = $data->experience;
$usersData->salary = $data->salary;
$usersData->vacationDays = $data->vacationDays;
$usersData->gasStation = $data->gasStation;
$usersData->email = $data->email;
$usersData->password = $data->password;

// Create post
if ($usersData->update_user()) {
    echo json_encode(
        array('Message' => 'Post Updated')
    );
} else {
    echo json_encode(
        array('Message' => 'Post Not Updated')
    );
}