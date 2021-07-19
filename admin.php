<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
    header('Location: index.php?error=1');
}
require_once 'database.php';
$statement = $pdo->prepare("SELECT * FROM users");
$statement->execute();
$staff = $statement->fetchAll(PDO::FETCH_ASSOC);
