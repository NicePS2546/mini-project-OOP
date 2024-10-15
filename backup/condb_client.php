<?php

class Server
{
  private $servername;
  private $username;
  private $password;
  private $dataBaseName;

  private $DBconnect;

  public function __construct($servername, $DBusername, $DBpassword, $dataBaseName)
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
  function reservation($conn, $tablename, $dayAmount, $price, $isMember, $reservedBy, $email, $peopleAmount, $roomType)
  {
    $total = $price * $dayAmount;

    if ($peopleAmount > 4) {
      $limitBreak = $total * 20 / 100;
      $total += $limitBreak;

    }
    ;
    if ($isMember === true) {
      $discount = $total * 10 / 100;
      $total -= $discount;
    }
    ;

    $taxFee = $total * (7 / 100);
    $total += $taxFee;

    $sql = "INSERT INTO $tablename(reservedBy, email, dayAmount, peopleAmount, roomType, member, price, taxFee, total) VALUES (:reservedBy, :email, :dayAmount, :peopleAmount,:roomType, :member, :price, :taxFee, :total)";
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
  public function getSoleJoin($conn, $pk_tb = "persons", $fk_tb = "tb_users", $fk_key = "id", $pk_key = "id",$id/*default value*/ )
  {
    /**
 * Determine if a variable is considered set, this means if a variable is declared and is different than `null` .
 *
 * @param object $conn mySql connection.
 * @param string $pk_tb primary key table.
 * @param string $fk_tb foreign key table.
 * @param string $pk_key primary key of primary table.
 * @param string $fk_key primary key foreign table.
 * @param string $id get id to find info in database
 * @return array Returns `true` if `fetched data` exists and has any value other than `null` . `false` otherwise.
 */
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
  public function update($conn, $tablename, $dayAmount, $price, $isMember, $reservedBy, $email, $peopleAmount, $roomType, $id)
  {

    $total = $price * $dayAmount;

    if ($peopleAmount > 4) {
      $limitBreak = $total * 20 / 100;
      $total += $limitBreak;

    }
    ;
    if ($isMember === true) {
      $discount = $total * 10 / 100;
      $total -= $discount;
    }
    ;

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
    // Prepare statement
    $stmt = $conn->prepare($sql);

    // execute the query
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
  private function connectServer($servername, $username, $dbname, $password)
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
  public function getDataTable($conn, $table)
  {
    $sql = "SELECT * FROM $table";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $reservations;
  }
  public function deleteById($conn, $table, $id)
  {
    try {

      $sql = "DELETE FROM $table WHERE id = :id";
      $stmt = $conn->prepare($sql);
      // $stmt->bindParam(1, $id);
      // $result = $stmt->execute();
      $result = $stmt->execute(["id" => $id]);
      echo "<script>console.log('Deleted Users')</script>";
      return $result;

    } catch (PDOException $e) {
      echo $e->getMessage();
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


  public function getConnection()
  {
    return $this->DBconnect;
  }

}






?>