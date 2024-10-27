<?php
    
    include_once "abtract_class.php";
    class Server extends DB_connection{
        
    }


    class ReservationSystem extends Reserv{
        public function set_data($tablename, $dayAmount, $price, $isMember, $reservedBy, $email, $peopleAmount, $roomType, $id){
            $total = $price * $dayAmount;
    
            if ($peopleAmount > 4) {
                $limitBreak = $total * 20 / 100;
                $total -= $limitBreak;
            }
    
            if ($isMember === true) {
                $discount = $total * 10 / 100;
                $total -= $discount;
            }
            $this->taxFee = $total * (7 / 100);
            $total += $this->taxFee;

            $this->total = $total;
            $this->table = $tablename;
            $this->roomType = $roomType;
            $this->reservedBy = $reservedBy;
            $this->isMember = $isMember;
            $this->price = $price;
            $this->email = $email;
            $this->peopleAmount = $peopleAmount;
            $this->dayAmount = $dayAmount;
            $this->id = $id;
    
            
        }
        public function set_table($table){
          $this->table = $table;
        }
        public function feedback($title,$message,$user_id,$name){
          try{
          $sql1 = "INSERT INTO feedback (title,message,user_id,name) VALUES (:title,:message,:user_id,:name)";
          $stmt = $this->conn->prepare($sql1);
          $data = $stmt->execute(['title'=>$title,'message'=>$message,'user_id'=>$user_id,'name'=>$name]);
          return ['message'=>'success','status'=>$data];
        }catch(PDOException $e){
          return ['message'=> $e->getMessage(),'status'=>false];
        }
        }
        public function getAll_Feedback(){
          try {
            $conn = $this->conn;
            $sql = "SELECT *  FROM feedback ";
            $smt = $conn->prepare($sql);
            $smt->execute();
            $data = $smt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            return $e;
        }
        }
        public function getAll_FeedbackById($id){
          try {
            $conn = $this->conn;
            $sql = "SELECT *  FROM feedback WHERE user_id = :id ";
            $smt = $conn->prepare($sql);
            $smt->execute(['id'=>$id]);
            $data = $smt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            return $e;
        }
        }
        
        public function get_feedback_by_id($id){
          $conn = $this->conn;
        try {
            $sql = "SELECT * FROM feedback WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id'=>$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        }
    }

    class UserSystem extends User{
      
        public function set_table($table){
            $this->table = $table;
        }
        public function getAll(){
          
          try {
              $conn = $this->conn;
              $sql = "SELECT users.*, user_info.*  
                      FROM users
                      LEFT JOIN user_info ON users.id = user_info.id";
              $smt = $conn->prepare($sql);
              $smt->execute();
              $data = $smt->fetchAll(PDO::FETCH_ASSOC);
              return $data;
          } catch (PDOException $e) {
              return $e;
          }
        
    }
    public function getUserById($id){
      try {
              $conn = $this->conn;
              $sql = "SELECT users.id,
                      users.username,
                      users.password,
                      users.email,
                      users.role,
                      users.reg_date,
                      user_info.id as user_info_id,
                      user_info.fname, 
                      user_info.lname, 
                      user_info.avatar
                      FROM users
                      LEFT JOIN user_info ON users.id = user_info.id 
                      WHERE users.id = :id";
              $smt = $conn->prepare($sql);
              $smt->execute(['id'=>$id]);
              $data = $smt->fetch(PDO::FETCH_ASSOC);
              return $data;
          } catch (PDOException $e) {
              return $e;
          }
    }
    public function getUserByRole($role){
      $conn = $this->conn;
        try {
            $sql = "SELECT * FROM $this->table WHERE role = :role";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['role' => $role]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            return $e;
        }
    }
    public function changePassword($new_password,$id){
      $sql  = "UPDATE $this->table SET password = :password WHERE id = :id";
      $stmt = $this->conn->prepare($sql);
      $user = $stmt->execute(['password'=>$new_password,'id'=>$id]);
      return $user;
    }
    }

    class AuthSystem extends Auth{
      public function set_table($table){
        $this->table = $table;
      }
    }

    class UserInfoSystem extends UserSystem{
        public function uploadPic($file,$targetDir,$id){
            if ($file['error'] === UPLOAD_ERR_OK) {
                $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION); // Get the file extension
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
                  
                  $sql = "UPDATE $this->table SET 
                  avatar = :avatar
                  WHERE id = :id";
                  

                  // Prepare statement
                  $stmt = $this->conn->prepare($sql);
                  $upload = $stmt->execute(["avatar" => $randomFileName, "id" => $id]);
          
                  return $upload;
          
                } else {
                  echo "Error moving the uploaded file.";
                  return false;
                }
              } else {
                echo "Error: " . $file['error'];
                return false;
              }
        }
        public function update_userInfo($userTable,$fname, $lname, $email, $id)
    {
      try {
        // Start the transaction
        $this->conn->beginTransaction();

        // Check if the table is set correctly
        if (!isset($this->table)) {
            throw new Exception("Table name not set");
        }

        // First update query
        $sql1 = "UPDATE $this->table SET 
            fname = :fname,
            lname = :lname,
            email = :email
            WHERE id = :id";
        
        $stmt1 = $this->conn->prepare($sql1);
        $update_info = $stmt1->execute(["fname" => $fname, "lname" => $lname, "email" => $email, "id" => $id]);

        // Second update query
        $sql2 = "UPDATE $userTable SET email = :email WHERE id = :id";
        $stmt2 = $this->conn->prepare($sql2);
        $update_user = $stmt2->execute(['email' => $email, 'id' => $id]);

        // Check if both updates were successful
        if ($update_info && $update_user) {
            // Commit the transaction
            $this->conn->commit();
            return true;
        } else {
            // If one of them fails, rollback the transaction
            $this->conn->rollBack();
            return false;
        }
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $this->conn->rollBack();
        echo "Error: " . $e->getMessage();
        return false;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
    }
    }
?>