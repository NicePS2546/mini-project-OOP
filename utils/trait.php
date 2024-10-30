<?php



trait AuthCore
{
    public function registerSys($table_user, $table_userInfo, $username, $email, $passwordHash)
    {
        $exist_user = $this->getUserByEmail($table_user, $email);
        if ($exist_user['email'] == $email) {
            return ['message' => "อีเมลล์ถูกใช้งานแล้ว", 'status' => false];

        } else {
            try {

                $this->conn->beginTransaction();

                $sql1 = "INSERT INTO $table_user (username, password, email, role) VALUES (:username, :password, :email, :role)";
                $smt1 = $this->conn->prepare($sql1);
                $user_reg_status = $smt1->execute(["username" => $username, "password" => $passwordHash, "email" => $email, "role" => 0]);
                $user_id = $this->conn->lastInsertId();

                $sql2 = "INSERT INTO $table_userInfo (id, email) VALUES (:id, :email)";
                $stmt2 = $this->conn->prepare($sql2);
                $user_info_status = $stmt2->execute(["id" => $user_id, "email" => $email]);


                $this->conn->commit();
                return ['message' => "สำเร็จ", 'status' => $user_info_status && $user_reg_status];
            } catch (Exception $e) {
                $this->conn->rollBack();
                echo "<script>console.log('" . $e->getMessage() . "')</script>";
                return ['message' => "ชื่อ Username ถูกใช้ไปแล้ว", 'status' => false];

            }
        }
    }
    public function delete_user($table, $table2, $id)
    {
        try {
            $this->conn->beginTransaction();
            $this->table = $table;
            $delete_user = $this->deleteById($id);
            $this->table = $table2;
            $delete_user_info = $this->deleteById($id);
            $this->conn->commit();
            return $delete_user && $delete_user_info;
        } catch (PDOException $e) {
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