<?php
    if(session_status()==PHP_SESSION_NONE)session_start();
    include '../db_config.php';
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        $name = $_POST['name'];
        $title = $_POST['title'];
        $message = $_POST['message'];

        $result = $reservation->feedback($title,$message,$_SESSION['id'],$name);
       
        
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
                        window.location = "add_feedback.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
                    });
                        }, 1000);
                        </script>';
    } else{
        echo '<script>
        setTimeout(function() {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "'.$result['message'].'",
                    showConfirmButton: true,
                    // timer: 1500
                    }).then(function() {
                window.location = "add_feedback.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
                    });
                }, 1000);
            </script>';
    }
        
    }
    ?>

