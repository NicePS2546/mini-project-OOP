<?php


$backtrace = debug_backtrace();

// Get the file that included db_config.php
$callerFile = isset($backtrace[0]['file']) ? $backtrace[0]['file'] : '';

// Check if profile.php is the file that included db_config.php
if (strpos($callerFile, '../../pages') !== false) {
    // profile.php included this file
    
    include '../utils/ReservationSys.php';
}else{
    include (__DIR__ . '/../utils/ReservationSys.php');
}


if (session_status() === PHP_SESSION_NONE) {
    session_start();
};

$servername = 'localhost';
$DBusername = 'root';
$DBpassword = '';
$dataBaseName = 'db_654230015';
$table = 'tb_reservation';
$userInfoTable = 'user_info';
$userTable = 'users';

$server = new Server($servername, $DBusername, $DBpassword, $dataBaseName);
$connect = $server->getConnection();

//-----reservation system-------
$reservation = new ReservationSystem($connect);
//-----reservation system-------

//-----user system-------
$user = new UserSystem($connect);
$userInfo = new UserInfoSystem($connect);
//-----user system-------
?>