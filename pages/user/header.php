<?php
    if(session_status()==PHP_SESSION_NONE)session_start();

    include "../session_manage.php";
    include_once "../user_manage.php";


?>
     
<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP-DB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        .m-border {
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 800px;
            padding: 20px;
        }
    </style>
</head>

<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php"><img src="<?php echo $avatar ?>" alt="myphoto" class="rounded-pill
me-2 text-uppercase" style="width: 30px;"><?php echo strtoupper($_SESSION['fullname']); ?></a>
        
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bstarget="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                arialabel="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    
                    <li class="nav-item">
                        <a class="nav-link" href="../loginCrud/logout.php">Logout</a>
                    </li>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->