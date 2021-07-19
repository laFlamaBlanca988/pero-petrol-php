<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == true) {
    header('Location: index.php?error=1');
}
$userID = $_SESSION['userID'];
require_once '../config/Database.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitUserEdit'])) {
    $database = new Database();
    $db = $database->connect();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dbPassword = password_hash($password, PASSWORD_DEFAULT);
    $statement = $db->prepare("UPDATE users SET email = :email, password = :password WHERE userID = :userID");
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $dbPassword);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $_SESSION['email'] = $email;
}