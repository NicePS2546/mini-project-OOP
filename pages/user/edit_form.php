<?php
include_once "header.php";
include "footer.php";
include_once "db_config.php";



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $reservation = $reservation->getSole($id);
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

        ?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Document</title>
            <link rel="styleSheet" href="../../css/custom.css">
        </head>

        <body>

            <div class="form-body form-padding">
                <div class="row">

                    <div class="form-holder">
                        <div class="form-content">
                            <div class="form-items">
                                <h3>แก้ไชรายละเอียด</h3>
                                <p>ใส่รายละเอียดด้านล่าง</p>
                                <form action="edit_script.php" method="post" class="requires-validation" novalidate>
                                    <input type="hidden" name="id" value="<?php echo $id ?>">
                                    <div class="col-md-12">
                                        <input class="form-control" type="text" name="reservedBy"
                                            value='<?php echo $reservation['reservedBy']; ?>' readonly placeholder="ชื่อผู้เข้าจอง"
                                            required>
                                        <div class="invalid-feedback">โปรดใส่ชื่อผู้เข้าจองก่อนกดยืนยัน</div>
                                    </div>

                                    <div class="col-md-12">
                                        <input class="form-control" type="email" value="<?php echo $reservation['email']; ?>"
                                            name="email" placeholder="Email ผู้เข้าจอง" required>
                                        <div class="invalid-feedback">โปรดใส่อีเมลล์ผู้เข้าจองก่อนกดยืนยัน</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="number" name="dayAmount"
                                            value="<?php echo $reservation['dayAmount']; ?>"
                                            placeholder="โปรดใส่จำนวนวันที่เข้าพัก" required>
                                        <div class="invalid-feedback">โปรดใส่จำนวนวันที่เข้าพักก่อนกดยืนยัน</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <input class="form-control" type="number" name="peopleAmount"
                                            value="<?php echo $reservation['peopleAmount']; ?>" placeholder="จำนวนผู้เข้าพัก"
                                            required>
                                        <div class="invalid-feedback">จำเป็นต้องใส่จำนวนผู้เข้าพัก</div>
                                    </div>

                                    <div class="col-md-12">
                                        <select name="roomType" class="form-select mt-3" required>
                                            <option selected value="<?php $reservation['roomType'] ?>">
                                                <?php echo $reservation['roomType'] == 'normal' ? 'ห้องปกติ' : ($reservation['roomType'] == 'deluxe' ? 'ห้อง Deluxe' : 'ห้อง First Class'); ?>
                                            </option>
                                            <option value="normal">ห้องปกติ</option>
                                            <option value="deluxe">ห้อง Deluxe</option>
                                            <option value="firstClass">ห้อง First Class</option>
                                        </select>
                                        <div class="invalid-feedback">โปรดเลือกห้องที่ท่านต้องการเข้าพัก</div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <label class="mb-3 mr-1" for="member">สมาชิก: </label>

                                        <input type="radio" class="btn-check" <?php echo $reservation['member'] == 0 ? '' : 'checked'; ?> name="member" id="true" value="true" autocomplete="off" required>
                                        <label class="btn btn-sm btn-outline-secondary" for="true">เป็นสมาชิก</label>

                                        <input type="radio" class="btn-check" name="member" <?php echo $reservation['member'] == 1 ? '' : 'checked'; ?> value="false" id="false" autocomplete="off" required>
                                        <label class="btn btn-sm btn-outline-secondary" for="false">ไม่ได้เป็นสมาชิก</label>

                                        <div class="invalid-feedback mv-up">โปรดเลือกว่าท่านเป็นสมาชิกหรือไม่</div>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                        <label class="form-check-label">ฉันยืนยันว่าข้อมูลถูกต้อง</label>
                                        <div class="invalid-feedback">โปรดยืนยันข้อมูลว่าถูกต้องทุกประการณ์</div>
                                    </div>
                                    <div class="form-button mt-3">
                                        <div class="d-flex justify-content-between">
                                            <button id="submit" type="submit" class="btn btn-primary">ตกลง</button>
                                            <button type="button" class="btn btn-primary"><a
                                                    href="../index.php">ย้อนกลับ</a></button>
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <script>
                (function () {
                    'use strict'
                    const forms = document.querySelectorAll('.requires-validation')
                    Array.from(forms)
                        .forEach(function (form) {
                            form.addEventListener('submit', function (event) {
                                if (!form.checkValidity()) {
                                    event.preventDefault()
                                    event.stopPropagation()
                                }

                                form.classList.add('was-validated')
                            }, false)
                        })
                })()

            </script>
        </body>

        </html>
        <?php
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
                window.location = "show_table.php"; // Redirect to.. ปรับแก ้ชอไฟล์ตามที่ต้องการให ้ไป ื่
                    });
                }, 1000);
            </script>';
    }
    ;
}


?>