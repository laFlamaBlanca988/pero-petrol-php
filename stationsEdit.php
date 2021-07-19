<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
    header('Location: index.php?error=1');
}
require_once 'database.php';

$stationID = $_GET['stationID'] ?? null;
$errors = [];
$petrol95 = '';
$petrol98 = '';
$diesel = '';
$gas = '';

$statement = $pdo->prepare("SELECT * FROM gas_stations WHERE stationID = :stationID");
$statement->bindValue(':stationID', $stationID);
$statement->execute();
$stationData = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($stationData as $station) {
    $petrol95UI = $station['petrol95'];
    $petrol98UI = $station['petrol98'];
    $dieselUI = $station['diesel'];
    $gasUI = $station['gas'];
}
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitEditFuel'])){

    $petrol95 = $_POST['petrol95'];
    $petrol98 = $_POST['petrol98'];
    $diesel = $_POST['diesel'];
    $gas = $_POST['gas'];
    
    if (!$petrol95 || !$petrol98 || !$diesel || !$gas) {
        $errors[0] = 'All fields are required';

    }
    if(empty($errors)){  
        $statement = $pdo->prepare("UPDATE gas_stations SET petrol95 = :petrol95, petrol98 = :petrol98, diesel = :diesel, gas = :gas WHERE stationID = :stationID");
        $statement->bindValue(':petrol95', $petrol95);
        $statement->bindValue(':petrol98', $petrol98);
        $statement->bindValue(':diesel', $diesel);
        $statement->bindValue(':gas', $gas);
        $statement->bindValue(':stationID', $stationID);        
        $statement->execute();
    
        header('Location: adminView.php');
    }
 }