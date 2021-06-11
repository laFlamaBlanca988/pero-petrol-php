<?php
require_once 'database.php';

$errors = [];

$firstName = '';
$lastName = '';
$email = '';
$password = '';
$gasStation = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {

    $statement = $pdo->prepare('SELECT * FROM users');
    // Execute
    $statement->execute();
    //Fetch
    $staff = $statement->fetchAll(PDO::FETCH_ASSOC);

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dbPassword = password_hash($password, PASSWORD_DEFAULT);
    $gasStation = $_POST['gasStation'];

    foreach ($staff as $employee) {

        if ($employee['firstName'] === $firstName && $employee['lastName'] === $lastName && $employee['gasStation'] === $gasStation && $password && $email) {

            $statement = $pdo->prepare("UPDATE users SET  email = :email, password = :password WHERE firstName = :firstName AND lastName = :lastName AND gasStation = :gasStation");
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $dbPassword);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':gasStation', $gasStation);
            if ($statement->execute()) {
                header('Location: login.php');
            }
        }if (!$firstName || !$lastName || !$email || !$password || !$gasStation) {
            $errors[0] = 'All fields are required';

        } else {
            $errors[0] = 'Wrong personal data!';
        }
    }
}

if (isset($_POST['login'])) {
    header('Location: login.php');
}
?>

<?php require_once 'headers.php';?>


<body class='container'>
    <h1>Registration Form</h1>

    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
        <div><?php echo $error ?></div>
        <?php endforeach;?>
    </div>
    <?php endif;?>

    <form action="register.php" method="post" class="reg-form">
        <div class="mb-3">
            <label>First name</label>
            <input type="text" name="firstName" value="<?php $firstName?>" class="form-control">
        </div>
        <div class="mb-3">
            <label>Last name</label>
            <input type=text name="lastName" value="<?php $lastName?>" class=" form-control"></input>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="<?php $email?>" class=" form-control">
        </div>
        <div class="mb-3">
            <label>Password</label>
            <input type="password" name="password" value="<?php $password?>" class=" form-control">
        </div>
        <div class="mb-3">
            <label>Gas station</label>
            <input type="number" name="gasStation" value="<?php $gasStation?>" class=" form-control"></input>
        </div>
        <div class="buttons">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <button type="submit" name="login" class="btn btn-primary btn-login">Login instead?</button>
        </div>

    </form>
</body>

</html>