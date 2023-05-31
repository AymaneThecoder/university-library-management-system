<?php

    include_once "../dataBaseCon/dbconnect.php";
    
    $d_id=$_POST['record'];
    $query="DELETE FROM document where id_doc='$d_id'";

    $data=mysqli_query($conn,$query);

    if($data){
        echo"Document Item Deleted";
    }
    else{
        echo"Not able to delete";
    }
    
?>