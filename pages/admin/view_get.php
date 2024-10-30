<?php
require_once 'db_config.php';
// ตรวจสอบวาได้รับค ่ ่า u_id จาก POST หรือไม่
if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    // สร้าง SQL เพื่อดึงข้อมูลจากสองตาราง
    $user = $user->getUserById($id);
    
    // ส่งข้อมูลกลับในรูปแบบ JSON
    if ($user) { // ถ้าพบข้อมูล
        echo json_encode($user); // ส่งข้อมูลกลับในรูปแบบ JSON
    } else {
        echo json_encode(['error' => 'Concert not found']);
    }
}else{
    echo '<script>console.log("No ID")</script>';
}
?>