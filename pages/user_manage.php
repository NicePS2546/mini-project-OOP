<?php
require_once "db_config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
;


// $user_data = $user_DB->getSole($user_conn, 'users', $_SESSION['id']);
$default_img = "https://firebasestorage.googleapis.com/v0/b/loginsys-b8d67.appspot.com/o/default_avatar.jpg?alt=media&token=7f437efa-c1af-46c6-a652-6445ea259caf";
$user->set_table($userInfoTable);
$user = $user->getRowById($_SESSION['id']);
$avatar = $user['avatar'] == "default_avatar" ? $default_img : "../image/upload/".$_SESSION['id']."/" . $user['avatar'];
$backtrace = debug_backtrace();

// Get the file that included db_config.php
$callerFile = isset($backtrace[0]['file']) ? $backtrace[0]['file'] : '';

// Check if profile.php is the file that included db_config.php
if (strpos($callerFile, '../../pages/index.php') !== false) {
    // If the caller is from the '../../pages' directory, adjust the path.
    $avatar = $user['avatar'] == "default_avatar" ? $default_img : "../image/upload/" . $_SESSION['id'] . "/" . $user['avatar'];
}else{
    $avatar = $user['avatar'] == "default_avatar" ? $default_img : "../../image/upload/".$_SESSION['id']."/" . $user['avatar'];
}
$fullname = ((isset($user['fname']) && $user['fname'] != "ยังไม่ได้ตั้ง") && (isset($user['lname']) && $user['lname'] != "ยังไม่ได้ตั้ง"))
    ? $user['fname'] . " " . $user['lname']
    : "ยังไม่ได้ตั้งชื่อ";



?>