<?php
class Server
{
    private $servername;
    private $username;
    private $password;
    private $dataBaseName;
    public $DBconnect;

    public function __construct($servername, $DBusername, $DBpassword, $dataBaseName)
    {
        $this->servername = $servername;
        $this->username = $DBusername;
        $this->password = $DBpassword;
        $this->dataBaseName = $dataBaseName;

        $this->DBconnect = $this->connectServer($servername, $DBusername, $dataBaseName, $DBpassword);
    }

    // Database connection method
    private function connectServer($servername, $username, $dbname, $password)
    {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . $e->getMessage();
            return null;
        }
    }
    public function getConnection()
    {
        return $this->DBconnect;
    }

    // Add user to tb_users table
    public function addUser($database, $fname, $lname, $email, $password, $role)
    {
        $sql = "INSERT INTO tb_users (fname,lname,email,password,role) VALUES ('$fname' , '$lname' ,'$email' ,'$password' ,'$role')";
        $result = $database->exec($sql);
        if ($result) {
            echo "เพิ่มข้อมูลเรียบร้อยแล้ว";
        } else {
            echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล";
        }
    }

    // Reservation method
    public function reservation($conn, $tablename, $dayAmount, $price, $isMember, $reservedBy, $email, $peopleAmount, $roomType)
    {
        $total = $price * $dayAmount;

        if ($peopleAmount > 4) {
            $limitBreak = $total * 20 / 100;
            $total += $limitBreak;
        }

        if ($isMember === true) {
            $discount = $total * 10 / 100;
            $total -= $discount;
        }

        $taxFee = $total * (7 / 100);
        $total += $taxFee;

        $sql = "INSERT INTO $tablename(reservedBy, email, dayAmount, peopleAmount, roomType, member, price, taxFee, total) 
                VALUES (:reservedBy, :email, :dayAmount, :peopleAmount, :roomType, :member, :price, :taxFee, :total)";
        $smt = $conn->prepare($sql);
        $result = $smt->execute([
            'reservedBy' => $reservedBy,
            'email' => $email,
            'dayAmount' => $dayAmount,
            'peopleAmount' => $peopleAmount,
            'roomType' => $roomType,
            'member' => $isMember,
            'price' => $price,
            'taxFee' => $taxFee,
            'total' => $total
        ]);

        return $result;
    }

    // Update reservation details
    public function update($conn, $tablename, $dayAmount, $price, $isMember, $reservedBy, $email, $peopleAmount, $roomType, $id)
    {
        $total = $price * $dayAmount;

        if ($peopleAmount > 4) {
            $limitBreak = $total * 20 / 100;
            $total += $limitBreak;
        }

        if ($isMember === true) {
            $discount = $total * 10 / 100;
            $total -= $discount;
        }

        $taxFee = $total * (7 / 100);
        $total += $taxFee;

        $sql = "UPDATE $tablename SET 
                reservedBy = :reservedBy, 
                email = :email, 
                dayAmount = :dayAmount, 
                peopleAmount = :peopleAmount, 
                roomType = :roomType, 
                member = :member, 
                price = :price, 
                taxFee = :taxFee, 
                total = :total 
                WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            'reservedBy' => $reservedBy,
            'email' => $email,
            'dayAmount' => $dayAmount,
            'peopleAmount' => $peopleAmount,
            'roomType' => $roomType,
            'member' => $isMember,
            'price' => $price,
            'taxFee' => $taxFee,
            'total' => $total,
            'id' => $id
        ]);

        return $result;
    }

    // Fetch data with a join
    public function getSoleJoin($conn, $pk_tb = "persons", $fk_tb = "tb_users", $fk_key = "id", $pk_key = "id", $id)
    {
        $sql = "SELECT $pk_tb.*, $fk_tb.*  
                FROM $pk_tb
                LEFT JOIN $fk_tb ON $pk_tb.$pk_key = $fk_tb.$fk_key
                WHERE $pk_tb.$pk_key = :$pk_key";

        $smt = $conn->prepare($sql);
        $smt->execute([$pk_key => $id]);
        $data = $smt->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            echo "<script>console.log('fetched user')</script>";
        } else {
            echo "<script>console.log('error')</script>";
        }
        return $data;
    }
    public function getAllJoin($conn, $pk_tb = "users", $fk_tb = "user_info", $fk_key = "id", $pk_key = "id")
    {
        $sql = "SELECT $pk_tb.*, $fk_tb.*  
                FROM $pk_tb
                LEFT JOIN $fk_tb ON $pk_tb.$pk_key = $fk_tb.$fk_key";

        $smt = $conn->prepare($sql);
        $smt->execute();
        $data = $smt->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            echo "<script>console.log('fetched user')</script>";
        } else {
            echo "<script>console.log('error')</script>";
        }
        return $data;
    }
    public function getAllAdminJoin($conn, $pk_tb = "users", $fk_tb = "user_info", $fk_key = "id", $pk_key = "id", $role = 1)
    {
        $sql = "SELECT $pk_tb.*, $fk_tb.*  
                FROM $pk_tb
                LEFT JOIN $fk_tb ON $pk_tb.$pk_key = $fk_tb.$fk_key
                WHERE $pk_tb.$pk_key = :$pk_key";

        $smt = $conn->prepare($sql);
        $smt->execute([$pk_key => $role]);
        $data = $smt->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            echo "<script>console.log('fetched user')</script>";
        } else {
            echo "<script>console.log('error')</script>";
        }
        return $data;
    }
    public function getAllUserJoin_prototype($conn, $pk_tb = "users", $fk_tb = "user_info", $fk_key = "id", $pk_key = "id", $role = 0)
    {
        $sql = "SELECT $pk_tb.*, $fk_tb.*  
                FROM $pk_tb
                LEFT JOIN $fk_tb ON $pk_tb.$pk_key = $fk_tb.$fk_key
                WHERE $pk_tb.$pk_key = :$pk_key";

        $smt = $conn->prepare($sql);
        $smt->execute([$pk_key => $role]);
        $data = $smt->fetchAll(PDO::FETCH_ASSOC);
        if ($data) {
            echo "<script>console.log('fetched user')</script>";
        } else {
            echo "<script>console.log('error')</script>";
        }
        return $data;
    }
    public function getAllUser($conn,$table,$role = 0){
        $sql = "SELECT * FROM $table WHERE role = :role";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['role'=>$role]);
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $reservations;
    }
    public function getAllAdmin($conn,$table,$role = 1){
        $sql = "SELECT * FROM $table WHERE role = :role";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['role'=>$role]);
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $reservations;
    }

    // Fetch all data from a table
    public function getDataTable($conn, $table)
    {
        $sql = "SELECT * FROM $table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }

    // Delete data by ID
    public function deleteById($conn, $table, $var='id', $id)
    {
        try {
            $sql = "DELETE FROM $table WHERE $var = :$var";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([$var => $id]);
            echo "<script>console.log('Deleted Users')</script>";
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    // Fetch a single record by ID
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

    // Fetch a single record by email
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

    // Register a new user
    

    

    // User login function
    public function login($conn, $table, $email, $password)
    {
        
    }
    public function getUserByRole($conn,$table, $role){
        try{
        $sql = "SELECT * FROM $table WHERE role = :role";
        $stmt = $conn->prepare($sql);
        $data = $stmt->execute(["role"=>$role]);
        return $data;
    }catch(PDOException $e){
        return $e;
    }
    }
    public function register_user($connect, $table, $username, $password, $email, $role = 0)
    {
        $sql = "INSERT INTO $table (username, password, email, role) VALUES (:username, :password, :email, :role)";
        $smt = $connect->prepare($sql);
        $registerUser = $smt->execute(["username" => $username, "password" => $password, "email" => $email, "role" => $role]);
        return $registerUser;
    }
    public function register($conn,$table_user,$table_userInfo,$username, $email, $passwordHash)
    {
      
}
    // File upload function
    public function upload_picture($conn, $table, $file, $targetDir, $id)
    {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileName = basename($file['name']);
            $randomFileName = uniqid(mt_rand(), true) . '.' . pathinfo($file["name"], PATHINFO_EXTENSION);

            // Create the full path for the target file
            $targetFile = $targetDir . $randomFileName;

            // Check if the target directory exists; if not, create it
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $fileType = pathinfo($targetFile, PATHINFO_EXTENSION);
            $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];

            if (in_array($fileType, $allowedTypes)) {
                if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                    $sql = "UPDATE $table SET avatar = :avatar WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $data = $stmt->execute(['avatar' => $randomFileName, 'id' => $id]);

                    
                    $_SESSION['avatar'] = $targetFile;
                    
                    return $data;
                } else {
                    $error = ['message' => 'Fail to move file', 'status' => false];
                }
            } else {
                $error = ['message' => 'Type error', 'status' => false];
            }
        } else {
            $error = ['message' => "Error:" . $file['error'], 'status' => false];
        }
        return $error == null ? null : $error;
    }
    public function upload_pictureById($conn, $table, $id, $file, $targetDir)
    {
      if ($file['error'] === UPLOAD_ERR_OK) {
        // Generate a random file name
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $randomFileName = uniqid(mt_rand(), true) . '.' . $fileExtension;
  
        // Full path for the target file
        $targetFile = $targetDir . $randomFileName;
  
        // Check if the target directory exists; if not, create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true); // Create the directory with 0755 permissions
        }
  
        // Move the uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Update the database with the new file name
            $sql = "UPDATE $table SET avatar = :avatar WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $upload = $stmt->execute(["avatar" => $randomFileName, "id" => $id]);
  
            // Save the new avatar path in session
            
  
            return $upload;
        } else {
            echo "Error moving the uploaded file.";
        }
    } else {
        echo "Error: " . $file['error'];
    }
  
    return false;
    }
    // Update avatar
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
      $conn->commit();
      return $update_user && $update_info;
    }catch(PDOException $e) {
      $conn->rollBack();
      return $e;
    }
    }
    public function update_infoByAdmin($conn, $table_info, $table_users, $fname, $lname, $email, $role, $id)
{
    try {
        // Start the transaction
        $conn->beginTransaction();

        // Update $table_info
        $sql = "UPDATE $table_info SET 
                fname = :fname,
                lname = :lname,
                email = :email,
                role = :role
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $update_info = $stmt->execute([
            "fname" => $fname,
            "lname" => $lname,
            "email" => $email,
            "role" => $role,
            "id" => $id
        ]);

        // Update $table_users
        $sql = "UPDATE $table_users SET email = :email, role = :role WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $update_user = $stmt->execute([
            'email' => $email,
            'role' => $role,
            'id' => $id
        ]);

        // Commit the transaction if both updates were successful
        if ($update_info && $update_user) {
            $conn->commit();
            return true;
        } else {
            $conn->rollBack();
            return false;
        }
    } catch (PDOException $e) {
        // Rollback the transaction in case of error
        $conn->rollBack();
        // Log the error message for debugging
        error_log("Error updating data: " . $e->getMessage());
        return false;
    }
}

    public function delete_user($conn,$table,$table2,$var,$id){
        try {
            $conn->beginTransaction();
            $delete_user = $this->deleteById($conn, $table,$var, $id);
            $delete_user_info = $this->deleteById($conn, $table2,$var, $id);
            $conn->commit();
            return $delete_user && $delete_user_info;
        }catch(PDOException $e) {
            $conn->rollBack();
            return $e;
        }
    }
}

    


?>