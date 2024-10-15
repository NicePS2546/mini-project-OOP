<?php
require_once '../../loginCrud/db_config.php';
include 'header.php';

$center = "style='text-align:center;'";

$users = $user->getAll( $table,$userInfoTable,'id','id');

$p_url = $_GET['p_url'] ?? null;

?>

<!DOCTYPE html>
<html>

<head>
    <title>View Data</title>



</head>

<body>
    <div class="container">
        <h1>User Table</h1>
        <table class="table" id="userTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Email</th>
                    <th>Avatar</th>
                    <th>Role</th>
                    <th>Reg_Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php

            foreach ($users as $user) {
                $default_img = "https://firebasestorage.googleapis.com/v0/b/loginsys-b8d67.appspot.com/o/default_avatar.jpg?alt=media&token=7f437efa-c1af-46c6-a652-6445ea259caf";
                $avatar = $user['avatar'] == "default_avatar" ? $default_img : "../../image/upload/".$user['id']."/" . $user['avatar'];
                $role = "";
                if ($user['role'] === 1) {
                    $role = "Admin";
                } else {
                    $role = "User";
                };

                echo "<tbody><tr>
                    <td $center>" . $user['id'] . "</td>
                    <td $center>" . $user['username'] . "</td>
                    <td $center>" . $user['password'] . "</td>
                    <td $center>" . $user['email'] . "</td>
                    <td $center><img heigh='100px' width='100px' class='img-fluid rounded' src='$avatar'></td>
                    <td $center>$role</td>
                    <td $center>" . $user['reg_date'] . "</td>
                    ";

                ?>

                <td>
                    <div class="d-flex gap-2">
                        <form action="update_user_data.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <input type="hidden" name="p_url" value="<?php echo htmlspecialchars($p_url); ?>">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                        <form action="delete_data.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <!-- <input type="submit" name="delete" value="Delete" class="btn btn-danger btn-sm"> -->
                            <button type="button" class="btn btn-danger delete-button"
                                data-user-id="<?php echo $user['id']; ?>">Delete</button>
                        </form>
                    </div>
                </td>

                </tr>
                </tbody>
                <?php
            }
            ?>
        </table>
        <div>
            <a class="btn btn-secondary" href="../index.php">ย้อนกลับไปหน้าหลัก</a>
        </div>
    </div>
    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // let table = new DataTable('#productTable');
        function intializingDataTable(table) {
            $(table).DataTable();
        };

        intializingDataTable('#userTable');


    </script>
    <script>
        // ฟังก์ชันสาหรับแสดงกล่องยืนยัน ํ SweetAlert2
        function showDeleteConfirmation(id) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: 'คุณจะไม่สามารถเรียกคืนข้อมูลกลับได้!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ลบ',
                cancelButtonText: 'ยกเลิก',
            }).then((result) => {
                if (result.isConfirmed) {
                    // หากผู้ใชยืนยัน ให ้ส ้ งค่าฟอร์มไปยัง ่ delete.php เพื่อลบข ้อมูล
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'delete_data.php';
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'id';
                    input.value = id;
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
        // แนบตัวตรวจจับเหตุการณ์คลิกกับองค์ปุ่ มลบทั้งหมดที่มีคลาส delete-button
        const deleteButtons = document.querySelectorAll('.delete-button');
        deleteButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const get_id = button.getAttribute('data-user-id');
                showDeleteConfirmation(get_id);
            });
        });
    </script>

</body>

</html>