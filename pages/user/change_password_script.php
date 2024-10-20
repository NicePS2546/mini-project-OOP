<?php
require_once 'db_config.php';
 
if (session_status() === PHP_SESSION_NONE) {
    // ถ้ายังไม่มี session ที่ถูกเปิด
    session_start();
}
 
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $id = $_SESSION['id'];
    $current_password = $_POST['current_password'];
    $new_password     = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
 
    // ตรวจสอบว่ารหัสผ่านใหม่และการยืนยันรหัสผ่านตรงกันหรือไม่
    if ($new_password !== $confirm_password) {
        echo '<script>
            setTimeout(function() {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "รหัสผ่านใหม่ไม่ตรงกับการยืนยัน",
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location = "change_password.php";  
                });
            }, 1000);
        </script>';
        exit();
    }
 
    // ดึงข้อมูลรหัสผ่านเก่าของผู ้ใช้จากฐานข้อมูล
    $user->set_table('users');
    $old_user_pass = $user->getRowById($id);
 
    // ตรวจสอบว่ารหัสผ่านเก่าที่ผู ้ใช้กรอกตรงกับที่อยู ่ในฐานข้อมูลหรือไม่
    if (!password_verify($current_password, $old_user_pass['password'])) {
        echo '<script>
            setTimeout(function() {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "รหัสผ่านเก่าไม่ถูกต้อง",
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location = "change_password.php";  
                });
            }, 1000);
        </script>';
        exit();
    }
    
    // หากผ่านการตรวจสอบทั ้งหมด ให้อัปเดตรหัสผ่านใหม่
    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $callback = $user->changePassword($new_password_hashed,$id);
    // แจ้งผลลัพธ์สําเร็จ
    if($callback){
    echo '<script>
        setTimeout(function() {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "เปลี่ยนรหัสผ่านสําเร็จ",
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location = "../index.php";  
            });
        }, 1000);
    </script>';
    exit();
}
}
?>





