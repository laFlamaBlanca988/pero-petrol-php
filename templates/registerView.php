<?php require_once '../includes/headers.php';?>
<?php require_once '../register.php'?>

<body class='container'>
    <div>
        <h1 class='register-logo'><u>P</u>PETROL</h1>
    </div>
    <div class="register--form-wraper ">
        <?php require_once '../includes/alert.php';?>
        <form action="" method="POST" class="reg-form">
            <div class='edit--form-left'>
                <h4 class='login-title'>Register new user</h4>
                <label>First name</label>
                <input type="text" name="firstName" value="<?php $firstName?>" class="form-control" required>
                <label>Last name</label>
                <input type=text name="lastName" value="<?php $lastName?>" class=" form-control" required></input>
                <label>Email</label>
                <input type="email" name="email" value="<?php $email?>" class=" form-control" required>
                <label>Gas station</label>
                <input type="number" name="gasStation" min="1" max="3" value="<?php $gasStation?>" class=" form-control"
                    required></input>
                <label>Is admin?(0 or 1)</label>
                <input type="number" name="isAdmin" min="0" max="1" value="<?php $isAdmin?>" class=" form-control"
                    required></input>
            </div>
            <div class='edit--form-right'>
                <label>Password</label>
                <input type="password" name="password" value="<?php $password?>" class=" form-control" required>
                <label>Confirm password</label>
                <input type="password" name="confirmPassword" value="<?php $confirmPassword?>" class=" form-control"
                    required>
                <label>Experience</label>
                <input type="number" name="experience" min="0" max="40" value="<?php $experience?>"
                    class=" form-control" required></input>
                <label>Salary</label>
                <input type="number" name="salary" min="0" value="<?php $salary?>" class=" form-control"
                    required></input>
                <label>Vacation days</label>
                <input type="number" name="vacationDays" min="0" value="<?php $vacationDays?>" class=" form-control"
                    required></input>
            </div>
            <div class="reg--form-buttons">
                <button type="submit" name="submitUser" class=" btn btn-danger">Submit</button>
                <a href="adminView.php" type="submit" class="btn btn-dark">Dismiss</a>
            </div>
        </form>
    </div>
    <?php require_once '../includes/footer.php';?>
</body>

</html>