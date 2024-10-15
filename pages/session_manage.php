<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
;


if (!isset($_SESSION['username']) && !isset($_SESSION['id'])) {
    header("Location: ../mini-php-project/loginCrud/login.php");
    exit();
}

?>