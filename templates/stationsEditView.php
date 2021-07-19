<?php require_once '../includes/headers.php'?>
<?php require_once '../includes/navbar.php'?>
<?php require_once '../stationsEdit.php'?>

<body>
    <div class='form-wraper'>

        <?php require_once '../includes/alert.php'?>
        <h3 class='station-name'>Station <?=$stationID?></h3>

        <form action="" method="POST" class="edit--form-station">
            <div class="mb-3">
                <label>Petrol 95</label>
                <input type="number" name="petrol95" min="0" value="<?=$petrol95UI?>" class="form-control">
            </div>
            <div class="mb-3">
                <label>Petrol 98</label>
                <input type=number name="petrol98" min="0" value="<?=$petrol98UI?>" class=" form-control"></input>
            </div>
            <div class="mb-3">
                <label>Diesel</label>
                <input type="number" name="diesel" min="0" value="<?=$dieselUI?>" class=" form-control">
            </div>
            <div class="mb-3">
                <label>Gas</label>
                <input type="number" name="gas" min="0" value="<?=$gasUI?>" class=" form-control">
            </div>
            <div class="edit--station-buttons">
                <button type="submit" name='submitEditFuel' class="btn btn-danger">Save changes</button>
                <a href="adminView.php" type="click" class="btn btn-dark">Dismiss</a>
            </div>
        </form>
    </div>
    <?php require_once '../includes/footer.php'?>
</body>