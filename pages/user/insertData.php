<?php
    include "header.php";
    include "footer.php";
    require_once "db_config.php";
    $user->set_table($userInfoTable);
    $userInfo = $user->getRowById($_SESSION['id']);
    $fullname = $userInfo['fname']." ".$userInfo['lname'];
    
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
                        <h3>ระบบจองที่พัก</h3>
                        <p>ใส่รายละเอียดด้านล่าง</p>
                        <form action="insertDataScript.php" method="post" class="requires-validation" novalidate>

                            <div class="col-md-12">
                                <input class="form-control" type="text" name="reservedBy" value="<?php echo $fullname ?>" placeholder="ชื่อผู้เข้าจอง"
                                    readonly>
                                <div class="invalid-feedback">โปรดใส่ชื่อผู้เข้าจองก่อนกดยืนยัน</div>
                            </div>

                            <div class="col-md-12">
                                <input class="form-control" type="email" name="email" placeholder="Email ผู้เข้าจอง"
                                    value="<?php echo $userInfo['email'] ?>" readonly>
                                <div class="invalid-feedback">โปรดใส่อีเมลล์ผู้เข้าจองก่อนกดยืนยัน</div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <input class="form-control" type="number" name="dayAmount"
                                    placeholder="โปรดใส่จำนวนวันที่เข้าพัก" required>
                                <div class="invalid-feedback">โปรดใส่จำนวนวันที่เข้าพักก่อนกดยืนยัน</div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <input class="form-control" type="number" name="peopleAmount"
                                    placeholder="จำนวนผู้เข้าพัก" required>
                                <div class="invalid-feedback">จำเป็นต้องใส่จำนวนผู้เข้าพัก</div>
                            </div>

                            <div class="col-md-12">
                                <select name="roomType" class="form-select mt-3" required>
                                    <option selected disabled value="">ประเภทห้องที่ต้องการ</option>
                                    <option value="normal">ห้องปกติ</option>
                                    <option value="deluxe">ห้อง Deluxe</option>
                                    <option value="firstClass">ห้อง First Class</option>
                                </select>
                                <div class="invalid-feedback">โปรดเลือกห้องที่ท่านต้องการเข้าพัก</div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <label class="mb-3 mr-1" for="member">สมาชิก: </label>

                                <input type="radio" class="btn-check" name="member" id="true" value="true"
                                    autocomplete="off" required>
                                <label class="btn btn-sm btn-outline-secondary" for="true">เป็นสมาชิก</label>

                                <input type="radio" class="btn-check" name="member" value="false" id="false"
                                    autocomplete="off" required>
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