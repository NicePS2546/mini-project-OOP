<?php

class Server
{
  private $servername;
  private $username;
  private $password;
  private $dataBaseName;


  public $DBconnect;

  function __construct($servername, $DBusername, $DBpassword, $dataBaseName)
  {
    $this->servername = $servername;
    $this->username = $DBusername;
    $this->password = $DBpassword;

    $this->DBconnect = $this->connectServer($servername, $DBusername, $dataBaseName, $DBpassword);
  }

  function addUser($database, $fname, $lname, $email, $password, $role)
  {
    $sql = "INSERT INTO tb_users (fname,lname,email,password,role) VALUES ('$fname' , '$lname' ,'$email' ,'$password' ,'$role')";
    $result = $database->exec($sql);
    if ($result) {
      echo "เพิ่มข้อมูลเรียบร้อยแล้ว";
    } else {
      echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล";
    }
  }
  function register($connect, $table, $username, $password, $email, $role = 0 /*default role = User*/)
  {
    $sql = "INSERT INTO $table (username, password, email,role) VALUES (:username, :password, :email, :role)";
    $smt = $connect->prepare($sql);
    $registerUser = $smt->execute(["username" => $username, "password" => $password, "email" => $email, "role" => $role]);
    return $registerUser;
  }



  public function add_userInfo($conn, $table, $id, $email)
  {
    $sql = "INSERT INTO $table (id, fname, lname, email) VALUES (:id, :fname, :lname, :email)";
    $smt = $conn->prepare($sql);
    $data = $smt->execute(["id" => $id, 'fname' => "ยังไม่ได้ตั้ง", 'lname' => "ยังไม่ได้ตั้ง", 'email' => $email]);
    return $data;
  }
  function login($conn, $table, $email, $password)
  {
    $sql = "SELECT * FROM $table WHERE email = :email";
    $smt = $conn->prepare($sql);
    $smt->execute(["email" => $email]);
    $user = $smt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['email'] = $user['email'];
      $default_img = "https://firebasestorage.googleapis.com/v0/b/loginsys-b8d67.appspot.com/o/default_avatar.jpg?alt=media&token=7f437efa-c1af-46c6-a652-6445ea259caf";

      $user_info = $this->getSoleByEmail($conn, 'user_info', $user['email']);
      $avatar = $user_info['avatar'] == "default_avatar" ? $default_img : "image/upload/" . $user_info['avatar'];
      $fullname = ((isset($user_info['fname']) && $user_info['fname'] != "ยังไม่ได้ตั้ง") && (isset($user_info['lname']) && $user_info['lname'] != "ยังไม่ได้ตั้ง"))
        ? $user_info['fname'] . " " . $user_info['lname']
        : "ยังไม่ได้ตั้งชื่อ";
      $_SESSION['avatar'] = $avatar;
      $_SESSION['fullname'] = $fullname;
      echo "<script>console.log('Login Successfully')</script>";
      header("Location: ../index.php");
      exit();
    } else {
      header("Location: login.php");
      exit();
    }
  }
  function connectServer($servername, $username, $dbname, $password)
  {
    try {
      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // echo "เชื่อมต่อฐานข้อมูลสำเร็จ";
      return $conn;
    } catch (PDOException $e) {
      echo "เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . $e->getMessage();
      return null;
    }

  }
  public function getSole($conn, $table, $id)
  {
    $sql = "SELECT * FROM $table WHERE id = :id";
    $smt = $conn->prepare($sql);
    $smt->execute(["id" => $id]);
    $data = $smt->fetch(PDO::FETCH_ASSOC);
    if ($data) {
      echo "<script>console.log('fetched user')</script>";
    } else {
      echo "<script>console.log('error')</script>";
    }
    return $data;
  }


  public function getSoleByEmail($conn, $table, $email)
  {
    $sql = "SELECT * FROM $table WHERE email = :email";
    $smt = $conn->prepare($sql);
    $smt->execute(["email" => $email]);
    $data = $smt->fetch(PDO::FETCH_ASSOC);
    if ($data) {
      echo "<script>console.log('fetched user')</script>";
    } else {
      echo "<script>console.log('error')</script>";
    }
    return $data;
  }
  public function upload_picture($conn, $table, $id, $file, $targetDir)
  {
    if ($file['error'] === UPLOAD_ERR_OK) {
      // Get the file extension
      $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
      $randomFileName = uniqid(mt_rand(), true) . '.' . pathinfo($file["name"], PATHINFO_EXTENSION);
      // Create the target file path with the user's name and original extension
      $originalFileName = basename($file['name']);

      // Create the full path for the target file
      $targetFile = $targetDir . $randomFileName;

      // Check if the target directory exists; if not, create it
      if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
      }

      // Move the uploaded file to the target directory
      if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        // Insert the original file name into the database
        // $sql = "INSERT INTO $table (avatar) VALUES (:avatar)";
        // $stmt = $conn->prepare($sql);
        // $upload = $stmt->execute(["avatar"=>$originalFileName]);
        $sql = "UPDATE $table SET 
        avatar = :avatar
        WHERE id = :id";
        // Prepare statement
        $stmt = $conn->prepare($sql);
        $upload = $stmt->execute(["avatar" => $randomFileName, "id" => $id]);
        $_SESSION['avatar'] = $targetFile;

        return ['status' => $upload, 'fileName' => $randomFileName];

      } else {
        echo "Error moving the uploaded file.";
      }
    } else {
      echo "Error: " . $file['error'];
    }
  }
  
  public function update_user($conn, $table, $email, $id)
  {
    $sql = "UPDATE $table SET email = :email 
            WHERE id = :id
    ";
    $stmt = $conn->prepare($sql);
    $data = $stmt->execute(['email' => $email, 'id' => $id]);
    return $data;
  }

  public function update_info($conn, $table_info, $table_users, $fname, $lname, $email, $id)
  {
    try {
    $conn->beginTransaction();
    $sql = "UPDATE $table_info SET 
    fname = :fname,
    lname = :lname,
    email = :email
    WHERE id = :id";
    // Prepare statement
    $stmt = $conn->prepare($sql);
    $update_info = $stmt->execute(["fname" => $fname, "lname" => $lname, "email" => $email, "id" => $id]);
    $update_user = $this->update_user($conn, $table_users, $email, $id);
    
    return $update_user && $update_info;
  }catch(PDOException $e) {
    $conn->rollBack();
  }
  }
