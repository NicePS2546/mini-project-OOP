<?php
include "../makeOver.php";
$servername = 'localhost';
$DBusername = 'root';
$DBpassword = '';
$dataBaseName = 'logindb';
$table = 'users';
$userInfoTable = 'user_info';
$reservDbName = "db_654230015";

$reservationDB = new Server($servername,$DBusername,$DBpassword,$reservDbName);
$reservConnection = $reservationDB->getConnection();

$reservation = new ReservationSystem($reservConnection);
?>