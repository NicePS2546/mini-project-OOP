<?php
require_once '../db_config.php';
include "header.php";
include "footer.php";
include_once "../component/back.php";
$center = "style='text-align:center;'";
$reservation->set_table($table);
$reservations = $reservation->getReservationById($_SESSION['id']);
// echo var_dump($reservations);
    $index = 1;
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Data</title>



</head>

<body>
    <div class="container">
        <h1>Reservation Records</h1>
        <table class="table" id="userTable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>ชื่อผู้เข้าจอง</th>
                    <th>Email ผู้เข้าจอง</th>
                    
                    <th>ประเภทลูกค้า</th>
                    
                    <th>ลงวันที่</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <?php
            
            foreach ($reservations as $reservation) {
                $isMember = "";
                if ($reservation['member'] === 1) {
                    $isMember = "สมาชิก";
                } else {
                    $isMember = "ไม่ใช่สมาชิก";
                }
                ;

                echo "<tbody><tr>
                    <td $center>" . $index++ . "</td>
                    <td $center>" . $reservation['reservedBy'] . "</td>
                    <td $center>" . $reservation['email'] . "</td>
                    <td $center>" . $isMember . "</td>
                    
                    <td $center>" . $reservation['reg_date'] . "</td>
                    ";

                ?>

<td class="d-flex" style="gap:5px;">
                <button type="button" class="btn btn-success btn-sm view-reserved-button"
                data-user-id="<?php echo $reservation['id']; ?>">View</button></td>

                </tr>
                </tbody>
                <?php
            }
            ?>
        </table>
       <?php echo $back_bttn ?>
    </div>
    <script src='https://code.jquery.com/jquery-3.7.1.min.js'></script>
    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // let table = new DataTable('#productTable');
        function intializingDataTable(table) {
            $(table).DataTable();
        };

        intializingDataTable('#userTable');


    </script>
   
    

</body>
<!-- Modal สําหรับแสดงข้อมูลสมาชิก -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js
"></script>
<div class="modal fade" id="reservedModal" tabindex="-1" arialabelledby="memberModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="memberModalLabel">รายละเอียดคอนเสิร์ต</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex flex-column">
                <!-- แสดงรายละเอียดข้อมูลใน Modal -->
                <p><strong>จองโดย:</strong> <span id="reserved-name"></span>
                </p>
                <p><strong>Email:</strong> <span id="reserved-email"></span></p>
                <p><strong>จำนวนวันที่จอง:</strong> <span id="reserved-day"></span></p>
                
                <p><strong>จำนวนผู้เข้าพัก:</strong> <span id="reserved-people"></span></p>
                <p><strong>ประเภทห้อง:</strong> <span id="reserved-room"></span></p>
                <p><strong>ประเภทลูกค้า:</strong> <span id="reserved-member"></span></p>
                <p><strong>ราคา:</strong> <span id="reserved-price"></span></p>
                <p><strong>ภาษี:</strong> <span id="reserved-tax"></span></p>
                <p><strong>รวมเงินที่ต้องจ่าย:</strong> <span id="reserved-total"></span></p>
                <p><strong>วันที่จอง:</strong> <span id="reserved-reg"></span></p>
                
                
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
        $('.view-reserved-button').on('click', function () {
            const userId = $(this).data('user-id'); // ดึงค่า data-user-id จากปุ่ มที่คลิก
            // ส่ง AJAX ไปที่ view_get_member_dt.php เพื่อดึงข้อมูลสมาชิก
            $.ajax({ // ส่ง AJAX
                url: 'view_get.php', // ไฟล์ที่จะส่งไป
                type: 'POST', // ใช้เมธอด POST
                data: { // ส่งข้อมูลไปด้วย
                    id: userId
                },
                success: function (response) { // ถ้าสําเร็จ
                    // นําข้อมูลที่ได้มาแสดงใน Modal
                    const reserved = JSON.parse(response); // แปลงข้อความ JSON ให้กลายเป็นObject
                    console.log(reserved);
                    let roomType = reserved.roomType == 'normal' ? 'ปกติ' : (reserved.roomType == 'deluxe' ? 'Deluxe' : 'First Class') ;
                    let member = reserved.member == 1 ? 'เป็นสมาชิก' :'ไม่ได้เป็นสมาชิก'                    
                    $('#reserved-name').text(reserved.reservedBy); // แสดงข้อมูลใน Modal โดยใช้ ID ของแต่ละข้อมูล
                    $('#reserved-email').text(reserved.email);
                    $('#reserved-day').text(reserved.dayAmount);
                    $('#reserved-people').text(reserved.peopleAmount);
                    $('#reserved-room').text(roomType);
                    $('#reserved-member').text(member);
                    $('#reserved-price').text(reserved.price+" บาท");
                    $('#reserved-tax').text(reserved.taxFee+" บาท");
                    $('#reserved-total').text(reserved.total+" บาท");
                    $('#reserved-reg').text(reserved.reg_date);
                    
                    
                   
                    $('#reservedModal').modal('show'); // แสดง Modal
                },
                error: function () {
                    alert('ไม่สามารถดึงข้อมูลได้');
                }
            });
        });
    });
</script>
</html>