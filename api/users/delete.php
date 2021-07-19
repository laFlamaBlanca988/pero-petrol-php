<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Users.php';

// Instantiate & connect DB
$database = new Database();
$db = $database->connect();

// Instantiate users object
$usersData = new Users($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$usersData->userID = $data->userID;

// Create post
if ($usersData->delete_user()) {
    echo json_encode(
        array('Message' => 'Post Deleted')
    );
} else {
    echo json_encode(
        array('Message' => 'Post Not Deleted')
    );
}