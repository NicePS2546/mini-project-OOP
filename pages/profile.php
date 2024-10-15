<?php include "user_manage.php";
      include "header.php";
      include "footer.php";
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
  <form action="edit_profile.php">
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
                  <p style="font-size: 18px;"><?php echo $user['role'] == 1 ? "Admin" : "User" ?></p>
                  <i class="far fa-edit mb-5"></i>
                </div>
                <div class="col-md-8">
                  <div class="card-body p-4">
                    <h6>ข้อมูลโปรไฟล์</h6>
                    <hr class="mt-0 mb-4">
                    <div class="row pt-1">
                      <div class="col-8 mb-3">
                        <h6>อีเมลล์</h6>
                        <p class="text-muted"><?php echo $user['email'] ?></p>
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
                        <a href="index.php" class="btn btn-primary">Back</a>
            </div>
          </div>
          
        </div>

      </div>
      
    </section>
    
  </form>
</body>

</html>