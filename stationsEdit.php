<?php
session_start();

$stationID = $_GET['stationID'] ?? null;

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
    header('Location: login.php?error=1');
}
require_once 'database.php';

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
    
    // if (!$firstName || !$lastName || !$email || !$password || !$gasStation || !$vacationDays || !$experience || !$salary) {
    //     $errors[0] = 'All fields are required';

    // }
    if(empty($errors)){  
        $statement = $pdo->prepare("UPDATE gas_stations SET petrol95 = :petrol95, petrol98 = :petrol98, diesel = :diesel, gas = :gas WHERE stationID = :stationID");
        $statement->bindValue(':petrol95', $petrol95);
        $statement->bindValue(':petrol98', $petrol98);
        $statement->bindValue(':diesel', $diesel);
        $statement->bindValue(':gas', $gas);
  
        $statement->bindValue(':stationID', $stationID);        
        $statement->execute();
    
        header('Location: admin.php');
    }
 }
?>

<?php require_once 'headers.php'?>
<?php require_once 'navbar.php'?>

<body class='container'>
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
        <div><?php echo $error ?></div>
        <?php endforeach;?>
    </div>
    <?php endif;?>
    <div class="container">
        <form action="" method="POST" class="edit-form">
            <div class="mb-3">
                <label>Petrol 95</label>
                <input type="number" name="petrol95" value="<?= $petrol95UI?>" class="form-control">
            </div>
            <div class="mb-3">
                <label>Petrol 98</label>
                <input type=number name="petrol98" value="<?= $petrol98UI ?>" class=" form-control"></input>
            </div>
            <div class="mb-3">
                <label>Diesel</label>
                <input type="number" name="diesel" value="<?= $dieselUI ?>" class=" form-control">
            </div>
            <div class="mb-3">
                <label>Gas</label>
                <input type="number" name="gas" value="<?= $gasUI ?>" class=" form-control">
            </div>
            <div class="edit-user-buttons">
                <a href="admin.php" type="submit" class="btn btn-dark">Dismiss</a>
                <button type="submit" name='submitEditFuel' class="btn btn-danger">Save changes</button>
            </div>
        </form>
    </div>

</body>