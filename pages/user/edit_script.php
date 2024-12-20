<?php

include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $id = $_POST['id'];
    $name = $_POST['reservedBy'];
    $roomType = $_POST['roomType'];
    $email = $_POST['email'];
    $dayAmount = $_POST['dayAmount'];
    $peopleAmount = $_POST['peopleAmount'];
    $isMember = filter_var($_POST['member'], FILTER_VALIDATE_BOOLEAN);
    $price = 0;
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    if($peopleAmount >= 6){
        echo '<script>
        setTimeout(function() {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "จำนวณผู้เข้าพักมากกกว่าที่กำหนดสูงสุด 5 คน",
                showConfirmButton: true,
                // timer: 1500
            }).then(function() {
            window.location = "edit_form.php?id='.urlencode($id).'"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
            
        });
            }, 1000);
            </script>';
exit();
    }
    
    if ($roomType === 'normal') {
        $price = 850;
    } else if ($roomType === 'deluxe') {
        $price = 1750;
    } else {
        $price = 3500;
    };
    $user->set_table($userInfoTable);
    
    
    $reservation->set_data($table,$dayAmount,$price,$isMember,$name,$email,$peopleAmount,$roomType,$id);
    $callback = $reservation->updateById($id);

    if ($callback) {
        echo '<script>
                    setTimeout(function() {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "แก้ไขข้อมูลสําเร็จ",
                            showConfirmButton: true,
                            // timer: 1500
                        }).then(function() {
                        window.location = "../admin/show_table.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
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
                window.location = "edit_form.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
                    });
                }, 1000);
            </script>';
    }

}
?>