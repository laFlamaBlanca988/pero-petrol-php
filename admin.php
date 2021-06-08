<?php
session_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
    header('Location: login.php?error=1');
}
require_once 'database.php';
// Prepere for execution
$statement = $pdo->prepare("SELECT * FROM users");
// Execute
$statement->execute();
//Fetch
$staff = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<?php require_once 'headers.php';
require_once 'navbar.php';
?>

<body class='container'>

    <?php require_once 'station.php';?>

    <h3 class='staff-admin'>Staff</h3>
    <table class="table">
        <thead>
            <tr class='table-header'>
                <th scope="col">#</th>
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

            <?php
foreach ($staff as $i => $user): ?>

            <tr class='table-row'>
                <th scope="row"><?php echo $i + 1 ?></th>
                <td><?=$user['firstName']?></td>
                <td><?=$user['lastName']?></td>
                <td><?=$user['experience']?></td>
                <td><?=$user['salary']?></td>
                <td><?=$user['vacationDays']?></td>
                <td><?=$user['email']?></td>
                <td><?="" ? "" : substr($user['password'], -7) . '...'?>
                </td>
                <td>
                    <!-- <form action="delete.php" method="post">
                        <input type="hidden" name="userID" value="<?php $_SESSION['userID']?>">
                        <button type="submit" class="btn btn-dark">Delete</button>
                    </form> -->
                    <a href="edit.php?userID=<?=$user['userID']?>" type="button" class="btn btn-danger">Edit user
                        info</a>
                </td>
            </tr>
            <?php endforeach;?>

        </tbody>
    </table>



</body>

</html>