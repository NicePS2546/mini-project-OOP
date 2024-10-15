<?php
    require_once "../../loginCrud/db_config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $p_url = $_POST['p_url'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $role = floatval($_POST['role']);
    $email = $_POST['email'];
    $file = $_FILES['picture'];
    $targetDir = "../../image/upload/$id/";
    $upload_picture = true;
    $user->set_table($userInfoTable);
    $getUser = $user->getRowById($id);
    // Check if the file is uploaded
    if (isset($file) && $file['error'] == UPLOAD_ERR_OK) {
        // Call the upload function if a file is uploaded
        if ($getUser && !empty($getUser['avatar'])) {
            $oldFile = $targetDir . $getUser['avatar'];
            $userInfo->set_table($userInfoTable);
            $upload_picture = $userInfo->uploadPic($file, $targetDir,$id);
            if($upload_picture && file_exists($oldFile)){
                unlink($oldFile); // Deletes the old file
            };
        }
       
    }
    $userInfo->set_table($userInfoTable);
    $update = $userInfo->update_userInfo('users',$fname,$lname,$email,$id);
    
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
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
                        window.location = "'.$p_url.'?p_url='.urlencode($p_url).'"; // Redirect to with p_url value
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
                window.location = "'.$p_url.'?p_url='.urlencode($p_url).'"; // Redirect to with p_url value
                    });
                }, 1000);
            </script>';
    }
}


?>