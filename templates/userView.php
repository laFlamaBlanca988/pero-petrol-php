<?php require_once '../includes/headers.php';?>
<?php require_once '../includes/navbar.php';?>
<?php require_once '../user.php';?>

<body>
    <?php require_once './stationView.php';?>

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
        <form action="userView.php" method="POST" class="form-container">
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

    <?php require_once '../includes/footer.php'?>
</body>

</html>