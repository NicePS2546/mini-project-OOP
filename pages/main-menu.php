
<!-- Content -->
<div class="container mt-3 m-border text-center">
    <h2 style="color:black;">Welcome <?php echo $_SESSION['fullname'] ?></h2>
    <div class="d-grid gap-2">

        <a href="../pages/user/insertData.php" class="btn btn-success">Reservation System</a>
        <a href="../pages/user/show_reserved.php" class="btn btn-success">Show Reserved Room</a>
        <a href="../pages/user/show_feedback.php" class="btn btn-success">Show Committed Feedback</a>
        <a href="../pages/admin/show_all_feedback.php"<?php echo $_SESSION['role'] == 1 ? "" : "style='display:none;'" ?> class="btn btn-warning">Show All Feedback</a>
        <a href="../pages/admin/show_table.php" <?php echo $_SESSION['role'] == 1 ? "" : "style='display:none;'" ?> class="btn btn-warning" class="btn btn-success">Show Reservation Table </a>
        <a href="../pages/admin/show_table_user.php" <?php echo $_SESSION['role'] == 1 ? "" : "style='display:none;'" ?> class="btn btn-warning">User Table</a>
        <!-- <a href="../pages/admin/user_info_table.php" <?php echo $_SESSION['role'] == 1 ? "" : "style='display:none;'" ?> class="btn btn-warning">User Info Table</a>
        <a href="../pages/admin/admin_info_table.php" <?php echo $_SESSION['role'] == 1 ? "" : "style='display:none;'" ?> class="btn btn-warning">Admin Info Table</a>
        <a href="../pages/admin/all_userInfo_table.php" <?php echo $_SESSION['role'] == 1 ? "" : "style='display:none;'" ?> class="btn btn-warning">All User Info</a> -->
        <!-- <a href="" class="btn btn-primary">Insert Data with Form by exec</a>
        <a href="" class="btn btn-primary">Insert Data with SQL by Prepared Statement=> :</a>
        <a href="" class="btn btn-primary">Insert Data with SQL by Prepared Statement=> ?</a>
        <a href="" class="btn btn-primary">Insert Data with Form by PDO</a>
        <a href="" class="btn btn-primary">View Student Data</a> -->
    </div>
</div>
<!-- End Content -->