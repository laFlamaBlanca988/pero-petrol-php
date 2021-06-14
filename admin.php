<?php
session_start();

if (!isset($_SESSION['isAdmin']) || $_SESSION['isAdmin'] == false) {
    header('Location: login.php?error=1');
}
require_once 'database.php';

$statement = $pdo->prepare("SELECT * FROM users");
$statement->execute();
$staff = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
require_once 'headers.php';
require_once 'navbar.php';
?>

<body>
    <?php require_once 'station.php';?>

    <h3 class='staff-title'>Staff</h3>
    <div class="staff-container">
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
                <?php foreach ($staff as $i => $user): ?>
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
                        <a href="adminEdit.php?userID=<?=$user['userID']?>" name="adminEdit" type="submit"
                            class="btn btn-danger">Edit info</a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php require_once 'footer.php'?>
</body>
</html>