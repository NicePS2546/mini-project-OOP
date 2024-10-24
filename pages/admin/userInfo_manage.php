<?php
    include_once '../../loginCrud/db_config.php';
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    };
    $default_img = "https://firebasestorage.googleapis.com/v0/b/loginsys-b8d67.appspot.com/o/default_avatar.jpg?alt=media&token=7f437efa-c1af-46c6-a652-6445ea259caf";
    $userInfo = $user->getUserById( $_SESSION['id'] );
    
    $avatar = $userInfo['avatar'] == "default_avatar" ? $default_img : "../../image/upload/".$_SESSION['id']."/". $userInfo['avatar'];

?>