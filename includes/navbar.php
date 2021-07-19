<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['isAdmin'])) {
    header('Location: index.php?error=1');
}
require_once 'headers.php';
?>

<header class="container-fluid">
    <nav class="navbar">
        <h1 class="logo"><u>P</u>PETROL</h1>
        <div class="welcome">
            <?="<h5>" . 'Welcome ' . $_SESSION['firstName'] . '!' . "</h5>"?>
            <form class="form-logout" action="/ppetrol/index.php" method="POST">
                <button class="btn btn-danger" type="submit" name="logout">Log Out</button>
            </form>
        </div>
    </nav>
    <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
</header>