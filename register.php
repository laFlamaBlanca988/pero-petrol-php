<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
    header('Location: index.php?error=1');
}
require_once '../config/Database.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submitUser"])) {

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $salary = $_POST['salary'];
    $vacationDays = $_POST['vacationDays'];
    $experience = $_POST['experience'];
    $isAdmin = $_POST['isAdmin'];
    $confirmPassword = $_POST['confirmPassword'];
    $gasStation = $_POST['gasStation'];

    $dbPassword = password_hash($password, PASSWORD_DEFAULT);

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);

    if (!$firstName || !$lastName || !$email || !$password || !$gasStation || !$salary || $vacationDays || !$experience || !$isAdmin || !$confirmPassword) {
        $errors[] = 'All fields are required!';
    }
    if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        $errors[0] = 'Password should be at least 8 characters in length and should include at least one upper case letter and one number.';
    } elseif ($password !== $confirmPassword) {
        $errors[0] = 'Wrong password validation!';
    } else {
        $database = new Database();
        $db = $database->connect();

        $statement = $db->prepare("INSERT INTO users SET  firstName = :firstName, lastName = :lastName, email = :email, password = :password, vacationDays = :vacationDays, experience = :experience, salary = :salary, gasStation = :gasStation, isAdmin = :isAdmin");
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $dbPassword);
        $statement->bindValue(':vacationDays', $vacationDays);
        $statement->bindValue(':experience', $experience);
        $statement->bindValue(':salary', $salary);
        $statement->bindValue(':gasStation', $gasStation);
        $statement->bindValue(':isAdmin', $isAdmin);
        if ($statement->execute()) {
            header('Location: adminView.php');
        }
    }
}