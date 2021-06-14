<?php
require_once 'database.php';

$errors = [];

$firstName = '';
$lastName = '';
$experience = '';
$salary = '';
$vacationDays = '';
$email = '';
$password = '';
$gasStation = '';
$userID = '';
$isAdmin = '';

if (isset($_GET['error']) && $_GET['error'] == 1) {
    $errors[0] = 'You must login first!';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {
    $statement = $pdo->prepare('SELECT * FROM users');
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':firstName', $firstName);
    $statement->bindValue(':experience', $experience);
    $statement->bindValue(':vacationDays', $vacationDays);
    $statement->bindValue(':salary', $salary);
    $statement->bindValue(':lastName', $lastName);
    $statement->bindValue(':gasStation', $gasStation);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':isAdmin', $isAdmin);
    $statement->execute();
    $staff = $statement->fetchAll(PDO::FETCH_ASSOC);

    $email = $_POST['email'];
    $password = $_POST['password'];

    foreach ($staff as $employee) {

        if ($email === $employee['email'] && password_verify($password, $employee['password'])) {
            session_start();

            $_SESSION['firstName'] = $employee['firstName'];
            $_SESSION['lastName'] = $employee['lastName'];
            $_SESSION['email'] = $employee['email'];
            $_SESSION['userID'] = $employee['userID'];
            $_SESSION['vacationDays'] = $employee['vacationDays'];
            $_SESSION['gasStation'] = $employee['gasStation'];
            $_SESSION['experience'] = $employee['experience'];
            $_SESSION['salary'] = $employee['salary'];
            $_SESSION['password'] = $password;

            if ($employee['isAdmin']) {
                header('Location: admin.php');
                $_SESSION['isAdmin'] = true;
            } else {
                header('Location: user.php');
                $_SESSION['isAdmin'] = false;
            }
        }
        $errors[0] = !$email || !$password ? 'Password and email required!' : 'Invalid email or password!';
    }
}
?>

<?php require_once 'headers.php';?>

<body>
    <div class='login-logo'>
        <h1 class='register-logo'><u>P</u>PETROL</h1>
    </div>

    <div class="login--form-wraper">

        <?php require_once 'alert.php';?>

        <form action="login.php" method="post" class="login-form">
            <h4 class='login-title'>Sign In</h4>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="<?php $email?>" class="form-control">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type=password name="password" value="<?php $password?>" class="form-control"></input>
            </div>
            <div class="mb-3">
                <button type="submit" name="submit" class="btn btn-danger">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>