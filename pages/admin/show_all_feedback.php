<?php
require_once 'db_config.php';
include 'header.php';

$center = "style='text-align:center;'";

$feedbacks = $reservation->getAll_Feedback();
$index = 1;


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
                    <th <?php echo $center ?>>No.</th>
                    <th <?php echo $center ?>>Title</th>
                    <th <?php echo $center ?>>Register Date</th>
                    <th <?php echo $center ?>>Action</th>
                </tr>
            </thead>
            <?php

            foreach ($feedbacks as $feedback) {
                

                echo "<tbody><tr>
                    <td $center>" . $index++. "</td>
                    <td $center>" . $feedback['title'] . "</td>
                    <td $center>" . $feedback['reg_date'] . "</td>
                    ";

                ?>

                <td>
                    <div class="d-flex gap-2" style="justify-content:center;">
                    <button type="button" class="btn btn-success btn-sm view-member-button"
                    data-user-id="<?php echo $feedback['id']; ?>">View</button>
                        
                        <form action="delete_feedback.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $feedback['id']; ?>">
                            <!-- <input type="submit" name="delete" value="Delete" class="btn btn-danger btn-sm"> -->
                            <button type="button" class="btn btn-danger delete-button"
                                data-user-id="<?php echo $feedback['id']; ?>">Delete</button>
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
                    form.action = 'delete_feedback.php';
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
<!-- Modal สําหรับแสดงข้อมูลสมาชิก -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js
"></script>
<div class="modal fade" id="memberModal" tabindex="-1" arialabelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">รายละเอียดสมาชิก</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column">
                <!-- แสดงรายละเอียดข้อมูลใน Modal -->
                <p><strong>Title:</strong> <span id="modal-title"></span>
                    
                </p>
                <p><strong>Message:</strong> <span id="modal-message"></span></p>
                <p><strong>Submit By:</strong> <span id="modal-name"></span></p>
                <p><strong>Register Date:</strong> <span id="modal-reg"></span></p>
                <p><strong>User ID:</strong> <span id="modal-user"></span></p>
                <p><strong>ID:</strong><span id="modal-id"></span></p>
                <!-- รูปถ่าย -->
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // เมื่อคลิกปุ่ ม View
        $('.view-member-button').on('click', function () {
            const userId = $(this).data('user-id'); // ดึงค่า data-user-id จากปุ่ มที่คลิก
            // ส่ง AJAX ไปที่ view_get_member_dt.php เพื่อดึงข้อมูลสมาชิก
            $.ajax({ // ส่ง AJAX
                url: 'view_get_feedback.php', // ไฟล์ที่จะส่งไป
                type: 'POST', // ใช้เมธอด POST
                data: { // ส่งข้อมูลไปด้วย
                    id: userId
                },
                success: function (response) { // ถ้าสําเร็จ
                    // นําข้อมูลที่ได้มาแสดงใน Modal
                    const feedback = JSON.parse(response); // แปลงข้อความ JSON ให้กลายเป็นObject
                    console.log(feedback);
                    
                    $('#modal-title').text(feedback.title); // แสดงข้อมูลใน Modal โดยใช้ ID ของแต่ละข้อมูล
                    $('#modal-message').text(feedback.message);
                    $('#modal-name').text(feedback.name);
                    $('#modal-reg').text(feedback.reg_date);
                    $('#modal-id').text(feedback.id);
                    $('#modal-user').text(feedback.user_id);
                   
                    $('#memberModal').modal('show'); // แสดง Modal
                },
                error: function () {
                    alert('ไม่สามารถดึงข้อมูลได้');
                }
            });
        });
    });
</script>
</html>