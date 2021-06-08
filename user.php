<?php
session_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == true) {
    header('Location: login.php?error=1');
}
require_once 'database.php';
// Prepere for execution
$statement = $pdo->prepare('SELECT * FROM users');
// Execute
$statement->execute();
//Fetch
$staff = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require_once 'navbar.php';?>
<?php require_once 'headers.php';?>

<body class='container'>

    <?php require_once 'station.php';?>

    <h3 class="staff-title">Your profile</h3>
    <table class=" table-staff table ">
        <thead>
            <tr>
                <!-- <th scope="col">#</th> -->
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Experience</th>
                <th scope="col">Salary</th>
                <th scope="col">Vacation Days</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <!-- <th scope="row"><?php echo $i + 1 ?></th> -->
                <td><?php echo $_SESSION['firstName'] ?></td>
                <td><?php echo $_SESSION['lastName'] ?></td>
                <td><?php echo $_SESSION['experience'] ?></td>
                <td><?php echo $_SESSION['salary'] ?></td>
                <td><?php echo $_SESSION['vacationDays'] ?></td>
                <td><?php echo $_SESSION['email'] ?></td>
                <td><?php echo $_SESSION['password'] ?></td>
                <td>
                    <a href="update.php?id=<?php $_SESSION['userID']?>" type="button"
                        class="btn btn-danger btn-sm">Edit</a>
                </td>
            </tr>

        </tbody>
    </table>



</body>

</html>