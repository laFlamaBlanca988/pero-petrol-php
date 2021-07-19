<?php
if (!isset($_SESSION)) {
    session_start();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["logout"])) {
    unset($_SESSION["isAdmin"]);
    session_destroy($_SESSION["isAdmin"]);
    header("Location: index.php");
}