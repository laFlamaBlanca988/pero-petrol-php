<?php if (!isset($_SESSION['isAdmin'])) {
    header('Location: login.php?error=1');
}
?>
<footer class="footer container-fluid">
    <div class="text-center text-light p-3">
        © 2021 Copyright:
        <a class="text-light">ombreNegro</a>
    </div>
</footer>