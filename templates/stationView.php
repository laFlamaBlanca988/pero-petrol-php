<?php require_once '../includes/headers.php';?>
<?php require_once '../station.php';?>

<body>
    <h3 class="station-title">Gas stations</h3>
    <div class="station-container">
        <table class="table-station table">
            <div class="barrel-price-container">
                <p class="barrel-text" scope="col">World barrel price:
                <p class="barrel-price"> <?=$oilPrice?></p>
                </p>
            </div>
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
                <?php foreach ($stationData as $i => $station): ?>
                <tr class="table-row">
                    <td class='text-bold'><?=$i + 1?></td>
                    <td><?=$station['gasStation']?></td>
                    <td><?=round($station['petrol95'], 2)?></td>
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
                        <a href="stationsEditView.php?stationID=<?=$station['stationID']?>" name="stationsEdit"
                            type="submit" class="btn btn-danger btn-sm">Change fuel
                            amount</a>
                    </td>
                    <?php endif;?>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <sup>All units are expressed in barrels</sup>
    </div>

    <div id="overlayStation" onclick="openClose('none')"></div>
    <div class="formStation-popup" id="formStation">
        <form action="userView.php" method="POST" class="formStation-container">
            <?php foreach ($stationData as $station): ?>
            <?php if ($station['stationID'] === $_SESSION['gasStation']): ?>
            <label for="petrol95"><b>Petrol95</b></label>
            <input type="number" name="petrol95" value="<?=$station['petrol95']?>">
            <label for="petrol98"><b>Petrol98</b></label>
            <input type="number" name="petrol98" value="<?=$station['petrol98']?>">
            <label for="diesel"><b>Diesel</b></label>
            <input type="number" name="diesel" value="<?=$station['diesel']?>">
            <label for="gas"><b>Gas</b></label>
            <input type="number" name="gas" value="<?=$station['gas']?>">
            <?php endif;?>
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