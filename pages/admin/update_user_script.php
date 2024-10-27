<?php
    require_once "../../loginCrud/db_config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    $id = $_POST['id'];
   
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $role = floatval($_POST['role']);
    $email = $_POST['email'];
    $file = $_FILES['picture'];
    $targetDir = "../../image/upload/$id/";
    $upload_picture = true;
    $user->set_table($userInfoTable);
    $getUser = $user->getRowById($id);
    $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);
    // Check if the file is uploaded
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif'); // ประเภทไฟล์ที่อนุญาต
    if (isset($file) && $file['error'] == UPLOAD_ERR_OK) {
        if (in_array($fileType, $allowTypes)) { // ตรวจสอบวา่ อยใู่ นประเภทที่อนุญาตหรือไม่
        $userInfo->set_table($userInfoTable);
        $upload_picture = $userInfo->uploadPic($file, $targetDir,$id);
        // Call the upload function if a file is uploaded
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
            window.location = "update_user_form.php?id='.urlencode($id).'"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
                });
            }, 1000);
        </script>';
        exit();
    }
       
    }
    $userInfo->set_table($userInfoTable);
    $update = $userInfo->update_userInfo('users',$fname,$lname,$email,$id);
    
    
    if ($upload_picture && $update) {
        echo '<script>
                    setTimeout(function() {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "แก้ไขข้อมูลสมาชิกสําเร็จ",
                            showConfirmButton: true,
                            // timer: 1500
                        }).then(function() {
                        window.location = "show_table_user.php"; // Redirect to with p_url value
                    });
                        }, 1000);
                        </script>';
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
                window.location = "update_user_form.php?id='.urlencode($id).'"; // Redirect to with p_url value
                    });
                }, 1000);
            </script>';
    }
}


?>