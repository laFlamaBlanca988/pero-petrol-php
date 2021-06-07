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
    //Fetch
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


<body class='container'>
    <h1>Login Form</h1>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
        <div><?php echo $error ?></div>
        <?php endforeach;?>
    </div>
    <?php endif;?>

    <form action="login.php" method="post" class="reg-form">
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="<?php $email?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type=password name="password" value="<?php $password?>" class="form-control"></input>
        </div>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

</html>