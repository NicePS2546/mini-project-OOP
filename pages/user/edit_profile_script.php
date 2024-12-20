<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Ensure the session is started
}
include "db_config.php";



// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    $file = $_FILES['picture'];
    $id = $_POST['id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];

    $targetDir = "../../image/upload/$id/";
    $upload_picture = true;
    $user->set_table($userInfoTable);
    $getUser = $user->getRowById($id);
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif'); // ประเภทไฟล์ที่อนุญาต
    $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);


    // Check if the file is uploaded
    if (isset($file) && $file['error'] == UPLOAD_ERR_OK) {
        if (in_array($fileType, $allowTypes)) { // ตรวจสอบวา่ อยใู่ นประเภทที่อนุญาตหรือไม่
        // Call the upload function if a file is uploaded
        $userInfo->set_table($userInfoTable);
        $upload_picture = $userInfo->uploadPic($file, $targetDir,$id);
        if ($getUser && !empty($getUser['avatar'])) {
            $oldFile = $targetDir . $getUser['avatar'];
            
            if($upload_picture && file_exists($oldFile)){
                unlink($oldFile); // Deletes the old file
            };
        }
    }else{
        echo '<script>
    setTimeout(function() {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "ประเภทไฟล์ไม่รองรับ",
                showConfirmButton: true,
                // timer: 1500
                }).then(function() {
            window.location = "edit_profile.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
                });
            }, 1000);
        </script>';
        exit();
    }
}
    $userInfo->set_table($userInfoTable);
    $update = $userInfo->update_userInfo('users',$fname,$lname,$email,$id);
    
    
    if ($upload_picture && $update) {
        $user->set_table($userInfoTable);
        $getUser = $user->getRowById($id);
        $fullname = ((isset($getUser['fname']) && $getUser['fname'] != "ยังไม่ได้ตั้ง") && (isset($getUser['lname']) && $getUser['lname'] != "ยังไม่ได้ตั้ง"))
                ? $getUser['fname'] . " " . $getUser['lname']
                : "ยังไม่ได้ตั้งชื่อ";
        $_SESSION['fullname'] = $fullname;
        
        echo '<script>
                setTimeout(function() {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "แก้ไขสำเร็จ",
                        showConfirmButton: true,
                        // timer: 1500
                    }).then(function() {
                    window.location = "profile.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
                    
                });
                    }, 1000);
                    </script>';
        exit();
    } else {
        echo '<script>
    setTimeout(function() {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "เกิดข้อผิดพลาด",
                showConfirmButton: true,
                // timer: 1500
                }).then(function() {
            window.location = "edit_profile.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
                });
            }, 1000);
        </script>';
        exit();
    }
} else {
    echo "Invalid request.";
}
?>