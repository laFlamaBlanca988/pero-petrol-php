<?php
require_once 'headers.php';
?>

<header class="container">
    <nav class="navbar navbar-light bg-light">
        <h1 class="logo">PPETROL</h1>
        <div class="welcome">
            <?="<h5>" . 'Welcome ' . $_SESSION['firstName'] . '!' . "</h5>"?>
            <form class="form-logout" action="logout.php" method="POST">
                <button class="btn btn-danger" type="submit" name="logout">Log Out</button>
            </form>
        </div>

    </nav>

</header>