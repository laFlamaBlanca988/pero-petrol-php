<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
    header('Location: index.php?error=1');
}

require_once '../model/Users.php';
require_once $_SERVER['DOCUMENT_ROOT'] . "/ppetrol/config/Database.php";

$database = new Database();
$db = $database->connect();

$userID = $_GET['userID'] ?? null;

$errors = [];
$firstName = '';
$lastName = '';
$email = '';
$password = '';
$gasStation = '';
$salary = '';
$vacationDays = '';
$experience = '';
$pass = '';

$statement = $db->prepare("SELECT
users.userID, users.firstName, users.lastName, users.experience, users.salary, users.vacationDays, users.email, users.password, users.gasStation FROM users 
WHERE userID = :userID");
$statement->bindValue(':userID', $userID);
$statement->execute();
$staff = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($staff as $user) {
    $fn = $user['firstName'];
    $ln = $user['lastName'];
    $vd = $user['vacationDays'];
    $gs = $user['gasStation'];
    $ex = $user['experience'];
    $sal = $user['salary'];
    $em = $user['email'];
    $pass = $user['password'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dbPassword = password_hash($password, PASSWORD_DEFAULT);
    $gasStation = $_POST['gasStation'];
    $salary = $_POST['salary'];
    $experience = $_POST['experience'];
    $vacationDays = $_POST['vacationDays'];

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    
    if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        $errors[0] = 'Password should be at least 8 characters in length and should include at least one upper case letter and one number.';
    } 
    if (!$firstName || !$lastName || !$email || !$password || !$gasStation || !$vacationDays || !$experience || !$salary) {
        $errors[0] = 'All fields are required';
    }
    if(empty($errors)){  
        $statement = $db->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email, password = :password, vacationDays = :vacationDays, experience = :experience, salary = :salary, gasStation = :gasStation WHERE userID = :userID");
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $dbPassword);
        $statement->bindValue(':vacationDays', $vacationDays);
        $statement->bindValue(':experience', $experience);
        $statement->bindValue(':salary', $salary);
        $statement->bindValue(':gasStation', $gasStation);
        $statement->bindValue(':userID', $userID);        
        $statement->execute();
    
        header('Location: adminView.php');
    }
 }

 if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])){
        $query = "DELETE FROM users WHERE userID = :userID";
        $statement = $db->prepare($query);
        $statement->bindParam(':userID', $userID);
        
        if ($statement->execute()) {
            header('Location: adminView.php');
        }
    }