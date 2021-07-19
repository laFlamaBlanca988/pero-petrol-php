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

<script>
function showTime() {
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";

    if (h == 0) {
        h = 12;
    }

    if (h > 12) {
        h = h - 12;
        session = "PM";
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerText = time;
    document.getElementById("MyClockDisplay").textContent = time;

    setTimeout(showTime, 1000);

}

showTime();
</script>