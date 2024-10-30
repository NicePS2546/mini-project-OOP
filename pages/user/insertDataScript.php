<?php
    
    include '../db_config.php';
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        $name = $_POST['reservedBy'];
        $roomType = $_POST['roomType'];
        $email = $_POST['email'];
        $dayAmount = $_POST['dayAmount'];
        $peopleAmount = $_POST['peopleAmount'];
        $isMember = filter_var($_POST['member'], FILTER_VALIDATE_BOOLEAN);
        $price = 0;

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
            window.location = "insertData.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
            
        });
            }, 1000);
            </script>';
exit();
    }
        if($roomType === 'normal'){
            $price = 850;
        }else if($roomType === 'deluxe'){
            $price = 1750;
        }else{
            $price = 3500;
        };
        
        $reservation->set_data($table,$dayAmount,$price,$isMember,$name,$email,$peopleAmount,$roomType,$_SESSION['id']);
        $result = $reservation->reservation();
        
       if ($result['status']) {
        
        echo '<script>
                    setTimeout(function() {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "เพิ่มข้อมูลสําเร็จ",
                            showConfirmButton: true,
                            // timer: 1500
                        }).then(function() {
                        window.location = "insertData.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
                    });
                        }, 1000);
                        </script>';
    } else if($result['status'] == false){
        echo '<script>
        setTimeout(function() {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "'.$result['message'].'",
                    showConfirmButton: true,
                    // timer: 1500
                    }).then(function() {
                window.location = "insertData.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
                    });
                }, 1000);
            </script>';
    }
        
    }
    ?>

