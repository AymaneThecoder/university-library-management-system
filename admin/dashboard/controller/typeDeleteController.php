<?php

    include_once "../dataBaseCon/dbconnect.php";
    
    $type_id=$_POST['record'];
    $query="DELETE FROM `types` WHERE `types`.`id` = '$type_id'";

    $data=mysqli_query($conn,$query);

    if($data){
        echo"Type de document suprimé";
    }
    else{
        echo"erreur de la suppresion";
    }   
?>