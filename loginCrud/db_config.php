<?php
// include "../utils/Server.php";
include __DIR__ . "/../utils/makeOver.php";

$servername = 'localhost';
$DBusername = 'root';
$DBpassword = '';
$dataBaseName = 'db_654230015';
$table = 'users';
$userInfoTable = 'user_info';

$server = new Server($servername, $DBusername, $DBpassword, $dataBaseName);
$connect = $server->getConnection();

$auth = new AuthSystem($connect);
$user = new UserSystem($connect);
$userInfo = new UserInfoSystem($connect);
?>