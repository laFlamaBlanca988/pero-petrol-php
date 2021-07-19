<?php
header('Access-Control-Allow-Origin: *');
if (!isset($_SESSION['isAdmin'])) {
    header('Location: /ppetrol/index.php?error=1');
}
require_once '../config/Database.php';

$gasStation = "Station " . $_SESSION['gasStation'] . "";
$petrol95 = '';
$petrol98 = '';
$diesel = '';
$gas = '';
$stationID = $_SESSION['gasStation'];

$database = new Database();
$db = $database->connect();
$statement = $db->prepare("SELECT
gas_stations.gasStation, gas_stations.stationID, gas_stations.petrol95, gas_stations.petrol98, gas_stations.diesel, gas_stations.gas
FROM gas_stations
ORDER BY stationID
 ");
$statement->bindValue(':gasStation', $gasStation);
$statement->bindValue(':petrol95', $petrol95);
$statement->bindValue(':petrol98', $petrol98);
$statement->bindValue(':diesel', $diesel);
$statement->bindValue(':gas', $gas);
$statement->bindValue(':stationID', $stationID);
$statement->execute();
$stationData = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitStationEdit'])) {

    foreach ($stationData as $station) {

        if ($_SESSION['isAdmin'] === false) {

            $petrol95 = $_POST['petrol95'];
            $petrol98 = $_POST['petrol98'];
            $diesel = $_POST['diesel'];
            $gas = $_POST['gas'];

            $_SESSION['petrol95'] = $station['petrol95'];
            $_SESSION['petrol98'] = $station['petrol98'];
            $_SESSION['diesel'] = $station['diesel'];
            $_SESSION['gas'] = $station['gas'];

            $statement = $db->prepare("UPDATE gas_stations SET gasStation = :gasStation, petrol95 = :petrol95, petrol98 = :petrol98, diesel = :diesel, gas = :gas WHERE stationID = :stationID");
            $statement->bindValue(':gasStation', $gasStation);
            $statement->bindValue(':petrol95', $petrol95);
            $statement->bindValue(':petrol98', $petrol98);
            $statement->bindValue(':diesel', $diesel);
            $statement->bindValue(':gas', $gas);
            $statement->bindValue(':stationID', $stationID);
            $statement->execute();

            header("Refresh: 0");
        }
    }
}

function getApi($url)
{
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($handle, CURLOPT_HTTPHEADER, array("Authorization: Token 1880b7acfcb5fa734b37bc3414b4d623", "Content-Type: application/json"));

    $data = curl_exec($handle);
    if ($e = curl_error($handle)) {
        echo $e;
    } else {
        $decoded = json_decode($data, true);
        return $decoded;
    }
    curl_close($handle);
}
$oilDataUsa = getApi('https://api.oilpriceapi.com/v1/prices/latest');
$oilPrice = $oilDataUsa['data']['formatted'];