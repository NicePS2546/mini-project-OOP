<?php
    require_once "db_config.php";
    
    // $data = $reservation->getSoleJoin($table,$userInfoTable,'id','id',7);
    
    $callback = $reservation->set_data('tb_reservation',10,100,1,"Test2000","testasd@gmail.com",5,'dasdeluex',1);
    $reserving = $reservation->reservation();
    $row = $reservation->countRows('tb_reservation');
    echo $row;

    if($reserving['status']){
        echo $reserving['message']."<br>";
    }else{
        echo $reserving['message']."<br>";
    }



  
    



?>