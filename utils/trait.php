<?php

trait GetDynamic
{
    public function getSoleJoin($pk_tb, $fk_tb, $fk_key, $pk_key, $id): array
    {
        $conn = $this->conn;
        $sql = "SELECT $pk_tb.*, $fk_tb.*  
                    FROM $pk_tb
                    LEFT JOIN $fk_tb ON $pk_tb.$pk_key = $fk_tb.$fk_key
                    WHERE $pk_tb.$pk_key = :$pk_key";

        $smt = $conn->prepare($sql);
        $smt->execute([$pk_key => $id]);
        $data = $smt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function getAllJoin($pk_tb, $fk_tb, $fk_key, $pk_key)
    {
        $conn = $this->conn;
        try {
            $conn = $this->conn;
            $sql = "SELECT $pk_tb.*, $fk_tb.*  
                    FROM $pk_tb
                    LEFT JOIN $fk_tb ON $pk_tb.$pk_key = $fk_tb.$fk_key
                    ";
            $smt = $conn->prepare($sql);
            $smt->execute();
            $data = $smt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            return $e;
        }
    }
    
}

trait AuthCore
{
    public function registerSys($table_user,$table_userInfo,$username, $email, $passwordHash)
    {
        try {
       
            $this->conn->beginTransaction();
            
            $sql1 = "INSERT INTO $table_user (username, password, email, role) VALUES (:username, :password, :email, :role)";
            $smt1 = $this->conn->prepare($sql1);
            $user_reg_status = $smt1->execute(["username" => $username, "password" => $passwordHash, "email" => $email, "role" => 0]);
            $user_id = $this->conn->lastInsertId();
    
            $sql2 = "INSERT INTO $table_userInfo (id, email) VALUES (:id, :email)";
            $stmt2 = $this->conn->prepare($sql2);
            $user_info_status = $stmt2->execute(["id"=> $user_id, "email"=> $email ]);
             
    
            $this->conn->commit();
            return $user_reg_status && $user_info_status;
          } catch (Exception $e) {
            $this->conn->rollBack();
            return $e;
           
        }
    }
    public function delete_user($table,$table2,$id){
        try {
            $this->conn->beginTransaction();
            $delete_user = $this->deleteById($table, $id);
            $delete_user_info = $this->deleteById($table2, $id);
            $this->conn->commit();
            return $delete_user && $delete_user_info;
        }catch(PDOException $e) {
            $this->conn->rollBack();
            return $e;
        }
    }
    public function loginSys($user, $user_info, $password)
    {


        if ($user && password_verify($password, $user['password'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $default_img = "https://firebasestorage.googleapis.com/v0/b/loginsys-b8d67.appspot.com/o/default_avatar.jpg?alt=media&token=7f437efa-c1af-46c6-a652-6445ea259caf";


            $avatar = $user_info['avatar'] == "default_avatar" ? $default_img : "../image/upload/" . $user['id'] . "/" . $user_info['avatar'];
            $fullname = ((isset($user_info['fname']) && $user_info['fname'] != "ยังไม่ได้ตั้ง") && (isset($user_info['lname']) && $user_info['lname'] != "ยังไม่ได้ตั้ง"))
                ? $user_info['fname'] . " " . $user_info['lname']
                : "ยังไม่ได้ตั้งชื่อ";
            $_SESSION['avatar'] = $avatar;
            $_SESSION['fullname'] = $fullname;
            echo "<script>console.log('Login Successfully')</script>";
            header("Location: ../pages/index.php");
            exit();
        } else {
            header("Location: login.php");
            exit();
        }
    }
}