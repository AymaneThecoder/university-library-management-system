<?php
    include_once "../dataBaseCon/dbconnect.php";
    
    if(isset($_POST['upload']))
    {
        $titre= $_POST['titre'];
        $auteur = $_POST['auteur'];
        $descript = $_POST['descript'];
        $qte = $_POST['qte'];
        $type = $_POST['nom_type'];
            
        $name = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
    
        $location="./Documents/";
        $image=$location.$name;

        $target_dir="../Documents/";
        $finalImage=$target_dir.$name;

        move_uploaded_file($temp,$finalImage);

         $insert = mysqli_query($conn,"INSERT INTO document
         (nom_type,auteur,titre,descript,qte,doc_img) 
         VALUES ('$type','$auteur','$titre','$descript',$qte,'$image')");
 
         if(!$insert)
         {
             echo mysqli_error($conn);
         }
         else
         {
             echo "Records added successfully.";
         }
     
    }
        
?>