<?php
include_once "../dataBaseCon/dbconnect.php";

$id_doc=$_POST['id_doc'];
$auteur= $_POST['auteur'];
$titre= $_POST['titre'];
$descript= $_POST['descript'];
$qte= $_POST['qte'];
$nom_type= $_POST['nom_type'];

if( isset($_FILES['newImage']) ){
    $location="./Documents/";
    $img = $_FILES['newImage']['name'];
    $tmp = $_FILES['newImage']['tmp_name'];
    $dir = '../Documents/';
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif','webp');
    $image =rand(1000,1000000).".".$ext;
    $final_image=$location. $image;
    if (in_array($ext, $valid_extensions)) {
        $path = UPLOAD_PATH . $image;
        move_uploaded_file($tmp, $dir.$image);
    }
}else{
    $final_image=$_POST['existingImage'];
}

$updateItem = mysqli_query($conn,"UPDATE document SET 
    auteur='$auteur', 
    titre='$titre',
    descript='$descript',
    qte=$qte,
    nom_type='$nom_type',
    doc_img='$final_image' 
    WHERE id_doc=$id_doc");

if ($updateItem) {
    echo "Document infos Update Success.";
} else {
    echo "Document infos Update Failed: " . mysqli_error($conn);
}
?>
