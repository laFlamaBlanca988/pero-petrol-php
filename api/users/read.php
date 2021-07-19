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

// Users query
$result = $usersData->read_users();

// Get row count
$num = $result->rowCount();

// Check if any users
if ($num > 0) {
    $user_arr = array();
    $user_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $user = array(
            'userID' => $userID,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'experience' => $experience,
            'salary' => $salary,
            'vacationDays' => $vacationDays,
            'gasStation' => $gasStation,

        );
        // Push to 'data
        array_push($user_arr['data'], $user);
    }
    // Turn to JSON & output
    echo json_encode($user_arr);
} else {
    echo json_encode(array('message' => 'No users found!'));
}