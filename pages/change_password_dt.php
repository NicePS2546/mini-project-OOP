<?php

include "user_manage.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Edit</title>
    <style>
        .gradient-custom {
            /* fallback for old browsers */
            background: #f6d365;

            /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
        }

        .opacity-input {
            width: 70%;
            height: 40px;
            border: 1;
            background: rgba(255, 255, 255, 0.1);
            color: #000;
            padding-left: 0 !important;
            text-indent: 20px;
            border-bottom-left-radius: 8px;
            border-bottom-right-radius: 8px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;

        }
    </style>
</head>

<body>
    <form action="change_password_script.php" method="post" onsubmit="return validatePassword()">
        <section class="vh-100" style="background-color: #f4f5f7;">
            <div class="container py-5 h-75">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col col-lg-6 mb-4 mb-lg-0">
                        <div class="card mb-3" style="border-radius: .5rem;">
                            <div class="row g-0">
                                <div class="col-md-4 gradient-custom text-center text-white"
                                    style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                    <img src="<?php echo $avatar ?>" alt="Avatar" class="img-fluid rounded my-5"
                                        style="width: 80px;" />
                                    <input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>">


                                    <p><?php echo $fullname ?></p>
                                    <p><?php echo $user['role'] == 1 ? "Admin" : "User" ?></p>
                                    <i class="far fa-edit mb-5"></i>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body p-4">
                                        <h6>แก้ไขรหัสผ่าน</h6>
                                        <hr class="mt-0 mb-4">
                                        <div class="row pt-1">
                                            <div class="col-8 mb-3">
                                                <h6>รหัสผ่านเก่า</h6>
                                                <input class="form-control opacity-input" name="current_password"
                                                    id="current_password" style="text-align: start; width:300px;"
                                                    type="password" required>
                                            </div>
                                            <div class="col-8 mb-3">
                                                <h6>รหัสผ่านใหม่</h6>
                                                <input class="form-control opacity-input" name="new_password"
                                                    id="new_password" style="text-align: start; width:300px;"
                                                    type="password" required>
                                                <small id="new_password_error" style="color: red;"></small>
                                            </div>
                                            <div class="col-8 mb-3">
                                                <h6>ยืนยันรหัสผ่าน</h6>
                                                <input class="form-control opacity-input" name="confirm_password"
                                                    style="text-align: start; width:300px;" id="confirm_password"
                                                    type="password" required>
                                                    <small id="confirm_password_error" style="color: red;"></small>
                                            </div>
                                        </div>

                                        <hr class="mt-0 mb-4">
                                        <div class="row pt-1">
                                            <button type="submit" class="btn btn-primary">บันทึก</button>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="profile.php" class="btn btn-primary">Back</a>

                    </div>
                </div>
            </div>

            </div>

        </section>
    </form>
</body>
<script>
    function validatePassword() {
        let isValid = true;
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        const newPasswordError = document.getElementById('new_password_error');
        const confirmPasswordError = document.getElementById('confirm_password_error');

        const password = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        // Reset error messages and input styles
        newPasswordError.innerText = '';
        confirmPasswordError.innerText = '';

        newPasswordInput.style.borderColor = '';
        confirmPasswordInput.style.borderColor = '';

        // Define password criteria
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        // Validate new password criteria
        if (!password.match(passwordRegex)) {
            newPasswordError.innerText = "รหัสผ่านต้องประกอบด้วยอย่างน้อย 8 ตัวอักษร, มีตัวอักษรพิมพ์ใหญ่, พิมพ์เล็ก, ตัวเลข และสัญลักษณ์พิเศษ";
            newPasswordInput.style.borderColor = 'red';
            isValid = false;
        }

        // Validate password match
        if (password !== confirmPassword) {
            confirmPasswordError.innerText = "รหัสผ่านใหม่ไม่ตรงกับการยืนยัน";
            confirmPasswordInput.style.borderColor = 'red';
            isValid = false;
        }

        return isValid;
    }
</script>

</html>