<?php
include_once '../includes/headers.php';
require_once '../includes/navbar.php';
require_once '../admin.php';
?>

<body>
    <?php require_once './stationView.php';?>
    <h3 class='staff-title'>Staff</h3>
    <div class="add-user-container">
        <a href="registerView.php" type="submit" class="add-user-btn btn btn-danger">Register new user</a>
    </div>
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
                    <th scope="col">Station</th>
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
                    <td max='3'><?="Station " . $user['gasStation'] . ""?></td>
                    <td><?=$user['email']?></td>
                    <td><?="" ? "" : substr($user['password'], -7) . '...'?>
                    </td>
                    <td>
                        <a href="adminEditView.php?userID=<?=$user['userID']?>" name="adminEdit" type="submit"
                            class="btn btn-danger">Edit info</a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <?php require_once '../includes/footer.php'?>
</body>

</html>