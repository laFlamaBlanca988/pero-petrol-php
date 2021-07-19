<?php require_once '../includes/headers.php'?>
<?php require_once '../includes/navbar.php'?>
<?php require_once '../adminEdit.php'?>

<body>
    <div class="admin--edit-wraper">
        <h3 class='user--profile-name'><?="$fn $ln"?></h3>
        <?php require_once '../includes/alert.php';?>
        <form action="" method="POST" class="edit-form">
            <div class='edit-left'>
                <label>First name</label>
                <input type="text" name="firstName" value="<?=$fn?>" class="form-control">
                <label>Last name</label>
                <input type=text name="lastName" value="<?=$ln?>" class=" form-control"></input>
                <label>Email</label>
                <input type="email" name="email" value="<?=$em?>" class=" form-control">
                <label>Password</label>
                <input type="password" name="password" value="<?=$pass?>" class=" form-control">
            </div>
            <div class='edit-right'>
                <label>Gas station</label>
                <input type="number" name="gasStation" max="3" min="1" value="<?=$gs?>" class=" form-control"></input>
                <label>Vacation days</label>
                <input type="number" name="vacationDays" value="<?=$vd?>" class=" form-control"></input>
                <label>Salary</label>
                <input type="number" name="salary" value="<?=$sal?>" class=" form-control"></input>
                <label>Experience</label>
                <input type="number" name="experience" value="<?=$ex?>" class=" form-control"></input>
            </div>
            <div class="edit--form-buttons">
                <button type="submit" name='submit' class="btn btn-danger">Save changes</button>
                <button type="click" name='remove' class="btn btn-danger">Remove user</button>
                <a href="adminView.php" type="submit" class="btn btn-dark">Dismiss</a>
            </div>
        </form>
    </div>
    <?php require_once '../includes/footer.php'?>
</body>