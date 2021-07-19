<?php
require_once './config/Database.php';
$errors = [];

$firstName = '';
$lastName = '';
$experience = '';
$salary = '';
$vacationDays = '';
$email = '';
$password = '';
$gasStation = '';
$userID = '';
$isAdmin = '';

if (isset($_GET['error']) && $_GET['error'] == 1) {
    $errors[0] = 'You must login first!';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
    $database = new Database();
    $db = $database->connect();

    $statement = $db->prepare('SELECT users.userID, users.firstName, users.lastName, users.experience, users.salary, users.vacationDays, users.email, users.password, users.gasStation, users.isAdmin FROM users');
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':experience', $experience);
    $statement->bindValue(':vacationDays', $vacationDays);
    $statement->bindValue(':salary', $salary);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':gasStation', $gasStation);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':isAdmin', $isAdmin);
    $statement->execute();
    $staff = $statement->fetchAll(PDO::FETCH_ASSOC);

    $email = $_POST['email'];
    $password = $_POST['password'];

    foreach ($staff as $employee) {

        if ($email === $employee['email'] && password_verify($password, $employee['password'])) {
            session_start();

            $_SESSION['firstName'] = $employee['firstName'];
            $_SESSION['lastName'] = $employee['lastName'];
            $_SESSION['email'] = $employee['email'];
            $_SESSION['userID'] = $employee['userID'];
            $_SESSION['vacationDays'] = $employee['vacationDays'];
            $_SESSION['gasStation'] = $employee['gasStation'];
            $_SESSION['experience'] = $employee['experience'];
            $_SESSION['salary'] = $employee['salary'];
            $_SESSION['password'] = $password;

            if ($employee['isAdmin']) {
                header('Location: /ppetrol/templates/adminView.php');
                $_SESSION['isAdmin'] = true;
            } else {
                header('Location: /ppetrol/templates/userView.php');
                $_SESSION['isAdmin'] = false;
            }
        }
        $errors[0] = 'Invalid email or password!';
    }
}