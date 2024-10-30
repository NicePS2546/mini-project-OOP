<?php
require_once 'db_config.php';
// ตรวจสอบวาได้รับค ่ ่า u_id จาก POST หรือไม่
if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    // สร้าง SQL เพื่อดึงข้อมูลจากสองตาราง
    $feedback = $reservation->get_feedback_by_id( $id );
    
    // ส่งข้อมูลกลับในรูปแบบ JSON
    if ($feedback) { // ถ้าพบข้อมูล
        echo json_encode($feedback); // ส่งข้อมูลกลับในรูปแบบ JSON
    } else {
        echo "<script>console.log('".$id."aasdsad')</script>";
        echo json_encode(['error' => 'Concert not found Id ='.$id.'']);
    }
}else{
    echo '<script>console.log("No ID")</script>';
}
?>