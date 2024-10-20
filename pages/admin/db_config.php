<?php

include_once '../../utils/makeOver.php';



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