<?php
session_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
    header('Location: login.php?error=1');
}
$userID = $_GET['userID'] ?? null;

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
    $em = $user['email'];
    $pass = $user['password'];
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

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    
    if (!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        $errors[0] = 'Password should be at least 8 characters in length and should include at least one upper case letter and one number.';
    } 
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
    <div class="admin--edit-wraper">
        <h3 class='user--profile-name'><?="$fn $ln"?></h3>
        <?php require_once 'alert.php';?>
        <form action="" method="POST" class="edit-form">
            <div class='edit-left'>
                <label>First name</label>
                <input type="text" name="firstName" value="<?= $fn?>" class="form-control">
                <label>Last name</label>
                <input type=text name="lastName" value="<?= $ln ?>" class=" form-control"></input>
                <label>Email</label>
                <input type="email" name="email" value="<?= $em ?>" class=" form-control">
                <label>Password</label>
                <input type="password" name="password" value="<?= $pass ?>" class=" form-control">
            </div>
            <div class='edit-right'>
                <label>Gas station</label>
                <input type="number" name="gasStation" max="3" min="1" value="<?= $gs ?>" class=" form-control"></input>
                <label>Vacation days</label>
                <input type="number" name="vacationDays" value="<?= $vd ?>" class=" form-control"></input>
                <label>Salary</label>
                <input type="number" name="salary" value="<?= $sal ?>" class=" form-control"></input>
                <label>Experience</label>
                <input type="number" name="experience" value="<?= $ex ?>" class=" form-control"></input>
            </div>
            <div class="edit--form-buttons">
                <button type="submit" name='submit' class="btn btn-danger">Save changes</button>
                <a href="admin.php" type="submit" class="btn btn-dark">Dismiss</a>
            </div>
        </form>
    </div>
    <?php require_once 'footer.php'?>
</body>