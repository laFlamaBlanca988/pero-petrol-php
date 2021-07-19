<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../model/Users.php';
include_once '../../config/Database.php';

class User
{
    const READ = "read";
    const READ_SINGLE = "read_single";
    const CREATE = "create";
    const UPDATE = "update";
    const DELETE = "delete";

    public function run($param)
    {
        $param = $_GET['param'];
        // $id = $_GET['userID'];

        switch ($param) {
            case $this->READ:
                $this->read();
                break;
            case $this->READ_SINGLE:
                $this->read_single();
                break;
            case $this->CREATE:
                $this->create();
                break;
            case $this->UPDATE:
                $this->update();
                break;
            case $this->DELETE:
                $this->delete();
                break;
                return;
        }
    }
    public function read()
    {
        $database = new Database();
        $db = $database->connect();

        $usersData = new Users($db);
        $result = $usersData->read_users();
        $num = $result->rowCount();

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
                    'email' => $email,
                    'password' => $password,
                );
                array_push($user_arr['data'], $user);
            }
            echo json_encode($user_arr);
        } else {
            echo json_encode(array('message' => 'No users found!'));
        }
    }

    public function read_single()
    {
        // Instantiate & connect DB
        $database = new Database();
        $db = $database->connect();

        $usersData = new Users($db);
        // Get ID
        $usersData->userID = isset($_GET['userID']) ? $_GET['userID'] : die();
        $usersData->read_user_single();

        $user_arr = array(
            'userID' => $usersData->userID,
            'firstName' => $usersData->firstName,
            'lastName' => $usersData->lastName,
            'experience' => $usersData->experience,
            'salary' => $usersData->salary,
            'vacationDays' => $usersData->vacationDays,
            'gasStation' => $usersData->gasStation,
            'email' => $usersData->email,
            'password' => $usersData->password,
        );
        print_r(json_encode($user_arr));
    }

    public function create()
    {
        // Instantiate & connect DB
        $database = new Database();
        $db = $database->connect();

        $usersData = new Users($db);

        $data = json_decode(file_get_contents("php://input"));

        $usersData->firstName = $data->firstName;
        $usersData->lastName = $data->lastName;
        $usersData->experience = $data->experience;
        $usersData->salary = $data->salary;
        $usersData->vacationDays = $data->vacationDays;
        $usersData->gasStation = $data->gasStation;
        $usersData->email = $data->email;
        $usersData->password = $data->password;

        if ($usersData->create_user()) {
            echo json_encode(
                array('Message' => 'Post Created')
            );
        } else {
            echo json_encode(
                array('Message' => 'Post Not Created')
            );
        }
    }

    public function update()
    {
        $database = new Database();
        $db = $database->connect();

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
    }
    public function delete()
    {
        // Instantiate & connect DB
        $database = new Database();
        $db = $database->connect();

        $usersData = new Users($db);

        $data = json_decode(file_get_contents("php://input"));

        $usersData->userID = $data->userID;

        if ($usersData->delete_user()) {
            echo json_encode(
                array('Message' => 'Post Deleted')
            );
        } else {
            echo json_encode(
                array('Message' => 'Post Not Deleted')
            );
        }
    }
}