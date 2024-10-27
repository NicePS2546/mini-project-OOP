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
<style>
    .message:focus,
    .message:hover{
        border: 0 !important;
        background-color: white !important;
        color: black !important;
    }
</style>
<body>

    <div class="form-body form-padding">
        <div class="row">

            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>ระบบ Feedback</h3>
                        <p>ใส่รายละเอียดด้านล่าง</p>
                        <form action="feedback_script.php" method="post" class="requires-validation" novalidate>

                            <div class="col-md-12">
                                <input class="form-control" type="text" name="name" value="<?php echo $fullname ?>" placeholder="ชื่อผู้เข้าจอง"
                                    readonly>
                                <div class="invalid-feedback">โปรดใส่ชื่อผู้เข้าจองก่อนกดยืนยัน</div>
                            </div>

                           

                            <div class="col-md-12 mt-3">
                                <input class="form-control" type="text" name="title"
                                    placeholder="โปรดใส่หัวข้อเรื่องที่คุณต้องการแจ้งให้เราทราบ" required>
                                <div class="invalid-feedback">โปรดใส่หัวข้อเรื่องที่คุณต้องการแจ้งให้เราทราบ</div>
                            </div>

                            <div class="col-md-12 mt-3">
                                <textarea class="form-control message" type="text" name="message" placeholder="โปรดใส่ข้อติชมที่อยากแจ้งให้เราทราบ"></textarea>
                                <div class="invalid-feedback">โปรดใส่ข้อติชมที่อยากแจ้งให้เราทราบ</div>
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