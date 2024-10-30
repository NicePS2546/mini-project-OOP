<?php
require_once 'db_config.php';
// ตรวจสอบวาได้รับค ่ ่า u_id จาก POST หรือไม่
if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    // สร้าง SQL เพื่อดึงข้อมูลจากสองตาราง
    $reserved = $reservation->getRowById($id);
    $reserved['price'] = number_format($reserved['price'],0);
    $reserved['taxFee'] = number_format($reserved['taxFee'],0);
    $reserved['total'] = number_format($reserved['total'],0);
    // ส่งข้อมูลกลับในรูปแบบ JSON
    if ($reserved) { // ถ้าพบข้อมูล
        echo json_encode($reserved); // ส่งข้อมูลกลับในรูปแบบ JSON
    } else {
        echo "<script>console.log('".$id."aasdsad')</script>";
        echo json_encode(['error' => 'reserved not found Id ='.$id.'']);
    }
}else{
    echo '<script>console.log("No ID")</script>';
}
?>