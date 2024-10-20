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
                    <th>จำนวนวันที่เข้าพัก</th>
                    <th>จำนวนผู้เข้าพัก</th>
                    <th>ประเภทห้อง</th>
                    <th>ประเภทลูกค้า</th>
                    <th>ราคา</th>
                    <th>ภาษี</th>
                    <th>รวม</th>
                    <th>ลงวันที่</th>
                    
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
                    <td $center>" . $reservation['dayAmount'] . "</td>
                    <td $center>" . $reservation['peopleAmount'] . "</td>
                    <td $center>" . $reservation['roomType'] . "</td>
                    <td $center>" . $isMember . "</td>
                    <td $center>" . number_format($reservation['price'],0) . "</td>
                    <td $center>" . number_format($reservation['taxFee'],0) . "</td>
                    <td $center>" . number_format($reservation['total'],0) . "</td>
                    <td $center>" . $reservation['reg_date'] . "</td>
                    ";

                ?>

                

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
   
    </script>

</body>

</html>