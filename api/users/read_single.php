<?php
header('Acces-Control-Allow-Origin: *');
header('Content-Type: application/json');
include_once '../../config/Database.php';
include_once '../../model/Users.php';

// Instantiate & connect DB
$database = new Database();
$db = $database->connect();

// Instantiate users object
$usersData = new Users($db);
// Get ID
$usersData->userID = isset($_GET['userID']) ? $_GET['userID'] : die();
// Get user
$usersData->read_user_single();

$user_arr = array(
    'userID' => $usersData->userID,
    'firstName' => $usersData->firstName,
    'lastName' => $usersData->lastName,
    'experience' => $usersData->experience,
    'salary' => $usersData->salary,
    'vacationDays' => $usersData->vacationDays,
    'gasStation' => $usersData->gasStation,
);

// Make JSON
print_r(json_encode($user_arr));