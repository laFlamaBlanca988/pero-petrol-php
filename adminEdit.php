<?php
session_start();

$userID = $_GET['userID'] ?? null;

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
    header('Location: login.php?error=1');
}
// if(isset($_POST['adminEdit']) && $_POST['adminEdit']){
//     $_SESSION('currentUser') = 
// }

require_once 'database.php';

$errors = [];
$firstName = '';
$lastName = '';
$email = '';
$password = '';
$gasStation = '';
$salary = '';
$vacationDays = '';
$experience = '';
$pass = '';
$statement = $pdo->prepare("SELECT * FROM users WHERE userID = :userID");
$statement->bindValue(':userID', $userID);
$statement->execute();
$staff = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($staff as $user) {
    $fn = $user['firstName'];
    $ln = $user['lastName'];
    $vd = $user['vacationDays'];
    $gs = $user['gasStation'];
    $ex = $user['experience'];
    $sal = $user['salary'];
}
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])){
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dbPassword = password_hash($password, PASSWORD_DEFAULT);
    $gasStation = $_POST['gasStation'];
    $salary = $_POST['salary'];
    $experience = $_POST['experience'];
    $vacationDays = $_POST['vacationDays'];
    if (!$firstName || !$lastName || !$email || !$password || !$gasStation || !$vacationDays || !$experience || !$salary) {
        $errors[0] = 'All fields are required';

    }
    if(empty($errors)){  
        $statement = $pdo->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, email = :email, password = :password, vacationDays = :vacationDays, experience = :experience, salary = :salary, gasStation = :gasStation WHERE userID = :userID");
        $statement->bindValue(':firstName', $firstName);
        $statement->bindValue(':lastName', $lastName);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $dbPassword);
        $statement->bindValue(':vacationDays', $vacationDays);
        $statement->bindValue(':experience', $experience);
        $statement->bindValue(':salary', $salary);
        $statement->bindValue(':gasStation', $gasStation);
        $statement->bindValue(':userID', $userID);        
        $statement->execute();
    
        header('Location: admin.php');
    }
 }
?>

<?php require_once 'headers.php'?>
<?php require_once 'navbar.php'?>

<body>
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
                <label>First name</label>
                <input type="text" name="firstName" value="<?= $fn?>" class="form-control">
            </div>
            <div class="mb-3">
                <label>Last name</label>
                <input type=text name="lastName" value="<?= $ln ?>" class=" form-control"></input>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="<?php $email ?>" class=" form-control">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" value="<?php $password ?>" class=" form-control">
            </div>
            <div class="mb-3">
                <label>Gas station</label>
                <input type="number" name="gasStation" value="<?= $gs ?>" class=" form-control"></input>
            </div>
            <div class="mb-3">
                <label>Vacation days</label>
                <input type="number" name="vacationDays" value="<?= $vd ?>" class=" form-control"></input>
            </div>
            <div class="mb-3">
                <label>Salary</label>
                <input type="number" name="salary" value="<?= $sal ?>" class=" form-control"></input>
            </div>
            <div class="mb-3">
                <label>Experience</label>
                <input type="number" name="experience" value="<?= $ex ?>" class=" form-control"></input>
            </div>
            <div class="edit-user-buttons">
                <a href="admin.php" type="submit" class="btn btn-dark">Dismiss</a>
                <button type="submit" name='submit' class="btn btn-danger">Save changes</button>
            </div>
        </form>
    </div>

</body>