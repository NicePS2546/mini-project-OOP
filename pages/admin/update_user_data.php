<?php 
      include "header.php";
      include "footer.php";
      require_once '../../loginCrud/db_config.php';

      $id = $_POST['id'] ?? '';
      $p_url = $_POST['p_url'] ?? null;
      $getUser = $user->getSole( $table, $userInfoTable, 'id','id', $id );
      $default_img = "https://firebasestorage.googleapis.com/v0/b/loginsys-b8d67.appspot.com/o/default_avatar.jpg?alt=media&token=7f437efa-c1af-46c6-a652-6445ea259caf";
      $avatar = $getUser['avatar'] == "default_avatar" ? $default_img : "../../image/upload/$id/" . $getUser['avatar'];
      $fullname = ((isset($getUser['fname']) && $getUser['fname'] != "ยังไม่ได้ตั้ง") && (isset($getUser['lname']) && $getUser['lname'] != "ยังไม่ได้ตั้ง"))
    ? $getUser['fname'] . " " . $getUser['lname']
    : "ยังไม่ได้ตั้งชื่อ";
    $previous_url = $_SERVER['HTTP_REFERER'] ?? '';
    switch ($previous_url) {
        case $baseUrl . "show_table_user.php":
            $url = "show_table_user.php";
            $p_url = "show_table_user.php";
            break;
        case $baseUrl . "admin_info_table.php":
            $url = "admin_info_table.php";
            $p_url = "admin_info_table.php";
            break;
        case $baseUrl . "user_info_table.php":
            $url = "user_info_table.php";
            $p_url = "user_info_table.php";
            break;
        case $baseUrl . "all_userInfo_table.php":
            $url = "all_userInfo_table.php";
            $p_url = "all_userInfo_table.php";
            break;
        default:
            break;
    }
    
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    .gradient-custom {
      /* fallback for old browsers */
      background: #f6d365;

      /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
      background: linear-gradient(to right bottom, rgba(246, 211, 101, 1), rgba(253, 160, 133, 1))
    }
  </style>
</head>

<body>
  <form action="update_user_form.php" method="post">
    <input type="hidden" name="id" value="<?php echo $id ?>" >
    <input type="hidden" name="p_url" value="<?php echo $p_url ?>" >
    <section class="vh-100" style="background-color: #f4f5f7;">
      <div class="container py-5 h-75">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col col-lg-6 mb-4 mb-lg-0">
            <div class="card mb-3" style="border-radius: .5rem;">
              <div class="row g-0">
                <div class="col-md-4 gradient-custom text-center text-white"
                  style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                  <img src="<?php echo $avatar ?>" alt="Avatar" class="img-fluid rounded my-5" style="width: 80px;" />
                  <h5><?php echo $fullname ?></h5>
                  <p style="font-size: 18px;"><?php echo $getUser['role'] == 1 ? "Admin" : "User" ?></p>
                  <i class="far fa-edit mb-5"></i>
                </div>
                <div class="col-md-8">
                  <div class="card-body p-4">
                    <h6>ข้อมูลโปรไฟล์</h6>
                    <hr class="mt-0 mb-4">
                    <div class="row pt-1">
                      <div class="col-8 mb-3">
                        <h6>อีเมลล์</h6>
                        <p class="text-muted"><?php echo $getUser['email'] ?></p>
                      </div>
                      <div class="col-8 mb-3">
                        <h6>ชื่อ</h6>
                        <p class="text-muted" style="font-size: 18px;"><?php echo $fullname ?></p>
                      </div>
                    </div>

                    <hr class="mt-0 mb-4">
                    <div class="row pt-1">
                      <button type="submit" class="btn btn-primary">แก้ไขโปรไฟล์</button>
                    </div>
                    
                  </div>
                  
                </div>
               
              </div>
             
            </div>
            <div class="d-flex justify-content-end" >
                        <a href="<?php echo isset($url) ? $url : $p_url ?>" class="btn btn-primary">Back</a>
                        
            </div>
          </div>
          
        </div>

      </div>
      
    </section>
    
  </form>
    
</body>

</html>