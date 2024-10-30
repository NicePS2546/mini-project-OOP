<?php
require_once 'db_config.php';

if (!empty($_POST['id'])) {
    $id = $_POST['id'];
    // สร้าง SQL เพื่อดึงข้อมูลจากสองตาราง
    $reserved = $reservation->getRowById($id);
    $reserved['price'] = number_format($reserved['price'],0);
    $reserved['taxFee'] = number_format($reserved['taxFee'],0);
    $reserved['total'] = number_format($reserved['total'],0);
    if ($reserved) { // ถ้าพบข้อมูล
        echo json_encode($reserved); // ส่งข้อมูลกลับในรูปแบบ JSON
    } else {
        echo json_encode(['error' => 'reserved not found']);
    }
}else{
    echo '<script>console.log("No ID")</script>';
}
?>