public function update_infoByAdmin($conn, $table_info, $table_users, $fname, $lname, $email,$role, $id)
  {
    try {
    $conn->beginTransaction();
    $sql = "UPDATE $table_info SET 
    fname = :fname,
    lname = :lname,
    email = :email,
    role = :role
    WHERE id = :id";
    // Prepare statement
    $stmt = $conn->prepare($sql);
    $update_info = $stmt->execute(["fname" => $fname, "lname" => $lname, "email" => $email, "role"=>$role , "id" => $id]);
    
    $sql = "UPDATE $table_users SET email = :email , role = :role
            WHERE id = :id
    ";
    $stmt = $conn->prepare($sql);
    $update_user= $stmt->execute(['email' => $email,'role'=>$role, 'id' => $id]);
    $conn->commit();
    return $update_user && $update_info;
  }catch(PDOException $e) {
    $conn->rollBack();
    return $e;
  }
  }
  function new_register($conn, $fname, $lname, $email, $passwordHash)
  {
    try {
      // เริ่มการท าธุรกรรม (Transaction) เพื่อให้แน่ใจว่าข้อมูลถูกบันทึกลงทั้งสองตาราง หรือไม่บันทึกเลย
      $conn->beginTransaction();

      // ค าสั่ง SQL ส าหรับบันทึก fname และ lname ลงตาราง persons
      $sql1 = "INSERT INTO persons (fname, lname) VALUES (:fname, :lname)";
      $stmt1 = $conn->prepare($sql1);
      $person_status = $stmt1->execute(['fname' => $fname, 'lname' => $lname]);
      // รับค่า person_id ของแถวที่เพิ่งถูกเพิ่มใน persons
      $person_id = $conn->lastInsertId();

      // ค าสั่ง SQL ส าหรับบันทึก email, password และ role ลงตาราง tb_users
      $sql2 = "INSERT INTO tb_users (person_id, email, password) VALUES (?, ?, ?)";
      $stmt2 = $conn->prepare($sql2);
      $stmt2->bindParam(1, $person_id);
      $stmt2->bindParam(2, $email);
      $stmt2->bindParam(3, $passwordHash);
      $user_status = $stmt2->execute();
      // ถ้าทุกอย่างท างานเรียบร้อย ท าการ Commit เพื่อยืนยันการบันทึกข้อมูล
      $conn->commit();

      // $result = "success"; // ก าหนดค่า result เป็น success เมื่อส าเร็จ
      return $person_status && $user_status;
    } catch (Exception $e) {
      $conn->rollBack();
      return $e;
      // ก าหนดค่า result เป็น error เมื่อเกิดข้อผิดพลาด
    }

  }
  function getConnection()
  {
    return $this->DBconnect;
  }
}
;




?>