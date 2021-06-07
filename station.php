<?php
require_once 'database.php';

$gasStation = '';
$petrol95 = '';
$petrol98 = '';
$diesel = '';
$gas = '';
$stationID = '';

$statement = $pdo->prepare("SELECT * FROM gas_stations");
$statement->bindValue(':gasStation', $gasStation);
$statement->bindValue(':petrol95', $petrol95);
$statement->bindValue(':petrol98', $petrol98);
$statement->bindValue(':diesel', $diesel);
$statement->bindValue(':gas', $gas);
$statement->bindValue(':stationID', $stationID);

$statement->execute();
$stationData = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require_once 'headers.php';?>

<body class='container'>

    <h3 class="station-title">Station Data</h3>
    <table class=" table-station table">
        <thead>
            <tr class="table-header">
                <th scope="col">#</th>
                <th scope="col">Gas Station</th>
                <th scope="col">Diesel</th>
                <th scope="col">Petrol 95</th>
                <th scope="col">Petrol 98</th>
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

                <?php if ($_SESSION['isAdmin'] || $_SESSION['gasStation'] === $station['stationID']): ?>
                <td class="buttons-station">
                    <a href="update.php?id=<?php $station['stationID']?>" type="button"
                        class="btn btn-danger btn-sm">Change
                        Values</a>
                </td>
                <?php endif;?>

            </tr>
            <?php endforeach;?>

        </tbody>
    </table>
</body>

</html>