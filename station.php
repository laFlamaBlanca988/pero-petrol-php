<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'database.php';

$gasStation = "Station " . $_SESSION['gasStation'] . "";
$petrol95 = '';
$petrol98 = '';
$diesel = '';
$gas = '';
$stationID = $_SESSION['gasStation'];

$statement = $pdo->prepare("SELECT * FROM gas_stations");
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

            $statement = $pdo->prepare("UPDATE gas_stations SET gasStation = :gasStation, petrol95 = :petrol95, petrol98 = :petrol98, diesel = :diesel, gas = :gas WHERE stationID = :stationID");
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

?>

<?php require_once 'headers.php';?>

<body class='container'>

    <h3 class="station-title">Gas station</h3>
    <table class=" table-station table">
        <thead>
            <tr class="table-header">
                <th scope="col">#</th>
                <th scope="col">Gas Station</th>
                <th scope="col">Petrol 95</th>
                <th scope="col">Petrol 98</th>
                <th scope="col">Diesel</th>
                <th scope="col">Gas</th>
            </tr>
        </thead>
        <tbody>

            <?php
foreach ($stationData as $i => $station): ?>
            <tr class="table-row">
                <td class='text-bold'><?=$i + 1?></td>
                <td><?=$station['gasStation']?></td>
                <td><?=$station['petrol95']?></td>
                <td><?=$station['petrol98']?></td>
                <td><?=$station['diesel']?></td>
                <td><?=$station['gas']?></td>


                <?php if (!$_SESSION['isAdmin'] && $_SESSION['gasStation'] === $station['stationID']): ?>
                <td class="buttons-station">
                    <button onclick="openClose('block')" type="button" name="submit"
                        class="btn btn-danger btn-sm">Change fuel
                        amount</button>
                </td>
                <?php endif;?>

                <?php if ($_SESSION['isAdmin']): ?>
                <td class="buttons-station">
                    <a href="stationsEdit.php?stationID=<?=$station['stationID']?>" name="stationsEdit" type="submit"
                        class="btn btn-danger btn-sm">Change fuel
                        amount</a>
                </td>
                <?php endif;?>


            </tr>
            <?php endforeach;?>

        </tbody>
    </table>


    <div id="overlayStation" onclick="openClose('none')"></div>
    <div class="formStation-popup" id="formStation">
        <form action="user.php" method="POST" class="formStation-container">
            <?php foreach ($stationData as $station): ?>
            <!-- <?php if ($station['stationID'] === $_SESSION['gasStation']): ?> -->
            <label for="petrol95"><b>Petrol95</b></label>
            <input type="number" name="petrol95" value="<?=$station['petrol95']?>">

            <label for="petrol98"><b>Petrol98</b></label>
            <input type="number" name="petrol98" value="<?=$station['petrol98']?>">

            <label for="diesel"><b>Diesel</b></label>
            <input type="number" name="diesel" value="<?=$station['diesel']?>">

            <label for="gas"><b>Gas</b></label>
            <input type="number" name="gas" value="<?=$station['gas']?>">
            <!-- <?php endif;?> -->
            <?php endforeach;?>
            <div class="change--fuel-button">
                <button type="submit" name="submitStationEdit" class="btn btn-danger btn-sm">Submit</button>
                <button type="button" class="btn btn-dark btn-sm" onclick="openClose('none')">Close</button>
            </div>


        </form>
    </div>

    <script>
    function openClose($display) {
        document.getElementById("formStation").style.display = $display;
        document.getElementById("overlayStation").style.display = $display;
    }
    </script>
</body>

</html>