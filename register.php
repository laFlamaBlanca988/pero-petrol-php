<?php
require_once 'database.php';

$errors = [];

$firstName = '';
$lastName = '';
$email = '';
$password = '';
$confirmPassword = '';
$gasStation = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {

    $statement = $pdo->prepare('SELECT * FROM users');
    $statement->execute();
    $staff = $statement->fetchAll(PDO::FETCH_ASSOC);

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $dbPassword = password_hash($password, PASSWORD_DEFAULT);
    $gasStation = $_POST['gasStation'];

    foreach ($staff as $employee) {
        if (!$firstName || !$lastName || !$email || !$password || !$gasStation) {
            $errors[0] = 'All fields are required!';
        } elseif ($password !== $confirmPassword) {
            $errors[0] = 'Wrong password validation!';
        } elseif ($firstName !== $employee['firstName'] || $lastName !== $employee['lastName'] || $gasStation !== $employee['gasStation']) {
            $errors[0] = 'Wrong personal data!';
        } else {
            $statement = $pdo->prepare("UPDATE users SET  email = :email, password = :password WHERE firstName = :firstName AND lastName = :lastName AND gasStation = :gasStation");
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $dbPassword);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':gasStation', $gasStation);
            if ($statement->execute()) {
                header('Location: login.php');
            }
        }
    }
}

if (isset($_POST['login'])) {
    header('Location: login.php');
}
?>


<?php require_once 'headers.php';?>

<body class='container'>
    <div>
        <h1 class='register-logo'><u>P</u>PETROL</h1>
    </div>
    <div class="register--form-wraper ">

        <?php require_once 'alert.php';?>

        <form action="register.php" method="post" class="reg-form">
            <div class='edit--form-left'>
                <h4 class='login-title'>Registration form</h4>
                <label>First name</label>
                <input type="text" name="firstName" value="<?php $firstName?>" class="form-control">

                <label>Last name</label>
                <input type=text name="lastName" value="<?php $lastName?>" class=" form-control"></input>

                <label>Email</label>
                <input type="email" name="email" value="<?php $email?>" class=" form-control">
            </div>
            <div class='edit--form-right'>
                <label>Password</label>
                <input type="password" name="password" value="<?php $password?>" class=" form-control">

                <label>Confirm password</label>
                <input type="password" name="confirmPassword" value="<?php $confirmPassword?>" class=" form-control">

                <label>Gas station</label>
                <input type="number" name="gasStation" value="<?php $gasStation?>" class=" form-control"></input>
            </div>

            <div class="reg--form-buttons">
                <button type="submit" name="submit" class=" btn btn-danger">Submit</button>
                <button type="submit" name="login" class="btn--reg-login btn btn-login btn-danger ">Login
                    instead?</button>
            </div>
        </form>
    </div>
</body>

</html>