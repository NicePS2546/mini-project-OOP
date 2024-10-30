<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
; 
if(isset($_SESSION["id"])){
    header("Location: ../index.php"); // Redirect to login page if not logged in
    exit();
};


?>