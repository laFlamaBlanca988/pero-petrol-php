<?php
session_start();
if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == true) {
    header('Location: login.php?error=1');
}
$userID = $_SESSION['userID'];
require_once 'database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitUserEdit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $dbPassword = password_hash($password, PASSWORD_DEFAULT);
    $statement = $pdo->prepare("UPDATE users SET email = :email, password = :password WHERE userID = :userID");
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $dbPassword);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
}
?>

<?php require_once 'navbar.php';?>
<?php require_once 'headers.php';?>

<body>
    <?php require_once 'station.php';?>

    <h3 class="user-title">Your profile</h3>
    <div class='user-container'>
        <table class="table">
            <thead>
                <tr class='table-header'>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Experience</th>
                    <th scope="col">Vacation</th>
                    <th scope="col">Station</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                </tr>
            </thead>
            <tbody>
                <tr class='table-row'>
                    <td><?=$_SESSION['firstName']?></td>
                    <td><?=$_SESSION['lastName']?></td>
                    <td><?=$_SESSION['experience']?></td>
                    <td><?=$_SESSION['vacationDays']?></td>
                    <td><?="Station " . $_SESSION['gasStation'] . ""?></td>
                    <td><?=$_SESSION['email']?></td>
                    <td><?=$_SESSION['password']?></td>
                    <td>
                        <button onclick="openCloseForm('block')" type="button"
                            class="btn btn-danger btn-sm">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div id="overlay" onclick="openCloseForm('none')"></div>
    <div class="form-popup" id="myForm">
        <form action="user.php" method="POST" class="form-container">
            <label for="email"><b>Email</b></label>
            <input type="text" name="email" value="<?=$_SESSION['email']?>" required>
            <label for="psw"><b>Password</b></label>
            <input type="password" name="password" required>
            <button type="submit" name="submitUserEdit" class="btn btn-danger btn-sm">Submit</button>
            <button type="button" class="btn btn-dark btn-sm" onclick="openCloseForm('none')">Close</button>
        </form>
    </div>

    <script>
    function openCloseForm($display) {
        document.getElementById("myForm").style.display = $display;
        document.getElementById("overlay").style.display = $display;
    }
    </script>

    <?php require_once 'footer.php'?>
</body>

</html>