<?php
if(session_status()==PHP_SESSION_NONE)session_start();
include "db_config.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $auth->login($email, $password);
  

}




?>