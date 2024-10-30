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





$currentUrl = $_SERVER['REQUEST_URI'];
// Determine the avatar path based on the URL path
if (strpos($currentUrl, 'user') !== false) {
    // If the URL contains 'user', adjust the path for user directory
    $avatar = $user['avatar'] == "default_avatar" 
        ? $default_img 
        : "../../image/upload/" . $_SESSION['id'] . "/" . $user['avatar'];
} else {
    // If not in the 'user' context, use a different path
    $avatar = $user['avatar'] == "default_avatar" 
        ? $default_img 
        : "../image/upload/" . $_SESSION['id'] . "/" . $user['avatar'];
}
$fullname = ((isset($user['fname']) && $user['fname'] != "ยังไม่ได้ตั้ง") && (isset($user['lname']) && $user['lname'] != "ยังไม่ได้ตั้ง"))
    ? $user['fname'] . " " . $user['lname']
    : "ยังไม่ได้ตั้งชื่อ";



?>