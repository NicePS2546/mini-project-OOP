<?php 
        session_start(); // Start the session
        if(!isset($_SESSION['id'])){
            header("Location: login.php"); // Redirect to login page if not logged in
            exit();
        }
            session_unset(); // Unset all session variables
            session_destroy(); // Destroy the session
            header("Location: login.php"); // Redirect to the login page
            exit();               
    ?>