<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
    header('Location: index.php?error=1');
}
require_once '../config/Database.php';

$database = new Database();
$db = $database->connect();
$query = "SELECT
         users.userID, users.firstName, users.lastName, users.experience, users.salary, users.vacationDays, users.email, users.password, users.gasStation
        FROM users";
$statement = $db->prepare($query);

$statement->execute();
$staff = $statement->fetchAll(PDO::FETCH_ASSOC);
