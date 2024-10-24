<?php
include "header.php";
include "footer.php";
require_once '../../loginCrud/db_config.php';


$id = $_POST['id'] ?? $_GET['id'] ?? '';
$getUser = $user->getUserById( $id );
$default_img = "https://firebasestorage.googleapis.com/v0/b/loginsys-b8d67.appspot.com/o/default_avatar.jpg?alt=media&token=7f437efa-c1af-46c6-a652-6445ea259caf";
$avatar = $getUser['avatar'] == "default_avatar" ? $default_img : "../../image/upload/$id/" . $getUser['avatar'];
$fullname = ((isset($getUser['fname']) && $getUser['fname'] != "ยังไม่ได้ตั้ง") && (isset($getUser['lname']) && $getUser['lname'] != "ยังไม่ได้ตั้ง"))
    ? $getUser['fname'] . " " . $getUser['lname']
    : "ยังไม่ได้ตั้งชื่อ";

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
    <form action="update_user_script.php" method="post" enctype="multipart/form-data">
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
                                    <input type="hidden" name="id" value="<?php echo $id ?>">
                                   

                                    <p><?php echo $fullname ?></p>
                                    <p><?php echo $getUser['role'] == 1 ? "Admin" : "User" ?></p>
                                    <i class="far fa-edit mb-5"></i>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body p-4">
                                        <h6>ข้อมูลโปรไฟล์</h6>
                                        <hr class="mt-0 mb-4">
                                        <div class="row pt-1">
                                            <div class="col-8 mb-3">
                                                <h6>อีเมลล์</h6>
                                                <input class="form-control opacity-input" name="email"
                                                    style="text-align: start; width:300px;"
                                                    value="<?php echo $getUser['email'] ?>">
                                            </div>
                                            <div class="col-8 mb-3" style="display: flex; gap:50px; margin-left:12px;">
                                                <div class="row">
                                                    <h6>ชื่อจริง</h6>
                                                    <input class="form-control opacity-input" name="fname"
                                                        style="text-align: start; width:120px;"
                                                        value="<?php echo $getUser['fname'] ?>">
                                                </div>
                                                <div class="row">
                                                    <h6>นามสกุล</h6>
                                                    <input class="form-control opacity-input" name="lname"
                                                        style="text-align: start; width:120px;"
                                                        value="<?php echo $getUser['lname'] ?>">
                                                </div>
                                            </div>
                                            <div class="col-8 mb-3">
                                                <h6>เลือกรูปภาพ</h6>
                                                <input type="file" name="picture" class="form-control mb-3"
                                                    id="customFile" />

                                            </div>
                                            <div class="d-flex" style="gap: 5px;">
                                                <div class="form-check">
                                                    <input class="form-check-input" value="1" <?php echo $getUser['role'] == 1 ? 'checked' : '' ?> type="radio" name="role"
                                                        id="admin">
                                                    <label class="form-check-label" for="admin">
                                                        Admin
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" value="0" <?php echo $getUser['role'] == 0 ? 'checked' : '' ?> type="radio" name="role"
                                                        id="user">
                                                    <label class="form-check-label" for="user">
                                                        User
                                                    </label>
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
    </form>
    
    </div>
    <div class="d-flex justify-content-end">
        <form action="update_user_data.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <button type="submit" class="btn btn-primary">Back</button>
        </form>
    </div>
    </div>

    </div>

    </section>
    < </body>

</html>