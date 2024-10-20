<?php

    interface DB{
        public function __construct($servername, $DBusername, $DBpassword, $dataBaseName);
        public function connect($servername,$dbname,$username,$password):PDO|null;
        public function getConnection():PDO;
    }
    
    interface AuthManage{
        public function register($table_user,$table_userInfo,$username, $email, $passwordHash);
        public function login($email, $password);
        public function getUserByEmail($table,$email);
    }
    
    

    

    interface Delete{
        public function deleteById($id);
    }
    interface Get{
       
        public function getRowById($id);
        public function getAllfromTable($table);
    }
    interface Update{
        public function updateById($id);
    }

    interface Reservation{
        public function reservation();
        public function getAllReservation();
        public function getReservationById($id);
    }


    
?>