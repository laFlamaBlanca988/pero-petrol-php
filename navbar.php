<?php
require_once 'headers.php';
?>

<header class="container-fluid">
    <nav class="navbar">
        <h1 class="logo"><u>P</u>PETROL</h1>
        <div class="welcome">
            <?="<h5>" . 'Welcome ' . $_SESSION['firstName'] . '!' . "</h5>"?>
            <form class="form-logout" action="logout.php" method="POST">
                <button class="btn btn-danger" type="submit" name="logout">Log Out</button>
            </form>
        </div>
    </nav>
</header>