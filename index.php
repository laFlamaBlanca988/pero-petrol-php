<?php
require_once './login.php';
require_once './includes/headers.php';
?>

<body>
    <div class='login-logo'>
        <h1 class='register-logo'><u>P</u>PETROL</h1>
    </div>

    <div class="login--form-wraper">
        <?php require_once './includes/alert.php';?>
        <form action="index.php" method="post" class="login-form">
            <h4 class='login-title'>Sign In</h4>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="<?php $email?>" class="form-control">
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type=password name="password" value="<?php $password?>" class="form-control"></input>
            </div>
            <div class="login-buttons mb-3">
                <button type="submit" name="submit" class="btn btn-danger">Submit</button>
            </div>
        </form>
    </div>
</body>

</html>