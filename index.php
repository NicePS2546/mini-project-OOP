<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
;


if (!isset($_SESSION['role']) || !isset($_SESSION['id'])) {
    header("Location: loginCrud/login.php");
    exit();
}else{
    header("Location: pages/index.php");
    exit();
}

?>