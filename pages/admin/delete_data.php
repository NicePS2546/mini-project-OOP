<?php
include_once '../../loginCrud/db_config.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $callbacks = $auth->deleteUser('users','user_info',$id);
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    if ($callbacks) {
        echo '<script>
                    setTimeout(function() {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "ลบข้อมูลสําเร็จ",
                            showConfirmButton: true,
                            // timer: 1500
                        }).then(function() {
                      history.back()
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
                history.back()
                    });
                }, 1000);
            </script>';
    }
} else {
    echo '<script>
        setTimeout(function() {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "เกิดข้อผิดพลาด",
                    text: "ไม่มี ID ส่งมา",
                    showConfirmButton: true,
                    // timer: 1500
                    }).then(function() {
                history.back()
                    });
                }, 1000);
            </script>';
}
?>