<?php
session_start();
include 'header.php';
include 'footer.php';

include 'session_manage.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        button a {
            text-decoration: none;
            color: white;
        }

        button a:hover {
            text-decoration: none;
            color: white;
        }

        body {
            color: black;
        }

        .h-custom {
            height: calc(100% - 70px);
        }
    </style>
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid justify-content-center align-items-center d-flex h-custom" style=''>
            <div
                class="col-md-8 col-lg-6 d-flex justify-content-center align-items-center mx-auto col-xl-4 offset-xl-1">
                <div style='padding: 20px 25px 20px 25px;'
                    class='row d-flex card justify-content-center align-items-center h-100'>
                    <h3>ผลลัพธ์</h3>
                    <h4>
                        <?php

                        include '65_41_conDB.php';
                        $server = new Server($servername, $DBusername, $DBpassword, $dataBaseName);
                        $conn = $server->getConnection();

                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $name = $_POST['reservedBy'];
                            $roomType = $_POST['roomType'];
                            $email = $_POST['email'];
                            $dayAmount = $_POST['dayAmount'];
                            $peopleAmount = $_POST['peopleAmount'];
                            $isMember = filter_var($_POST['member'], FILTER_VALIDATE_BOOLEAN);
                            $price = 0;
                            if ($roomType === 'normal') {
                                $price = 850;
                            } else if ($roomType === 'deluxe') {
                                $price = 1750;
                            } else {
                                $price = 3500;
                            }
                            ;

                            $result = $server->reservation($conn, $tableName, $dayAmount, $price, $isMember, $name, $email, $peopleAmount, $roomType);


                        }
                        ?>
                    </h4>
                    <button type="submit" class="btn btn-primary btn-lg"
                        style="padding-left: 2.5rem;  margin-top:50px; padding-right: 2.5rem;"><a
                            href='index.php'>กลับหน้าหลัก</a></button>
                </div>
            </div>
        </div>
    </section>

</body>

</html>