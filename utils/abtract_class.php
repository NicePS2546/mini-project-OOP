<?php

include_once "interface.php";
include "trait.php";
abstract class DB_connection implements DB
{
    public $conn;
    private $servername;
    private $DBusername;
    private $DBpassword;
    private $dataBaseName;

    public function __construct($servername, $DBusername, $DBpassword, $dataBaseName)
    {
        $this->servername = $servername;
        $this->DBusername = $DBusername;
        $this->DBpassword = $DBpassword;
        $this->dataBaseName = $dataBaseName;

        $this->conn = $this->connect($servername, $dataBaseName, $DBusername, $DBpassword);
    }
    public function connect($servername, $dbname, $username, $password): PDO|null
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
    public function getConnection(): PDO
    {
        return $this->conn;
    }
}


/*-------------------------------------------------------------------------------------------------------- */


abstract class Auth implements AuthManage,Delete
{
    use AuthCore;
    private $username;
    private $password;
    protected $conn;
    public $table;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    public function getUserByEmail($table, $email)
    {
        $conn = $this->conn;
        $sql = "SELECT * FROM $table WHERE email = :email";
        $smt = $conn->prepare($sql);
        $smt->execute(["email" => $email]);
        $data = $smt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function login($email, $password)
    {
        $user = $this->getUserByEmail('users', $email);
        $userInfo = $this->getUserByEmail('user_info', $email);

        $this->loginSys($user, $userInfo, $password);
    }
    public function register($table_user,$table_userInfo,$username, $email, $passwordHash)
    {
        $register = $this->registerSys($table_user,$table_userInfo,$username, $email, $passwordHash);
        return $register;
    }

    public function deleteById($id){
        try {
            $sql = "DELETE FROM $this->table WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute(['id' => $id]);
            echo "<script>console.log('Deleted Users')</script>";
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    
    public function deleteUser($pk_tb,$fk_tb,$id){
        return $this->delete_user($pk_tb,$fk_tb,$id);
    }
}

/*-------------------------------------------------------------------------------------------------------- */

abstract class Reserv implements Reservation, Delete, Update
{
    protected $conn;
    protected $table;
    protected $reservedBy;
    protected $email;
    protected $dayAmount;
    protected $peopleAmount;
    protected $roomType;
    protected $isMember;
    protected $price;
    protected $taxFee;
    protected $total;


    protected $id;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getSole($id): array
    {
        $conn = $this->conn;
        $sql = "SELECT * FROM tb_reservation WHERE id = :id";

        $smt = $conn->prepare($sql);
        $smt->execute(["id" => $id]);
        $data = $smt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function deleteById($id)
    {
        try {
            $table = $this->table;
            $sql = "DELETE FROM $table WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute(['id' => $id]);
            echo "<script>console.log('Deleted Users')</script>";
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function reservation()
    {
        $conn = $this->conn;
        $totalRows = $this->countRoom($this->table);
        if ($totalRows < 60) {
            try {
                $sql = "INSERT INTO $this->table(reservedBy, email, dayAmount, peopleAmount, roomType, member, price, taxFee, total,user_id) 
                VALUES (:reservedBy, :email, :dayAmount, :peopleAmount, :roomType, :member, :price, :taxFee, :total,:user_id)";
                $smt = $conn->prepare($sql);
                $result = $smt->execute([
                    'reservedBy' => $this->reservedBy,
                    'email' => $this->email,
                    'dayAmount' => $this->dayAmount,
                    'peopleAmount' => $this->peopleAmount,
                    'roomType' => $this->roomType,
                    'member' => $this->isMember,
                    'price' => $this->price,
                    'taxFee' => $this->taxFee,
                    'total' => $this->total,
                    'user_id'=>$this->id
                ]);

                if (!$result) {
                    $errorInfo = $smt->errorInfo();
                    return ['message' => 'SQL Error: ' . $errorInfo[2], 'status' => false];
                }

                return ['message' => 'added', 'status' => true];
            } catch (PDOException $e) {
                return ['message' => 'Error: ' . $e->getMessage(), 'status' => false];
            }
        } else {
            return ['message' => 'ห้องเต็ม โปรดติดต้อเจ้าของโรงแรม', 'status' => false];
        }
    }
    public function countRoom($table)
    {
        $conn = $this->conn;
        $sql = "SELECT COUNT(*) AS total_rows FROM $table";
        $smt = $conn->prepare($sql);
        $smt->execute();
        $data = $smt->fetch(PDO::FETCH_ASSOC);
        return $data['total_rows'];
    }
    public function updateById($id)
    {
        $conn = $this->conn;
        $sql = "UPDATE $this->table SET 
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
            'reservedBy' => $this->reservedBy,
            'email' => $this->email,
            'dayAmount' => $this->dayAmount,
            'peopleAmount' => $this->peopleAmount,
            'roomType' => $this->roomType,
            'member' => $this->isMember,
            'price' => $this->price,
            'taxFee' => $this->taxFee,
            'total' => $this->total,
            'id' => $id
        ]);

        return $result;
    }
    public function getAllReservation()
    {
        $conn = $this->conn;
        try {
            $sql = "SELECT * FROM $this->table";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            return $e;
        }
    }
    public function getReservationById($id){
        $conn = $this->conn;
        try {
            $sql = "SELECT * FROM $this->table WHERE user_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['id'=>$id]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }
    public function getRowById($id)
    {
        $conn = $this->conn;
        $sql = "SELECT * FROM tb_reservation WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["id" => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
}

/*-------------------------------------------------------------------------------------------------------- */
class User implements Delete,Get
{
    public $conn;
    public $table;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getRowById($id)
    {
        $conn = $this->conn;
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["id" => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data;
    }


    public function deleteById($id)
    {
        try {
            $table = $this->table;
            $sql = "DELETE FROM $table WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute(['id' => $id]);
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
    public function getAllfromTable($table){
        $conn = $this->conn;
        $sql = "SELECT * FROM $table";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    
}

